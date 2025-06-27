<?php
/**
 * Debug script for meeting notification issues
 * Tests why a specific meeting isn't triggering notifications
 */

require_once 'src/model/send_meeting_notifications.php';
require_once 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// The specific meeting from the user
$meetingId = "685d9d26ba6cd85bd3043955";
$projectId = "685551a4793d650a9900a57f";

echo "<h1>Meeting Notification Debug</h1>\n";
echo "<h2>Testing Meeting ID: $meetingId</h2>\n";

// Current time info
$now = new DateTime();
echo "<h3>Current Time Information</h3>\n";
echo "Current datetime: " . $now->format('Y-m-d H:i:s') . "\n";
echo "Current date: " . $now->format('Y-m-d') . "\n";
echo "Current time: " . $now->format('H:i') . "\n";
echo "\n";

// Connect to database and get the meeting
try {
    $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $client->uiurp;
    $meetingsCollection = $db->project_meetings;
    $notificationsCollection = $db->meeting_notifications;
    
    // Find the specific meeting
    $meeting = $meetingsCollection->findOne(['_id' => new ObjectId($meetingId)]);
    
    if ($meeting) {
        echo "<h3>Meeting Details</h3>\n";
        echo "Title: " . $meeting['title'] . "\n";
        echo "Date: " . $meeting['date'] . "\n";
        echo "Start Time: " . $meeting['startTime'] . "\n";
        echo "End Time: " . $meeting['endTime'] . "\n";
        echo "Status: " . $meeting['status'] . "\n";
        echo "Project ID: " . (string)$meeting['projectId'] . "\n";
        echo "\n";
        
        // Check each scenario
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('H:i');
        
        echo "<h3>Scenario Analysis</h3>\n";
        
        // 1. Check URGENT scenario (5 minutes before)
        echo "<strong>1. URGENT Scenario (5 minutes before start):</strong>\n";
        $notificationTime = new DateTime();
        $notificationTime->add(new DateInterval('PT5M'));
        $notificationTimeStr = $notificationTime->format('H:i');
        
        $urgentMatch = (
            $meeting['date'] === $currentDate &&
            $meeting['status'] !== 'Cancelled' &&
            $meeting['startTime'] >= $currentTime &&
            $meeting['startTime'] <= $notificationTimeStr
        );
        
        echo "  Date match (today): " . ($meeting['date'] === $currentDate ? 'YES' : 'NO') . " ({$meeting['date']} vs $currentDate)\n";
        echo "  Status not cancelled: " . ($meeting['status'] !== 'Cancelled' ? 'YES' : 'NO') . " ({$meeting['status']})\n";
        echo "  Start time >= current: " . ($meeting['startTime'] >= $currentTime ? 'YES' : 'NO') . " ({$meeting['startTime']} vs $currentTime)\n";
        echo "  Start time <= notification window: " . ($meeting['startTime'] <= $notificationTimeStr ? 'YES' : 'NO') . " ({$meeting['startTime']} vs $notificationTimeStr)\n";
        echo "  <strong>URGENT MATCH: " . ($urgentMatch ? 'YES' : 'NO') . "</strong>\n\n";
        
        // 2. Check LIVE scenario (currently happening)
        echo "<strong>2. LIVE Scenario (currently happening):</strong>\n";
        $liveMatch = (
            $meeting['date'] === $currentDate &&
            $meeting['status'] !== 'Cancelled' &&
            $meeting['startTime'] <= $currentTime &&
            $meeting['endTime'] >= $currentTime
        );
        
        echo "  Date match (today): " . ($meeting['date'] === $currentDate ? 'YES' : 'NO') . " ({$meeting['date']} vs $currentDate)\n";
        echo "  Status not cancelled: " . ($meeting['status'] !== 'Cancelled' ? 'YES' : 'NO') . " ({$meeting['status']})\n";
        echo "  Start time <= current: " . ($meeting['startTime'] <= $currentTime ? 'YES' : 'NO') . " ({$meeting['startTime']} vs $currentTime)\n";
        echo "  End time >= current: " . ($meeting['endTime'] >= $currentTime ? 'YES' : 'NO') . " ({$meeting['endTime']} vs $currentTime)\n";
        echo "  <strong>LIVE MATCH: " . ($liveMatch ? 'YES' : 'NO') . "</strong>\n\n";
        
        // 3. Check DAILY scenario (scheduled today)
        echo "<strong>3. DAILY Scenario (scheduled today):</strong>\n";
        $dailyMatch = (
            $meeting['date'] === $currentDate &&
            $meeting['status'] !== 'Cancelled'
        );
        
        echo "  Date match (today): " . ($meeting['date'] === $currentDate ? 'YES' : 'NO') . " ({$meeting['date']} vs $currentDate)\n";
        echo "  Status not cancelled: " . ($meeting['status'] !== 'Cancelled' ? 'YES' : 'NO') . " ({$meeting['status']})\n";
        echo "  <strong>DAILY MATCH: " . ($dailyMatch ? 'YES' : 'NO') . "</strong>\n\n";
        
        // Check for existing notifications
        echo "<h3>Existing Notifications Check</h3>\n";
        
        $scenarios = ['urgent', 'live', 'daily'];
        foreach ($scenarios as $scenario) {
            $notificationKey = '';
            if ($scenario === 'urgent') {
                $notificationKey = 'urgent_' . $currentDate . '_' . $meetingId;
            } elseif ($scenario === 'live') {
                $notificationKey = 'live_' . $currentDate . '_' . substr($currentTime, 0, 2) . '_' . $meetingId;
            } elseif ($scenario === 'daily') {
                $notificationKey = 'daily_' . $currentDate . '_' . $meetingId;
            }
            
            $existingNotification = $notificationsCollection->findOne([
                'notificationKey' => $notificationKey
            ]);
            
            echo "  $scenario notification exists: " . ($existingNotification ? 'YES' : 'NO') . " (key: $notificationKey)\n";
        }
        echo "\n";
        
        // Test the actual notification function
        echo "<h3>Testing Notification Functions</h3>\n";
        
        if ($liveMatch) {
            echo "<strong>Testing LIVE notification (since meeting is currently happening):</strong>\n";
            $result = checkAndSendMeetingNotifications($projectId, 'live');
            echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n\n";
        }
        
        if ($urgentMatch) {
            echo "<strong>Testing URGENT notification:</strong>\n";
            $result = checkAndSendMeetingNotifications($projectId, 'urgent');
            echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n\n";
        }
        
        if ($dailyMatch) {
            echo "<strong>Testing DAILY notification:</strong>\n";
            $result = checkAndSendMeetingNotifications($projectId, 'daily');
            echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n\n";
        }
        
        // Test all scenarios
        echo "<strong>Testing ALL scenarios:</strong>\n";
        $result = checkAndSendMeetingNotifications($projectId, 'all');
        echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n\n";
        
    } else {
        echo "ERROR: Meeting not found in database!\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "<h3>Manual Test Links</h3>\n";
echo "<a href='src/model/send_meeting_notifications.php?projectId=$projectId&notificationType=live' target='_blank'>Test LIVE notifications</a><br>\n";
echo "<a href='src/model/send_meeting_notifications.php?projectId=$projectId&notificationType=urgent' target='_blank'>Test URGENT notifications</a><br>\n";
echo "<a href='src/model/send_meeting_notifications.php?projectId=$projectId&notificationType=daily' target='_blank'>Test DAILY notifications</a><br>\n";
echo "<a href='src/model/send_meeting_notifications.php?projectId=$projectId&notificationType=all' target='_blank'>Test ALL notifications</a><br>\n";
?> 