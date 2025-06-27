<?php
/**
 * Fix meeting date for testing notifications
 */

require_once 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// The specific meeting from the user
$meetingId = "685d9d26ba6cd85bd3043955";

echo "<h1>Fix Meeting Date for Testing</h1>\n";

try {
    $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $client->uiurp;
    $meetingsCollection = $db->project_meetings;
    
    // Get current date
    $today = date('Y-m-d');
    
    echo "<h3>Updating Meeting Date</h3>\n";
    echo "Meeting ID: $meetingId\n";
    echo "New date: $today\n";
    
    // Update the meeting date to today
    $result = $meetingsCollection->updateOne(
        ['_id' => new ObjectId($meetingId)],
        ['$set' => ['date' => $today]]
    );
    
    if ($result->getModifiedCount() > 0) {
        echo "✅ SUCCESS: Meeting date updated to today ($today)\n";
        
        // Show updated meeting
        $meeting = $meetingsCollection->findOne(['_id' => new ObjectId($meetingId)]);
        echo "\nUpdated meeting details:\n";
        echo "Title: " . $meeting['title'] . "\n";
        echo "Date: " . $meeting['date'] . "\n";
        echo "Start Time: " . $meeting['startTime'] . "\n";
        echo "End Time: " . $meeting['endTime'] . "\n";
        echo "\n";
        
        echo "<h3>Test Notification Links</h3>\n";
        $projectId = (string)$meeting['projectId'];
        echo "<a href='src/model/send_meeting_notifications.php?projectId=$projectId&notificationType=live' target='_blank'>Test LIVE notification now</a><br>\n";
        echo "<a href='src/model/send_meeting_notifications.php?projectId=$projectId&notificationType=all' target='_blank'>Test ALL notifications</a><br>\n";
        echo "<a href='debug_meeting_notification.php' target='_blank'>Run debug script again</a><br>\n";
        
    } else {
        echo "❌ ERROR: No meeting was updated. Check if meeting ID exists.\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
?>

<hr>
<h3>Alternative: Manual Test</h3>
<p>If you want to test without changing the meeting date, you can manually trigger a notification:</p>

<form method="POST" action="manual_test_notification.php">
    <input type="hidden" name="meetingId" value="<?php echo $meetingId; ?>">
    <input type="hidden" name="projectId" value="685551a4793d650a9900a57f">
    <button type="submit">Send Test Notification Now</button>
</form> 