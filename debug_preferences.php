<?php
session_start();
require_once 'src/model/user_preferences.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view debug information.";
    exit;
}

$userId = $_SESSION['user_id'];
$userPreferences = new UserPreferences();

echo "<h2>User Preferences Debug</h2>";
echo "<p>User ID: " . htmlspecialchars($userId) . "</p>";

// Get user profile
$profile = $userPreferences->getUserProfile($userId);
echo "<h3>User Profile:</h3>";
if ($profile) {
    // Convert MongoDB BSONDocument to array for JSON display
    $profileArray = [];
    foreach ($profile as $key => $value) {
        if ($value instanceof MongoDB\Model\BSONDocument) {
            $profileArray[$key] = iterator_to_array($value);
        } elseif ($value instanceof MongoDB\Model\BSONArray) {
            $profileArray[$key] = iterator_to_array($value);
        } else {
            $profileArray[$key] = $value;
        }
    }
    echo "<pre>" . json_encode($profileArray, JSON_PRETTY_PRINT) . "</pre>";
} else {
    echo "<p>No profile found.</p>";
}

// Get recent interactions
$interactions = $userPreferences->getUserInteractions($userId, 20);
echo "<h3>Recent Interactions (" . count($interactions) . "):</h3>";
if (!empty($interactions)) {
    foreach ($interactions as $interaction) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<strong>Type:</strong> " . htmlspecialchars($interaction['interaction_type']) . "<br>";
        echo "<strong>Item:</strong> " . htmlspecialchars($interaction['item_type']) . " - " . htmlspecialchars((string)$interaction['item_id']) . "<br>";
        echo "<strong>Timestamp:</strong> " . date('Y-m-d H:i:s', $interaction['timestamp']->toDateTime()->getTimestamp()) . "<br>";
        if (isset($interaction['metadata'])) {
            echo "<strong>Metadata:</strong> " . htmlspecialchars($interaction['metadata']) . "<br>";
        }
        echo "</div>";
    }
} else {
    echo "<p>No interactions found.</p>";
}

// Test metadata parsing
if (isset($_POST['test_metadata'])) {
    echo "<h3>Testing Metadata Processing:</h3>";
    $testMetadata = [
        'tags' => ['AI', 'Machine Learning', 'Research'],
        'keywords' => ['artificial', 'intelligence', 'neural', 'networks'],
        'specialty' => 'Computer Science',
        'researchInterests' => ['Deep Learning', 'NLP'],
        'eventType' => 'Workshop',
        'title' => 'Advanced Machine Learning Workshop'
    ];
    
    echo "<p>Test metadata:</p>";
    echo "<pre>" . json_encode($testMetadata, JSON_PRETTY_PRINT) . "</pre>";
    
    // Track a test interaction
    $result = $userPreferences->trackInteraction($userId, 'click', 'test-123', 'project', $testMetadata);
    echo "<p>Tracking result: " . ($result ? 'Success' : 'Failed') . "</p>";
    
    // Refresh profile
    $profile = $userPreferences->getUserProfile($userId);
    echo "<p>Updated profile:</p>";
    
    // Convert MongoDB BSONDocument to array for JSON display
    $profileArray = [];
    if ($profile) {
        foreach ($profile as $key => $value) {
            if ($value instanceof MongoDB\Model\BSONDocument) {
                $profileArray[$key] = iterator_to_array($value);
            } elseif ($value instanceof MongoDB\Model\BSONArray) {
                $profileArray[$key] = iterator_to_array($value);
            } else {
                $profileArray[$key] = $value;
            }
        }
    }
    echo "<pre>" . json_encode($profileArray, JSON_PRETTY_PRINT) . "</pre>";
}

?>

<form method="post">
    <button type="submit" name="test_metadata">Test Metadata Processing</button>
</form>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    pre { background: #f5f5f5; padding: 10px; overflow-x: auto; }
    button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
    button:hover { background: #005a87; }
</style> 