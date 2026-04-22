<?php

namespace App\Http\Controllers;

use App\Models\MessagingService;
use App\Models\SmsMessage;
use App\Models\EmailMessage;
use App\Models\MessagingTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MessagingController extends Controller
{
    /**
     * Display messaging dashboard.
     */
    public function dashboard()
    {
        $smsServices = MessagingService::active()->byType('SMS')->get();
        $emailServices = MessagingService::active()->byType('EMAIL')->get();
        
        $recentSms = SmsMessage::with('messagingService')
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();
                              
        $recentEmails = EmailMessage::with('messagingService')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        $stats = [
            'total_sms' => SmsMessage::count(),
            'delivered_sms' => SmsMessage::delivered()->count(),
            'failed_sms' => SmsMessage::failed()->count(),
            'total_emails' => EmailMessage::count(),
            'delivered_emails' => EmailMessage::delivered()->count(),
            'opened_emails' => EmailMessage::opened()->count(),
            'failed_emails' => EmailMessage::failed()->count(),
        ];

        return view('messaging.dashboard', compact(
            'smsServices', 
            'emailServices', 
            'recentSms', 
            'recentEmails',
            'stats'
        ));
    }

    /**
     * Display SMS messaging page.
     */
    public function smsIndex()
    {
        $services = MessagingService::active()->byType('SMS')->get();
        $templates = MessagingTemplate::active()->forSms()->get();
        $messages = SmsMessage::with('messagingService', 'user')
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        return view('messaging.sms.index', compact('services', 'templates', 'messages'));
    }

    /**
     * Send SMS message.
     */
    public function sendSms(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:messaging_services,id',
            'to' => 'required|string',
            'message' => 'required|string|max:1600',
            'template_id' => 'nullable|exists:messaging_templates,id',
            'is_test' => 'boolean',
        ]);

        $service = MessagingService::findOrFail($request->service_id);
        
        if (!$service->isReady()) {
            return response()->json([
                'success' => false,
                'message' => 'Messaging service is not properly configured'
            ], 400);
        }

        // Process template if provided
        $messageText = $request->message;
        if ($request->template_id) {
            $template = MessagingTemplate::find($request->template_id);
            $processed = $template->process($request->variables ?? []);
            $messageText = $processed['content'];
            $template->incrementUsage();
        }

        // Create SMS message record
        $smsMessage = SmsMessage::create([
            'messaging_service_id' => $service->id,
            'user_id' => auth()->id(),
            'message_id' => 'SMS_' . Str::random(20),
            'from' => $service->sender_id ?? 'FeedTanPay',
            'to' => $this->formatPhoneNumber($request->to),
            'message' => $messageText,
            'message_type' => 'TEXT',
            'sms_count' => $this->calculateSmsCount($messageText),
            'price' => $service->cost_per_message,
            'currency' => $service->currency,
            'is_test' => $request->boolean('is_test', false),
        ]);

        // Send via API
        $response = $this->sendSmsViaApi($service, $smsMessage);

        if ($response['success']) {
            $smsMessage->update([
                'status_group_id' => $response['status']['groupId'] ?? 18,
                'status_group_name' => $response['status']['groupName'] ?? 'PENDING',
                'status_id' => $response['status']['id'] ?? 51,
                'status_name' => $response['status']['name'] ?? 'ENROUTE (SENT)',
                'status_description' => $response['status']['description'] ?? 'Message sent to next instance',
                'sent_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'SMS sent successfully',
                'data' => $smsMessage
            ]);
        } else {
            $smsMessage->update([
                'status_group_name' => 'FAILED',
                'status_name' => 'FAILED_API_ERROR',
                'status_description' => $response['error'],
                'failed_at' => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send SMS: ' . $response['error']
            ], 500);
        }
    }

    /**
     * Display Email messaging page.
     */
    public function emailIndex()
    {
        $services = MessagingService::active()->byType('EMAIL')->get();
        $templates = MessagingTemplate::active()->forEmail()->get();
        $messages = EmailMessage::with('messagingService', 'user')
                               ->orderBy('created_at', 'desc')
                               ->paginate(20);

        return view('messaging.email.index', compact('services', 'templates', 'messages'));
    }

    /**
     * Send Email message.
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:messaging_services,id',
            'to_email' => 'required|email',
            'to_name' => 'nullable|string|max:100',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'body_text' => 'nullable|string',
            'template_id' => 'nullable|exists:messaging_templates,id',
            'is_test' => 'boolean',
        ]);

        $service = MessagingService::findOrFail($request->service_id);
        
        if (!$service->isReady()) {
            return response()->json([
                'success' => false,
                'message' => 'Messaging service is not properly configured'
            ], 400);
        }

        // Process template if provided
        $subject = $request->subject;
        $bodyHtml = $request->body_html;
        $bodyText = $request->body_text;

        if ($request->template_id) {
            $template = MessagingTemplate::find($request->template_id);
            $processed = $template->process($request->variables ?? []);
            $subject = $processed['subject'] ?? $subject;
            $bodyHtml = $processed['content'] ?? $bodyHtml;
            $template->incrementUsage();
        }

        // Create Email message record
        $emailMessage = EmailMessage::create([
            'messaging_service_id' => $service->id,
            'user_id' => auth()->id(),
            'message_id' => 'EMAIL_' . Str::random(20),
            'from_name' => 'FeedTan Pay',
            'from_email' => 'noreply@feedtanpay.co.tz',
            'to_email' => $request->to_email,
            'to_name' => $request->to_name,
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => $bodyText,
            'is_test' => $request->boolean('is_test', false),
        ]);

        // Send via API
        $response = $this->sendEmailViaApi($service, $emailMessage);

        if ($response['success']) {
            $emailMessage->update([
                'status_group_id' => $response['status']['groupId'] ?? 18,
                'status_group_name' => $response['status']['groupName'] ?? 'PENDING',
                'status_id' => $response['status']['id'] ?? 51,
                'status_name' => $response['status']['name'] ?? 'ENROUTE (SENT)',
                'status_description' => $response['status']['description'] ?? 'Message sent to next instance',
                'sent_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully',
                'data' => $emailMessage
            ]);
        } else {
            $emailMessage->update([
                'status_group_name' => 'FAILED',
                'status_name' => 'FAILED_API_ERROR',
                'status_description' => $response['error'],
                'failed_at' => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send Email: ' . $response['error']
            ], 500);
        }
    }

    /**
     * Send SMS via Messaging Service API V2.
     */
    private function sendSmsViaApi(MessagingService $service, SmsMessage $smsMessage): array
    {
        try {
            $endpoint = $service->test_mode 
                ? $service->getApiEndpoint('sms/test/text/single')
                : $service->getApiEndpoint('sms/text/single');

            $payload = [
                'from' => $smsMessage->from,
                'to' => $smsMessage->to,
                'text' => $smsMessage->message,
            ];

            $response = Http::withHeaders($service->getApiHeaders())
                            ->post($endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['messages'][0])) {
                    return [
                        'success' => true,
                        'status' => $data['messages'][0]['status'] ?? [],
                        'message_id' => $data['messages'][0]['messageId'] ?? null,
                    ];
                }
            }

            return [
                'success' => false,
                'error' => $response->body() ?: 'Unknown API error'
            ];

        } catch (\Exception $e) {
            Log::error('SMS API Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send Email via Messaging Service API V2.
     */
    private function sendEmailViaApi(MessagingService $service, EmailMessage $emailMessage): array
    {
        try {
            $endpoint = $service->test_mode 
                ? $service->getApiEndpoint('email/test/text/single')
                : $service->getApiEndpoint('email/text/single');

            $payload = [
                'from' => [
                    'name' => $emailMessage->from_name,
                    'email' => $emailMessage->from_email,
                ],
                'to' => [
                    'email' => $emailMessage->to_email,
                    'name' => $emailMessage->to_name,
                ],
                'subject' => $emailMessage->subject,
                'html' => $emailMessage->body_html,
                'text' => $emailMessage->body_text,
            ];

            $response = Http::withHeaders($service->getApiHeaders())
                            ->post($endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['messages'][0])) {
                    return [
                        'success' => true,
                        'status' => $data['messages'][0]['status'] ?? [],
                        'message_id' => $data['messages'][0]['messageId'] ?? null,
                    ];
                }
            }

            return [
                'success' => false,
                'error' => $response->body() ?: 'Unknown API error'
            ];

        } catch (\Exception $e) {
            Log::error('Email API Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number to international format.
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add Tanzania country code if missing
        if (strlen($phone) === 9 && str_starts_with($phone, '7')) {
            $phone = '255' . $phone;
        } elseif (strlen($phone) === 10 && str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }
        
        return $phone;
    }

    /**
     * Calculate SMS count based on message length.
     */
    private function calculateSmsCount(string $message): int
    {
        $length = strlen($message);
        return ceil($length / 160); // Standard SMS length
    }

    /**
     * Display messaging services management.
     */
    public function servicesIndex()
    {
        $services = MessagingService::withCount(['smsMessages', 'emailMessages'])
                                   ->orderBy('type')
                                   ->orderBy('name')
                                   ->paginate(20);

        return view('messaging.services.index', compact('services'));
    }

    /**
     * Store new messaging service.
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:SMS,EMAIL,WHATSAPP,MOBILE',
            'provider' => 'required|string|max:100',
            'base_url' => 'required|url',
            'bearer_token' => 'required_without:username,password|string',
            'username' => 'required_without:bearer_token|string',
            'password' => 'required_without:bearer_token|string',
            'sender_id' => 'nullable|string|max:100',
            'rate_limit_per_hour' => 'integer|min:1',
            'cost_per_message' => 'numeric|min:0',
            'currency' => 'string|size:3',
        ]);

        $service = MessagingService::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Messaging service created successfully',
            'data' => $service
        ]);
    }

    /**
     * Update messaging service.
     */
    public function updateService(Request $request, MessagingService $service)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:SMS,EMAIL,WHATSAPP,MOBILE',
            'provider' => 'required|string|max:100',
            'base_url' => 'required|url',
            'bearer_token' => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'sender_id' => 'nullable|string|max:100',
            'rate_limit_per_hour' => 'integer|min:1',
            'cost_per_message' => 'numeric|min:0',
            'currency' => 'string|size:3',
        ]);

        $service->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Messaging service updated successfully',
            'data' => $service
        ]);
    }

    /**
     * Test messaging service connection.
     */
    public function testService(MessagingService $service)
    {
        if (!$service->isReady()) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not properly configured'
            ], 400);
        }

        // Test with a simple message
        if ($service->type === 'SMS') {
            $testMessage = [
                'from' => $service->sender_id ?? 'TEST',
                'to' => '255700000000', // Test number
                'text' => 'Test message from FeedTan Pay',
            ];
            
            $endpoint = $service->getApiEndpoint('sms/test/text/single');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email testing not implemented yet'
            ], 400);
        }

        try {
            $response = Http::withHeaders($service->getApiHeaders())
                            ->post($endpoint, $testMessage);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service connection test successful',
                    'response' => $response->json()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Service connection failed',
                    'error' => $response->body()
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service connection error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
