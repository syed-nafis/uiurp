<?php
// Set up environment to avoid REQUEST_METHOD warning
$_SERVER['REQUEST_METHOD'] = 'GET';

session_start();
require_once 'src/model/user_preferences.php';
require_once 'src/model/recommendation_engine.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in first\n";
    exit;
}

$userId = $_SESSION['user_id'];
echo "=== User Profile Analysis ===\n";
echo "User ID: $userId\n\n";

// Check user preferences
$userPreferences = new UserPreferences();
$profile = $userPreferences->getUserProfile($userId);

if ($profile) {
    echo "✓ User has profile\n";
    echo "Activity score: " . ($profile['activity_score'] ?? 0) . "\n";
    
    // Convert BSON to arrays for analysis
    $interests = $profile['interests'] ?? [];
    if ($interests instanceof MongoDB\Model\BSONDocument) {
        $interests = iterator_to_array($interests);
    }
    
    $categories = $profile['preferred_categories'] ?? [];
    if ($categories instanceof MongoDB\Model\BSONDocument) {
        $categories = iterator_to_array($categories);
    }
    
    $keywords = $profile['keywords'] ?? [];
    if ($keywords instanceof MongoDB\Model\BSONDocument) {
        $keywords = iterator_to_array($keywords);
    }
    
    echo "Interests count: " . count($interests) . "\n";
    echo "Categories count: " . count($categories) . "\n";
    echo "Keywords count: " . count($keywords) . "\n\n";
    
    if (!empty($interests)) {
        echo "=== Top Interests ===\n";
        arsort($interests);
        $topInterests = array_slice($interests, 0, 5, true);
        foreach ($topInterests as $interest => $score) {
            echo "- $interest: $score\n";
        }
        echo "\n";
    }
    
    if (!empty($categories)) {
        echo "=== Preferred Categories ===\n";
        arsort($categories);
        foreach ($categories as $category => $score) {
            echo "- $category: $score\n";
        }
        echo "\n";
    }
    
} else {
    echo "✗ User has no profile\n\n";
}

// Check recent interactions
$interactions = $userPreferences->getUserInteractions($userId, 10);
echo "=== Recent Interactions ===\n";
echo "Total interactions: " . count($interactions) . "\n";

if (!empty($interactions)) {
    foreach ($interactions as $interaction) {
        $timestamp = $interaction['timestamp']->toDateTime()->format('Y-m-d H:i:s');
        echo "- {$interaction['interaction_type']} on {$interaction['item_type']} ({$interaction['item_id']}) at $timestamp\n";
    }
    echo "\n";
}

// Test recommendation engine
echo "=== Recommendation Engine Test ===\n";
$recommendationEngine = new RecommendationEngine();
$recommendations = $recommendationEngine->getDashboardRecommendations($userId);

echo "Projects returned: " . count($recommendations['projects']) . "\n";
echo "Events returned: " . count($recommendations['events']) . "\n";
echo "Forum posts returned: " . count($recommendations['forum_posts']) . "\n";
echo "Faculties returned: " . count($recommendations['faculties']) . "\n\n";

// Check if any projects have relevance scores
$personalizedProjects = 0;
foreach ($recommendations['projects'] as $project) {
    if (isset($project['relevance_score']) && $project['relevance_score'] > 0) {
        $personalizedProjects++;
    }
}
echo "Personalized projects: $personalizedProjects\n";

echo "\n=== Conclusion ===\n";
if ($profile && !empty($interests) && count($interactions) > 0) {
    echo "✓ User should get personalized recommendations\n";
} else {
    echo "✗ User needs more interactions to get personalized recommendations\n";
    if (!$profile) echo "  - No profile found\n";
    if (empty($interests)) echo "  - No interests recorded\n";
    if (count($interactions) == 0) echo "  - No interactions recorded\n";
}
?> 