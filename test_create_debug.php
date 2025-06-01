<?php
session_start();

// Set up a test session to mimic a logged-in user
$_SESSION['logged_in'] = true;
$_SESSION['user_type'] = 'student';
$_SESSION['user_id'] = '6833436be5c16779b409aa42';
$_SESSION['user_data'] = [
    '_id' => ['$oid' => '6833436be5c16779b409aa42'],
    'basic_info' => ['name' => 'Test User'],
    'contact_info' => ['primary_email' => 'test@example.com']
];

// Simulate a basic project creation request
$_POST = [
    'title' => 'Test Project 2',
    'abstract' => 'This is a test project abstract.',
    'field' => 'Computer Science',
    'description' => 'Test description',
    'institution' => 'United International University',
    'privacy' => '0',
    'supervisor' => 'Test Supervisor',
    'supervisorId' => '',
    'members' => json_encode([
        [
            'userId' => ['$oid' => '6833436be5c16779b409aa42'],
            'name' => 'Test User',
            'role' => 'Author',
            'contribution' => 100
        ]
    ]),
    'keywords' => json_encode(['test', 'project']),
    'timeline' => json_encode([]),
    'links' => json_encode([
        'github' => '',
        'website' => '',
        'paper' => '',
        'doi' => '',
        'youtube' => ''
    ])
];

echo "<h2>Testing Original Project Creation</h2>";
echo "<p>Session Data:</p>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";
echo "<p>POST Data:</p>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

// Capture the output from create_project.php
ob_start();
include 'src/model/create_project.php';
$output = ob_get_clean();

echo "<h3>Response from create_project.php:</h3>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

// Also test if the response is valid JSON
$response = json_decode($output, true);
if ($response) {
    echo "<h3>Parsed JSON Response:</h3>";
    echo "<pre>" . print_r($response, true) . "</pre>";
} else {
    echo "<h3>JSON Error:</h3>";
    echo "<p>Could not parse response as JSON. Error: " . json_last_error_msg() . "</p>";
}
?> 