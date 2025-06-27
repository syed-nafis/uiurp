<?php
/**
 * Test script for meeting notification system
 * This script helps test the meeting notification functionality
 */

require_once 'src/model/send_meeting_notifications.php';
require_once 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Test the meeting notification system
function testMeetingNotifications() {
    echo "<h2>Testing Meeting Notification System</h2>\n";
    
    // Test 1: Check current time and format
    echo "<h3>Test 1: Current Time Check</h3>\n";
    $now = new DateTime();
    echo "Current time: " . $now->format('Y-m-d H:i:s') . "\n";
    echo "Current date: " . $now->format('Y-m-d') . "\n";
    echo "Current time (H:i): " . $now->format('H:i') . "\n";
    
    // Test 2: Create a test meeting (for testing purposes)
    echo "<h3>Test 2: Create Test Meeting</h3>\n";
    
    // Calculate time 6 minutes from now for testing
    $testTime = new DateTime();
    $testTime->add(new DateInterval('PT6M'));
    $testDate = $testTime->format('Y-m-d');
    $testStartTime = $testTime->format('H:i');
    
    echo "Test meeting date: $testDate\n";
    echo "Test meeting start time: $testStartTime\n";
    
    // Test 3: Run notification check (All scenarios)
    echo "<h3>Test 3: Run All Notification Scenarios</h3>\n";
    
    try {
        $scenarios = ['urgent', 'live', 'daily', 'all'];
        
        foreach ($scenarios as $scenario) {
            echo "\n--- Testing $scenario notifications ---\n";
            $result = checkAndSendMeetingNotifications(null, $scenario);
            
            echo "Scenario: $scenario\n";
            echo "Success: " . ($result['success'] ? 'Yes' : 'No') . "\n";
            echo "Notifications sent: " . $result['notifications_sent'] . "\n";
            echo "Notification types: " . json_encode($result['notification_types'] ?? []) . "\n";
            echo "Errors: " . count($result['errors']) . "\n";
            echo "Processed meetings: " . count($result['processed_meetings']) . "\n";
            
            if (!empty($result['processed_meetings'])) {
                echo "Processed Meetings:\n";
                foreach ($result['processed_meetings'] as $meeting) {
                    echo "  - {$meeting['title']} at {$meeting['startTime']} (Type: {$meeting['scenarioType']}, Status: {$meeting['status']})\n";
                }
            }
            
            if (!empty($result['errors'])) {
                echo "Errors:\n";
                foreach ($result['errors'] as $error) {
                    echo "  - {$error['title']}: {$error['error']}\n";
                }
            }
            echo "\n";
        }
        
    } catch (Exception $e) {
        echo "Error running notification check: " . $e->getMessage() . "\n";
    }
    
    // Test 4: Database connection test
    echo "<h3>Test 4: Database Connection Test</h3>\n";
    
    try {
        $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
        $db = $client->uiurp;
        $meetingsCollection = $db->project_meetings;
        
        // Count total meetings
        $totalMeetings = $meetingsCollection->countDocuments();
        echo "Total meetings in database: $totalMeetings\n";
        
        // Count today's meetings
        $todayMeetings = $meetingsCollection->countDocuments(['date' => $now->format('Y-m-d')]);
        echo "Today's meetings: $todayMeetings\n";
        
        // Count upcoming meetings today
        $upcomingMeetings = $meetingsCollection->countDocuments([
            'date' => $now->format('Y-m-d'),
            'startTime' => ['$gte' => $now->format('H:i')],
            'status' => ['$ne' => 'Cancelled']
        ]);
        echo "Upcoming meetings today: $upcomingMeetings\n";
        
        // Show next few meetings
        echo "\nNext 5 meetings:\n";
        $cursor = $meetingsCollection->find(
            [
                'date' => ['$gte' => $now->format('Y-m-d')],
                'status' => ['$ne' => 'Cancelled']
            ],
            [
                'sort' => ['date' => 1, 'startTime' => 1],
                'limit' => 5
            ]
        );
        
        foreach ($cursor as $meeting) {
            echo "- {$meeting['title']} on {$meeting['date']} at {$meeting['startTime']}\n";
        }
        
    } catch (Exception $e) {
        echo "Database connection error: " . $e->getMessage() . "\n";
    }
}

// Run tests if accessed directly
if (basename($_SERVER['PHP_SELF']) == 'test_meeting_notifications.php') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Meeting Notification Test</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            pre { background: #f0f0f0; padding: 10px; border-radius: 5px; }
            h2, h3 { color: #333; }
        </style>
    </head>
    <body>
        <h1>Meeting Notification System Test</h1>
        <pre>
    <?php
    testMeetingNotifications();
    ?>
        </pre>
        
        <h3>Manual Test Options</h3>
        <p>
            <a href="src/model/send_meeting_notifications.php" target="_blank">Run Notification Check</a> |
            <a href="src/model/send_meeting_notifications.php?cleanup=true" target="_blank">Cleanup Old Notifications</a>
        </p>
        
        <h3>Usage Instructions</h3>
        <ul>
            <li>The notification system runs automatically when users visit Project_details.php</li>
            <li>It checks for meetings starting in the next 5 minutes</li>
            <li>System messages are sent to the project chat with meeting links</li>
            <li>Notifications are only sent once per meeting per day</li>
            <li>Old notification records are cleaned up automatically</li>
        </ul>
    </body>
    </html>
    <?php
}
?> 