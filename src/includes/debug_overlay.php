<?php
// Only show debug overlay for logged-in users
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../model/user_preferences.php';
    
    $userId = $_SESSION['user_id'];
    $userPreferences = new UserPreferences();
    $profile = $userPreferences->getUserProfile($userId);
    $interactions = $userPreferences->getUserInteractions($userId, 5);
    
    echo "<div id='debugOverlay' style='position: fixed; top: 10px; right: 10px; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 5px; z-index: 9999; max-width: 300px; font-size: 12px; display: none;'>";
    echo "<h4>Debug Info</h4>";
    echo "User ID: $userId<br>";
    echo "Profile exists: " . ($profile ? 'Yes' : 'No') . "<br>";
    if ($profile) {
        $interests = $profile['interests'] ?? [];
        if ($interests instanceof MongoDB\Model\BSONDocument) {
            $interests = iterator_to_array($interests);
        } elseif ($interests instanceof MongoDB\Model\BSONArray) {
            $interests = iterator_to_array($interests);
        }
        
        echo "Interests: " . count($interests) . "<br>";
        echo "Activity: " . ($profile['activity_score'] ?? 0) . "<br>";
        
        // Show actual interests if they exist and are properly formatted
        if (!empty($interests) && is_array($interests)) {
            // Check if it's an associative array (proper format)
            if (array_keys($interests) !== range(0, count($interests) - 1)) {
                echo "<br><strong>Top Interests:</strong><br>";
                arsort($interests);
                $topInterests = array_slice($interests, 0, 3, true);
                foreach ($topInterests as $interest => $score) {
                    echo "- " . htmlspecialchars($interest) . ": $score<br>";
                }
            } else {
                echo "<br><em>Interests are corrupted (indexed array)</em><br>";
            }
        }
    }
    echo "Recent interactions: " . count($interactions) . "<br>";
    
    echo "<br><a href='?reset_profile=1' style='color: yellow;'>Reset Profile</a>";
    echo "</div>";
    
    // Script to check localStorage and toggle visibility
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const debugOverlay = document.getElementById('debugOverlay');
            const debugEnabled = localStorage.getItem('debugOverlayEnabled') === 'true';
            
            if (debugEnabled) {
                debugOverlay.style.display = 'block';
            } else {
                debugOverlay.style.display = 'none';
            }
            
            // Listen for custom event to toggle visibility
            document.addEventListener('toggleDebugOverlay', function(e) {
                const isVisible = debugOverlay.style.display === 'block';
                debugOverlay.style.display = isVisible ? 'none' : 'block';
                localStorage.setItem('debugOverlayEnabled', !isVisible);
            });
        });
    </script>";
    
    // Handle profile reset
    if (isset($_GET['reset_profile']) && $_GET['reset_profile'] == '1') {
        try {
            $db = new MongoDB\Client("mongodb://localhost:27017");
            $profileCollection = $db->uiurp->user_preference_profiles;
            $interactionCollection = $db->uiurp->user_interactions;
            
            $profileResult = $profileCollection->deleteOne(['user_id' => $userId]);
            $interactionResult = $interactionCollection->deleteMany(['user_id' => $userId]);
            
            echo "<script>
                alert('Profile reset successful! Deleted {$profileResult->getDeletedCount()} profile and {$interactionResult->getDeletedCount()} interactions.'); 
                window.location.href=window.location.pathname;
            </script>";
        } catch (Exception $e) {
            echo "<script>alert('Error resetting profile: " . addslashes($e->getMessage()) . "'); window.location.href=window.location.pathname;</script>";
        }
    }
}
?> 