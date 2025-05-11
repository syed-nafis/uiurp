<?php
require __DIR__ . '/../../vendor/autoload.php';

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connect to MongoDB
    $mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $mongoClient->uiurp;
    $collection = $db->projectsV2;
    
    echo "<h2>MongoDB Debug Information</h2>";
    echo "<p>Successfully connected to MongoDB</p>";
    
    // Count all documents
    $totalCount = $collection->countDocuments([]);
    echo "<p>Total projects in projectsV2 collection: $totalCount</p>";
    
    // Count public projects (privacy = 0)
    $publicCount = $collection->countDocuments(['privacy' => 0]);
    echo "<p>Public projects (privacy = 0): $publicCount</p>";
    
    // Count private projects (privacy = 1)
    $privateCount = $collection->countDocuments(['privacy' => 1]);
    echo "<p>Private projects (privacy = 1): $privateCount</p>";
    
    // Count missing privacy field
    $missingPrivacyCount = $collection->countDocuments(['privacy' => ['$exists' => false]]);
    echo "<p>Projects with missing privacy field: $missingPrivacyCount</p>";
    
    // List all projects
    echo "<h3>All Projects</h3>";
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Privacy</th>
                <th>Abstract/Description</th>
            </tr>";
    
    $cursor = $collection->find([]);
    foreach ($cursor as $document) {
        $privacy = isset($document['privacy']) ? $document['privacy'] : 'Not set';
        $description = isset($document['abstract']) ? $document['abstract'] : 
                      (isset($document['description']) ? $document['description'] : 'No description');
        
        echo "<tr>
                <td>" . (string)$document['_id'] . "</td>
                <td>" . $document['title'] . "</td>
                <td>" . $privacy . "</td>
                <td>" . substr($description, 0, 100) . "...</td>
              </tr>";
    }
    
    echo "</table>";
    
    // Debug fetch_projects.php logic
    echo "<h3>Testing fetch_projects.php Logic</h3>";
    $fetchLogic = $collection->find(['privacy' => 0]);
    $fetchResults = [];
    foreach ($fetchLogic as $doc) {
        $fetchResults[] = [
            'id' => (string)$doc['_id'],
            'title' => $doc['title']
        ];
    }
    
    echo "<p>Projects with privacy=0 (shown on website): " . count($fetchResults) . "</p>";
    echo "<pre>" . json_encode($fetchResults, JSON_PRETTY_PRINT) . "</pre>";
    
} catch (Exception $e) {
    echo "<h2>Error</h2>";
    echo "<p>Connection failed: " . $e->getMessage() . "</p>";
}
?> 