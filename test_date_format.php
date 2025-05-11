<?php
require __DIR__ . '/vendor/autoload.php';

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

try {
    // Connect to MongoDB
    $mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $mongoClient->uiurp;
    $collection = $db->projectsV2;

    // Fetch one project
    $project = $collection->findOne(['privacy' => 0]);

    if ($project) {
        echo "<h2>Project Date Format Test</h2>";
        
        echo "<h3>Created Date</h3>";
        echo "<p>Raw Value: <pre>" . print_r($project['createdAt'], true) . "</pre></p>";
        echo "<p>Type: " . gettype($project['createdAt']) . "</p>";
        
        if (is_object($project['createdAt'])) {
            echo "<p>Class: " . get_class($project['createdAt']) . "</p>";
        }
        
        echo "<h3>Date Conversion Tests</h3>";
        
        // Test 1: Direct conversion
        $test1 = $project['createdAt'];
        echo "<p>Test 1 (Direct): ";
        if ($test1 instanceof MongoDB\BSON\UTCDateTime) {
            echo "MongoDB UTCDateTime object detected</p>";
            echo "<p>To PHP DateTime: " . $test1->toDateTime()->format('Y-m-d H:i:s') . "</p>";
        } else {
            echo "Not a MongoDB UTCDateTime object</p>";
        }
        
        // Test 2: JSON encode/decode
        $json = json_encode($project);
        $decoded = json_decode($json, true);
        echo "<p>Test 2 (JSON encode/decode): <pre>" . print_r($decoded['createdAt'], true) . "</pre></p>";
        
        // Test successful date format
        echo "<h3>Date Formatting Solutions</h3>";
        
        if ($project['createdAt'] instanceof MongoDB\BSON\UTCDateTime) {
            $dateTime = $project['createdAt']->toDateTime();
            echo "<p>Correct format: " . $dateTime->format('F j, Y') . "</p>";
        }
    } else {
        echo "<p>No projects found.</p>";
    }
} catch (Exception $e) {
    echo "<h2>Error</h2>";
    echo "<p>Connection failed: " . $e->getMessage() . "</p>";
}
?> 