<?php
require __DIR__ . '/vendor/autoload.php';

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connect to MongoDB
    $mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $mongoClient->uiurp;
    $collection = $db->projectsV2;
    
    echo "<h2>MongoDB Connection Test</h2>";
    echo "<p>Successfully connected to MongoDB</p>";
    
    // Count all documents
    $totalCount = $collection->count([]);
    echo "<p>Total projects in projectsV2 collection: $totalCount</p>";
    
    // Count public projects (privacy = 0)
    $publicCount = $collection->count(['privacy' => 0]);
    echo "<p>Public projects (privacy = 0): $publicCount</p>";
    
    // Count private projects (privacy = 1)
    $privateCount = $collection->count(['privacy' => 1]);
    echo "<p>Private projects (privacy = 1): $privateCount</p>";
    
    // List all projects
    echo "<h3>All Projects</h3>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Privacy</th>
            </tr>";
    
    $cursor = $collection->find([]);
    foreach ($cursor as $document) {
        echo "<tr>
                <td>" . (string)$document['_id'] . "</td>
                <td>" . $document['title'] . "</td>
                <td>" . $document['privacy'] . "</td>
              </tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<h2>Error</h2>";
    echo "<p>Connection failed: " . $e->getMessage() . "</p>";
}
?> 