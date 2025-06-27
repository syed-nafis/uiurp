<?php
// Simple test script to test the API via HTTP

session_start();

// Set a fake session for testing
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = 'test_user';

echo "<h1>Testing Meeting Suggestions API</h1>";

$projectId = "6839534eb7804646190966c4";
$date = "2025-01-20";

// Construct the proper URL for API testing
$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$apiUrl = $baseUrl . "/src/model/get_project_meeting_suggestions.php?projectId=" . urlencode($projectId) . "&date=" . urlencode($date);

echo "<p><strong>API URL:</strong> $apiUrl</p>";

// Use cURL for proper HTTP request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Add any cookies to maintain session
$cookieHeader = '';
foreach ($_COOKIE as $name => $value) {
    $cookieHeader .= $name . '=' . $value . '; ';
}
if ($cookieHeader) {
    curl_setopt($ch, CURLOPT_COOKIE, rtrim($cookieHeader, '; '));
}

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h2>API Response</h2>";
echo "<p><strong>HTTP Code:</strong> $httpCode</p>";

if ($error) {
    echo "<p style='color: red;'><strong>cURL Error:</strong> $error</p>";
}

if ($response) {
    $data = json_decode($response, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<h3>Parsed JSON Response:</h3>";
        echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
        
        if (isset($data['teamMembers'])) {
            echo "<h3>Team Members Analysis:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Name</th><th>Role</th><th>Type</th><th>Has Schedule Data</th></tr>";
            
            foreach ($data['teamMembers'] as $member) {
                $hasSchedule = isset($data['teamSchedules'][$member['name']]) && count($data['teamSchedules'][$member['name']]) > 0;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($member['name']) . "</td>";
                echo "<td>" . htmlspecialchars($member['role']) . "</td>";
                echo "<td style='color: " . ($member['type'] === 'supervisor' ? 'blue' : 'green') . ";'>" . htmlspecialchars($member['type']) . "</td>";
                echo "<td style='color: " . ($hasSchedule ? 'green' : 'red') . ";'>" . ($hasSchedule ? 'Yes' : 'No') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        if (isset($data['error'])) {
            echo "<p style='color: red;'><strong>API Error:</strong> " . htmlspecialchars($data['error']) . "</p>";
        }
    } else {
        echo "<h3>Raw Response (JSON parse failed):</h3>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
        echo "<p style='color: red;'>JSON Parse Error: " . json_last_error_msg() . "</p>";
    }
} else {
    echo "<p style='color: red;'>No response received</p>";
}

// Also test by directly including the API file (fallback method)
echo "<hr>";
echo "<h2>Direct File Test (Fallback)</h2>";

// Set GET parameters for direct file inclusion
$_GET['projectId'] = $projectId;
$_GET['date'] = $date;

// Capture output from direct inclusion
ob_start();
try {
    include 'src/model/get_project_meeting_suggestions.php';
    $directResponse = ob_get_contents();
} catch (Exception $e) {
    $directResponse = "Error: " . $e->getMessage();
}
ob_end_clean();

echo "<h3>Direct File Response:</h3>";
if ($directResponse) {
    $directData = json_decode($directResponse, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<pre>" . json_encode($directData, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "<pre>" . htmlspecialchars($directResponse) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>No response from direct file inclusion</p>";
}

?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h1, h2, h3 { color: #333; }
    table { margin: 10px 0; }
    th, td { padding: 8px; text-align: left; }
    th { background-color: #f0f0f0; }
    pre { background-color: #f8f8f8; padding: 10px; border: 1px solid #ddd; overflow-x: auto; }
    hr { margin: 20px 0; }
</style> 