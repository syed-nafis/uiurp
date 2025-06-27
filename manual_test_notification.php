<?php
/**
 * Manual test notification script
 * Sends a test notification for a specific meeting
 */

require_once 'src/model/send_system_chat_message_helper.php';
require_once 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meetingId = $_POST['meetingId'] ?? '';
    $projectId = $_POST['projectId'] ?? '';
    
    echo "<h1>Manual Meeting Notification Test</h1>\n";
    
    if (empty($meetingId) || empty($projectId)) {
        echo "❌ ERROR: Missing meeting ID or project ID\n";
        exit;
    }
    
    try {
        // Connect to database and get meeting details
        $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
        $db = $client->uiurp;
        $meetingsCollection = $db->project_meetings;
        
        $meeting = $meetingsCollection->findOne(['_id' => new ObjectId($meetingId)]);
        
        if (!$meeting) {
            echo "❌ ERROR: Meeting not found\n";
            exit;
        }
        
        echo "<h3>Meeting Details</h3>\n";
        echo "Title: " . $meeting['title'] . "\n";
        echo "Date: " . $meeting['date'] . "\n";
        echo "Start Time: " . $meeting['startTime'] . "\n";
        echo "End Time: " . $meeting['endTime'] . "\n";
        echo "Project ID: $projectId\n\n";
        
        // Test different notification types
        $results = [];
        
        // 1. Test LIVE notification
        echo "<h3>Testing LIVE Notification</h3>\n";
        $liveResult = sendMeetingStartedMessage(
            $projectId, 
            $meeting['title'], 
            $meeting['meetingLink'] ?? ''
        );
        $results['live'] = $liveResult;
        echo "Live notification result: " . ($liveResult['success'] ? '✅ SUCCESS' : '❌ FAILED') . "\n";
        if (!$liveResult['success']) {
            echo "Error: " . $liveResult['message'] . "\n";
        } else {
            echo "Message sent! Message ID: " . ($liveResult['messageId'] ?? 'N/A') . "\n";
        }
        echo "\n";
        
        // 2. Test URGENT notification
        echo "<h3>Testing URGENT Notification</h3>\n";
        $urgentResult = sendMeetingNotificationMessage(
            $projectId, 
            $meeting['title'], 
            $meeting['startTime'], 
            $meeting['meetingLink'] ?? '', 
            $meeting['date']
        );
        $results['urgent'] = $urgentResult;
        echo "Urgent notification result: " . ($urgentResult['success'] ? '✅ SUCCESS' : '❌ FAILED') . "\n";
        if (!$urgentResult['success']) {
            echo "Error: " . $urgentResult['message'] . "\n";
        } else {
            echo "Message sent! Message ID: " . ($urgentResult['messageId'] ?? 'N/A') . "\n";
        }
        echo "\n";
        
        // 3. Test DAILY notification  
        echo "<h3>Testing DAILY Notification</h3>\n";
        $dailyResult = sendDailyMeetingReminder(
            $projectId, 
            $meeting['title'], 
            $meeting['startTime'], 
            $meeting['endTime'] ?? '', 
            $meeting['meetingLink'] ?? '', 
            $meeting['date']
        );
        $results['daily'] = $dailyResult;
        echo "Daily notification result: " . ($dailyResult['success'] ? '✅ SUCCESS' : '❌ FAILED') . "\n";
        if (!$dailyResult['success']) {
            echo "Error: " . $dailyResult['message'] . "\n";
        } else {
            echo "Message sent! Message ID: " . ($dailyResult['messageId'] ?? 'N/A') . "\n";
        }
        echo "\n";
        
        // Summary
        echo "<h3>Summary</h3>\n";
        $successCount = 0;
        foreach ($results as $type => $result) {
            if ($result['success']) $successCount++;
        }
        
        echo "Notifications sent: $successCount / 3\n";
        echo "Check your project chat to see the system messages!\n\n";
        
        echo "<h3>Next Steps</h3>\n";
        echo "1. Go to Project_details.php?id=$projectId\n";
        echo "2. Check the project chat for system messages\n";
        echo "3. If you see the messages, the notification system is working!\n";
        
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "<h1>Manual Meeting Notification Test</h1>\n";
    echo "<p>This page should be accessed via POST from the fix_meeting_date.php form.</p>\n";
    echo "<a href='fix_meeting_date.php'>Go back to fix meeting date</a>\n";
}
?> 