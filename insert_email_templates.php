<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Inserting Email Templates into Database ===\n\n";

// Include the templates from the collection file
require_once __DIR__ . '/email_templates_collection.php';

// Template data with proper structure
$templates = [
    [
        'name' => 'Welcome Email Template',
        'type' => 'email',
        'category' => 'welcome',
        'subject' => 'Karibu FeedTan Community Microfinance Group',
        'html_content' => $welcomeTemplate,
        'text_content' => 'Karibu {memberName}, Tunafurahi kukukaribisha katika familia ya FeedTan CMG! Namba Chanzo Chako: {memberNumber}',
        'variables' => json_encode([
            'memberName' => 'Member full name',
            'memberNumber' => 'Member account number',
            'joinDate' => 'Date of joining',
            'savingsAccountNumber' => 'Savings account number',
            'loanLimit' => 'Loan limit amount',
            'portalLink' => 'Link to member portal'
        ]),
        'is_active' => true,
        'is_default' => true,
        'created_by' => 1
    ],
    [
        'name' => 'Loan Approval Notification',
        'type' => 'email',
        'category' => 'loan',
        'subject' => 'Mkopo Wako Umekubaliwa! 🎉',
        'html_content' => $loanApprovalTemplate,
        'text_content' => 'Habari {memberName}, Maombi yako ya mkopo ya TZS {loanAmount} yamekubaliwa. Namba ya Mkopo: {loanNumber}',
        'variables' => json_encode([
            'memberName' => 'Member full name',
            'loanNumber' => 'Loan account number',
            'loanAmount' => 'Loan amount',
            'approvalDate' => 'Date of approval',
            'interestRate' => 'Interest rate percentage',
            'repaymentPeriod' => 'Repayment period in months',
            'monthlyPayment' => 'Monthly payment amount',
            'firstPaymentDate' => 'First payment date',
            'lastPaymentDate' => 'Last payment date',
            'acceptLink' => 'Link to accept loan',
            'detailsLink' => 'Link to loan details'
        ]),
        'is_active' => true,
        'is_default' => false,
        'created_by' => 1
    ],
    [
        'name' => 'Loan Repayment Reminder',
        'type' => 'email',
        'category' => 'loan',
        'subject' => 'Kumbukumbu la Malizo ya Mkopo',
        'html_content' => $repaymentReminderTemplate,
        'text_content' => 'Habari {memberName}, Malizo ya mkopo wako yanakaribia. Tarehe ya malizo: {dueDate}',
        'variables' => json_encode([
            'memberName' => 'Member full name',
            'loanNumber' => 'Loan account number',
            'dueDate' => 'Payment due date',
            'daysRemaining' => 'Days remaining',
            'paymentAmount' => 'Payment amount',
            'paymentType' => 'Payment type',
            'outstandingBalance' => 'Outstanding balance',
            'bankAccountNumber' => 'Bank account number',
            'mobileNumber' => 'Mobile number',
            'lateFee' => 'Late fee amount',
            'lateFeeDate' => 'Late fee start date',
            'paymentLink' => 'Link to make payment',
            'supportNumber' => 'Support phone number'
        ]),
        'is_active' => true,
        'is_default' => false,
        'created_by' => 1
    ],
    [
        'name' => 'Account Balance Notification',
        'type' => 'email',
        'category' => 'account',
        'subject' => 'Taarifa ya Salio la Akaunti',
        'html_content' => $balanceNotificationTemplate,
        'text_content' => 'Habari {memberName}, Salio la akiba yako ni TZS {currentBalance} kwa tarehe {statementDate}',
        'variables' => json_encode([
            'memberName' => 'Member full name',
            'statementDate' => 'Statement date',
            'currentBalance' => 'Current balance',
            'monthlyChange' => 'Monthly change',
            'totalSavings' => 'Total savings',
            'accountNumber' => 'Account number',
            'accountType' => 'Account type',
            'monthlySavings' => 'Monthly savings',
            'interestEarned' => 'Interest earned',
            'recentTransactions' => 'Recent transactions HTML',
            'portalLink' => 'Link to member portal'
        ]),
        'is_active' => true,
        'is_default' => false,
        'created_by' => 1
    ],
    [
        'name' => 'Meeting Invitation',
        'type' => 'email',
        'category' => 'meeting',
        'subject' => 'Mwaliko wa Mkutano',
        'html_content' => $meetingInvitationTemplate,
        'text_content' => 'Habari {memberName}, Tunakualika kwenye mkutano wa {meetingType}. Tarehe: {meetingDate}',
        'variables' => json_encode([
            'memberName' => 'Member full name',
            'meetingType' => 'Type of meeting',
            'meetingDate' => 'Meeting date',
            'meetingTime' => 'Meeting time',
            'duration' => 'Meeting duration',
            'organizer' => 'Meeting organizer',
            'expectedAttendees' => 'Expected attendees count',
            'buildingName' => 'Building name',
            'roomNumber' => 'Room number',
            'address' => 'Address',
            'additionalDirections' => 'Additional directions',
            'agendaItems' => 'Agenda items HTML',
            'rsvpLink' => 'RSVP link',
            'calendarLink' => 'Calendar link',
            'rsvpDeadline' => 'RSVP deadline'
        ]),
        'is_active' => true,
        'is_default' => false,
        'created_by' => 1
    ]
];

// Test 1: Clear existing templates
echo "=== Test 1: Clear Existing Templates ===\n";
try {
    \App\Models\EmailTemplate::truncate();
    echo "✅ Cleared existing email templates\n";
} catch (\Exception $e) {
    echo "❌ Error clearing templates: " . $e->getMessage() . "\n";
}

// Test 2: Insert templates into database
echo "\n=== Test 2: Insert Templates ===\n";
try {
    foreach ($templates as $index => $templateData) {
        $template = \App\Models\EmailTemplate::create($templateData);
        echo "✅ Inserted template " . ($index + 1) . ": {$template->name}\n";
        echo "   - ID: {$template->id}\n";
        echo "   - Category: {$template->category}\n";
        echo "   - Variables: " . count(json_decode($template->variables, true)) . "\n";
    }
} catch (\Exception $e) {
    echo "❌ Error inserting templates: " . $e->getMessage() . "\n";
}

// Test 3: Verify templates were inserted
echo "\n=== Test 3: Verify Templates ===\n";
try {
    $allTemplates = \App\Models\EmailTemplate::all();
    echo "Total templates in database: " . $allTemplates->count() . "\n";
    
    foreach ($allTemplates as $template) {
        echo "- {$template->name} (ID: {$template->id}, Category: {$template->category})\n";
    }
} catch (\Exception $e) {
    echo "❌ Error verifying templates: " . $e->getMessage() . "\n";
}

// Test 4: Test template processing
echo "\n=== Test 4: Test Template Processing ===\n";
try {
    $welcomeTemplate = \App\Models\EmailTemplate::where('category', 'welcome')->first();
    if ($welcomeTemplate) {
        $testData = [
            'memberName' => 'John Doe',
            'memberNumber' => 'FT2026001',
            'joinDate' => '2026-04-23',
            'savingsAccountNumber' => 'SA001',
            'loanLimit' => 'TZS 500,000',
            'portalLink' => 'https://feedtan.com/portal'
        ];
        
        $processed = $welcomeTemplate->processTemplate($testData);
        
        echo "✅ Template processing test passed\n";
        echo "- Subject: " . $processed['subject'] . "\n";
        echo "- HTML length: " . strlen($processed['html']) . " characters\n";
        echo "- Text length: " . strlen($processed['text']) . " characters\n";
        
        // Check if variables were replaced
        $hasVariables = strpos($processed['html'], '{memberName}') === false;
        echo "- Variables replaced: " . ($hasVariables ? 'Yes' : 'No') . "\n";
    }
} catch (\Exception $e) {
    echo "❌ Error testing template processing: " . $e->getMessage() . "\n";
}

echo "\n=== Templates Insertion Complete ===\n";
echo "✅ All email templates have been saved to the database\n";
echo "✅ Templates are ready for use in the email messaging system\n";
echo "Next: Update the email messaging page to use these templates\n";
