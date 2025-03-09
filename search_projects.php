<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$data = json_decode(file_get_contents('php://input'), true);
$searchString = $data['searchString'];
$searchWords = explode(' ', $searchString);

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->projects;

$regexArray = [];
foreach ($searchWords as $word) {
    $regexArray[] = new MongoDB\BSON\Regex($word, 'i');
}

$cursor = $collection->find([
    '$and' => [
        ['$or' => [
            ['title' => ['$in' => $regexArray]],
            ['keywords' => ['$in' => $regexArray]]
        ]],
        ['privacy' => 1]
    ]
]);

$projects = [];
$projectIds = [];

foreach ($cursor as $document) {
    $projectId = (string) $document['_id'];
    if (!in_array($projectId, $projectIds)) {
        $projectIds[] = $projectId;
        $projects[] = $document;
    }
}

header('Content-Type: application/json');
echo json_encode($projects);
?>