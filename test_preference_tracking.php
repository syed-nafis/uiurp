<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "ERROR: User not logged in. Please login first.";
    exit;
}

require_once 'src/model/user_preferences.php';

$userId = $_SESSION['user_id'];
$preferences = new UserPreferences();

echo "<h1>Enhanced Preference Tracking Debug Test</h1>";
echo "<p>Testing for User ID: $userId</p>";

// Test all content types with proper metadata
echo "<h2>Test 1: Track Different Content Types</h2>";

// Test Project Interaction
echo "<h3>Testing Project Interaction</h3>";
$projectMetadata = [
    'title' => 'AI Research Project',
    'keywords' => ['artificial', 'intelligence', 'neural', 'networks'],
    'category' => 'Research',
    'field' => 'Computer Science',
    'tags' => ['AI', 'Machine Learning', 'Research']
];

$result = $preferences->trackInteraction($userId, 'click', 'test-project-123', 'project', $projectMetadata);
echo "<p>Project tracking result: " . ($result ? 'SUCCESS' : 'FAILED') . "</p>";

// Test Event Interaction
echo "<h3>Testing Event Interaction</h3>";
$eventMetadata = [
    'title' => 'AI Conference 2024',
    'eventType' => 'Conference',
    'organizer' => 'Tech Institute',
    'status' => 'upcoming',
    'tags' => ['Conference', 'AI', 'Machine Learning', 'Technology'],
    'speakers' => ['Dr. Smith', 'Prof. Johnson']
];

$result = $preferences->trackInteraction($userId, 'click', 'test-event-456', 'event', $eventMetadata);
echo "<p>Event tracking result: " . ($result ? 'SUCCESS' : 'FAILED') . "</p>";

// Test Forum Post Interaction
echo "<h3>Testing Forum Post Interaction</h3>";
$forumMetadata = [
    'title' => 'Discussion on Deep Learning',
    'tags' => ['Deep Learning', 'Neural Networks', 'Discussion'],
    'author' => 'TestUser',
    'upvotes' => 5,
    'comment_count' => 3
];

$result = $preferences->trackInteraction($userId, 'click', 'test-post-789', 'forum_post', $forumMetadata);
echo "<p>Forum post tracking result: " . ($result ? 'SUCCESS' : 'FAILED') . "</p>";

// Test Faculty Interaction
echo "<h3>Testing Faculty Interaction</h3>";
$facultyMetadata = [
    'title' => 'Dr. Jane Smith',
    'specialty' => 'Computer Science',
    'bio' => 'Expert in machine learning and artificial intelligence',
    'researchInterests' => ['Machine Learning', 'Computer Vision', 'Natural Language Processing'],
    'tags' => ['Computer Science', 'Faculty', 'Machine Learning', 'AI']
];

$result = $preferences->trackInteraction($userId, 'click', 'test-faculty-101', 'faculty', $facultyMetadata);
echo "<p>Faculty tracking result: " . ($result ? 'SUCCESS' : 'FAILED') . "</p>";

// Test 2: Get user profile
echo "<h2>Test 2: Get Updated User Profile</h2>";
$profile = $preferences->getUserProfile($userId);

if ($profile) {
    echo "<h3>User Profile:</h3>";
    echo "<pre>";
    
    // Convert MongoDB objects to arrays for display
    $displayProfile = [];
    foreach ($profile as $key => $value) {
        if ($value instanceof MongoDB\Model\BSONDocument) {
            $displayProfile[$key] = iterator_to_array($value);
        } elseif ($value instanceof MongoDB\Model\BSONArray) {
            $displayProfile[$key] = iterator_to_array($value);
        } else {
            $displayProfile[$key] = $value;
        }
    }
    
    echo json_encode($displayProfile, JSON_PRETTY_PRINT);
    echo "</pre>";
    
    // Show specific interest analysis
    echo "<h3>Interest Analysis:</h3>";
    $interests = $displayProfile['interests'] ?? [];
    if (!empty($interests)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Interest</th><th>Score</th><th>Source</th></tr>";
        
        // Sort interests by score
        arsort($interests);
        
        foreach ($interests as $interest => $score) {
            $source = "Unknown";
            if (in_array($interest, ['AI', 'Machine Learning', 'Deep Learning', 'Neural Networks'])) {
                $source = "Technology/Research";
            } elseif (in_array($interest, ['Conference', 'Workshop'])) {
                $source = "Event Types";
            } elseif (in_array($interest, ['Computer Science', 'Faculty'])) {
                $source = "Categories";
            }
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($interest) . "</td>";
            echo "<td>" . $score . "</td>";
            echo "<td>" . $source . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No interests found!</p>";
    }
    
    // Show category preferences
    echo "<h3>Category Preferences:</h3>";
    $categories = $displayProfile['preferred_categories'] ?? [];
    if (!empty($categories)) {
        echo "<ul>";
        foreach ($categories as $category => $score) {
            echo "<li><strong>$category:</strong> $score</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No category preferences found!</p>";
    }
    
} else {
    echo "<p>No profile found</p>";
}

// Test 3: Check recent interactions
echo "<h2>Test 3: Recent Interactions</h2>";
$interactions = $preferences->getUserInteractions($userId, 10);

if (!empty($interactions)) {
    echo "<h3>Recent Interactions:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Type</th><th>Item Type</th><th>Item ID</th><th>Time</th><th>Metadata</th></tr>";
    
    foreach ($interactions as $interaction) {
        $metadata = isset($interaction['metadata']) ? json_encode($interaction['metadata'], JSON_PRETTY_PRINT) : 'No metadata';
        echo "<tr>";
        echo "<td>" . htmlspecialchars($interaction['interaction_type']) . "</td>";
        echo "<td>" . htmlspecialchars($interaction['item_type']) . "</td>";
        echo "<td>" . htmlspecialchars($interaction['item_id']) . "</td>";
        echo "<td>" . ($interaction['timestamp']->toDateTime()->format('Y-m-d H:i:s')) . "</td>";
        echo "<td><pre style='max-width: 300px; overflow: auto;'>" . htmlspecialchars($metadata) . "</pre></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No interactions found</p>";
}

// Test 4: Test recommendation engine
echo "<h2>Test 4: Recommendation Engine Test</h2>";
require_once 'src/model/recommendation_engine.php';
$recommendationEngine = new RecommendationEngine();

echo "<h3>Recommended Projects:</h3>";
$projects = $recommendationEngine->getRecommendedProjects($userId, 3);
if (!empty($projects)) {
    foreach ($projects as $project) {
        $score = $project['relevance_score'] ?? 0;
        $title = $project['title'] ?? 'Unknown';
        echo "<p>- $title (Score: $score)</p>";
    }
} else {
    echo "<p>No recommended projects found</p>";
}

echo "<h3>Recommended Events:</h3>";
$events = $recommendationEngine->getRecommendedEvents($userId, 3);
if (!empty($events)) {
    foreach ($events as $event) {
        $score = $event['relevance_score'] ?? 0;
        $title = $event['title'] ?? 'Unknown';
        echo "<p>- $title (Score: $score)</p>";
    }
} else {
    echo "<p>No recommended events found</p>";
}

echo "<h3>Recommended Forum Posts:</h3>";
$forumPosts = $recommendationEngine->getRecommendedForumPosts($userId, 3);
if (!empty($forumPosts)) {
    foreach ($forumPosts as $post) {
        $score = $post['relevance_score'] ?? 0;
        $title = $post['title'] ?? 'Unknown';
        echo "<p>- $title (Score: $score)</p>";
    }
} else {
    echo "<p>No recommended forum posts found</p>";
}

echo "<h3>Recommended Faculties:</h3>";
$faculties = $recommendationEngine->getRecommendedFaculties($userId, 3);
if (!empty($faculties)) {
    foreach ($faculties as $faculty) {
        $score = $faculty['relevance_score'] ?? 0;
        $name = $faculty['name'] ?? 'Unknown';
        echo "<p>- $name (Score: $score)</p>";
    }
} else {
    echo "<p>No recommended faculties found</p>";
}

?>

<style>
    body { 
        font-family: Arial, sans-serif; 
        margin: 20px; 
        background: #f5f5f5; 
    }
    pre { 
        background: #f0f0f0; 
        padding: 10px; 
        overflow-x: auto; 
        border-radius: 4px;
        font-size: 12px;
    }
    table {
        background: white;
        margin: 10px 0;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    h1, h2, h3 {
        color: #333;
    }
    .success {
        color: green;
        font-weight: bold;
    }
    .error {
        color: red;
        font-weight: bold;
    }
</style>

<script>
console.log('Preference Tracking Test Page Loaded');
console.log('Check browser console and server logs for detailed tracking information');
</script> 