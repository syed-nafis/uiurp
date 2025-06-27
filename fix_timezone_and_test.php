<?php
/**
 * Fix timezone and test meeting notification
 */

require_once 'src/model/send_system_chat_message_helper.php';
require_once 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

$meetingId = "685d9d26ba6cd85bd3043955";
$projectId = "685551a4793d650a9900a57f";

echo "<h1>Timezone Fix and Meeting Test</h1>\n";

// Show current server timezone and time
echo "<h3>Server Timezone Information</h3>\n";
echo "Server timezone: " . date_default_timezone_get() . "\n";
echo "Server time: " . date('Y-m-d H:i:s') . "\n";
echo "Server UTC time: " . gmdate('Y-m-d H:i:s') . "\n";

// Your reported time
echo "\nYour reported time: 2025-06-27 02:08:00\n";

// Calculate the difference
$serverTime = new DateTime();
$yourTime = new DateTime('2025-06-27 02:08:00');
$diff = $serverTime->diff($yourTime);
echo "Time difference: " . $diff->format('%h hours %i minutes') . "\n\n";

// Option 1: Fix the server timezone temporarily
echo "<h3>Option 1: Temporary Timezone Fix</h3>\n";
try {
    // Try different timezones that might match your location
    $possibleTimezones = [
        'Asia/Dhaka',      // Bangladesh (UTC+6)
        'Asia/Kolkata',    // India (UTC+5:30)
        'Asia/Karachi',    // Pakistan (UTC+5)
        'America/New_York', // Eastern US (UTC-5/-4)
        'Europe/London',   // UK (UTC+0/+1)
        'UTC'              // UTC
    ];
    
    foreach ($possibleTimezones as $tz) {
        date_default_timezone_set($tz);
        echo "$tz: " . date('Y-m-d H:i:s') . "\n";
    }
    
    // Set to a timezone that matches your time (approximately)
    date_default_timezone_set('Asia/Dhaka'); // UTC+6, which might be close
    echo "\nSet server timezone to Asia/Dhaka\n";
    echo "New server time: " . date('Y-m-d H:i:s') . "\n\n";
    
} catch (Exception $e) {
    echo "Timezone error: " . $e->getMessage() . "\n";
}

// Option 2: Manual notification test (regardless of timezone)
echo "<h3>Option 2: Manual Notification Test</h3>\n";

try {
    $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $client->uiurp;
    $meetingsCollection = $db->project_meetings;
    
    $meeting = $meetingsCollection->findOne(['_id' => new ObjectId($meetingId)]);
    
    if ($meeting) {
        echo "Meeting found: " . $meeting['title'] . "\n";
        echo "Sending LIVE meeting notification...\n";
        
        // Send live meeting notification
        $result = sendMeetingStartedMessage(
            $projectId,
            $meeting['title'],
            $meeting['meetingLink'] ?? ''
        );
        
        if ($result['success']) {
            echo "✅ SUCCESS: Live meeting notification sent!\n";
            echo "Message ID: " . ($result['messageId'] ?? 'N/A') . "\n";
            echo "\nCheck your project chat at: Project_details.php?id=$projectId\n";
        } else {
            echo "❌ FAILED: " . $result['message'] . "\n";
        }
        
    } else {
        echo "❌ Meeting not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n<h3>Recommended Actions</h3>\n";
echo "1. <strong>Immediate fix</strong>: The manual notification above should work regardless of timezone\n";
echo "2. <strong>Long-term fix</strong>: Configure your server timezone to match your location\n";
echo "3. <strong>Test</strong>: Check Project_details.php?id=$projectId for the system message\n\n";

echo "<h3>Server Configuration Fix</h3>\n";
echo "Add this to your PHP configuration or at the top of your main files:\n";
echo "<code>date_default_timezone_set('Your/Timezone');</code>\n";
echo "\nCommon timezones:\n";
echo "- Asia/Dhaka (Bangladesh)\n";
echo "- Asia/Kolkata (India)\n";
echo "- America/New_York (Eastern US)\n";
echo "- Europe/London (UK)\n";
?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h1, h3 { color: #333; }
    code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
</style> 