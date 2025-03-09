<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 15;

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->projects;

$cursor = $collection->find(['privacy' => 1], ['limit' => $limit]);

$projects = [];
foreach ($cursor as $document) {
    $projects[] = $document;
}

header('Content-Type: application/json');
echo json_encode($projects);
?>

