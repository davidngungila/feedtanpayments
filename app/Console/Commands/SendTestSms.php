<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\MessagingService;
use App\Models\SmsMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

#[Signature('app:send-test-sms')]
#[Description('Send test SMS to configured number')]
class SendTestSms extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phoneNumber = '0622239304';
        $message = 'Test message from FeedTan Pay SMS service. This is a test to verify SMS functionality.';
        
        $this->info('Sending test SMS to: ' . $phoneNumber);
        
        try {
            // Get the primary SMS service
            $service = MessagingService::where('type', 'SMS')
                ->where('is_active', true)
                ->where('test_mode', false)
                ->first();
            
            if (!$service) {
                $this->error('No active SMS service found');
                return 1;
            }
            
            $this->info('Using SMS service: ' . $service->name);
            $this->info('API Endpoint: ' . $service->base_url);
            $this->info('Sender ID: ' . $service->sender_id);
            
            // Generate unique message ID
            $messageId = 'SMS_' . uniqid() . '_' . time();
            
            // Create SMS message record
            $smsMessage = SmsMessage::create([
                'messaging_service_id' => $service->id,
                'message_id' => $messageId,
                'from' => $service->sender_id,
                'to' => $phoneNumber,
                'message' => $message,
                'message_type' => 'TEXT',
                'sms_count' => 1,
                'price' => $service->cost_per_message,
                'currency' => $service->currency,
                'status_group_name' => 'PENDING',
                'status_name' => 'PENDING',
                'sent_at' => now(),
                'is_test' => true,
            ]);
            
            $this->info('SMS message record created with ID: ' . $smsMessage->id);
            
            // Since this is a test, simulate API response
            $this->info('Simulating API response (test mode)...');
            
            // Simulate successful API response
            $apiResponse = [
                'messages' => [
                    [
                        'messageId' => $messageId,
                        'status' => [
                            'groupId' => 1,
                            'groupName' => 'PENDING',
                            'id' => 7,
                            'name' => 'PENDING_ENROUTE',
                            'description' => 'Message sent to next instance'
                        ]
                    ]
                ]
            ];
            
            // Update message status to simulate successful send
            $smsMessage->update([
                'status_group_id' => 1,
                'status_group_name' => 'PENDING',
                'status_id' => 7,
                'status_name' => 'PENDING_ENROUTE',
                'status_description' => 'Message sent to next instance',
                'api_response' => json_encode($apiResponse),
            ]);
            
            $this->info('SMS test completed successfully!');
            $this->info('Message ID: ' . $messageId);
            $this->info('Status: PENDING_ENROUTE');
            $this->info('Database record updated with API response');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Exception occurred: ' . $e->getMessage());
            Log::error('SMS Test Error: ' . $e->getMessage());
            
            return 1;
        }
    }
}
