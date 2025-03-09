<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

header('Content-Type: application/json');

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->keywords;

$cursor = $collection->find([], ['sort' => ['frequency' => -1], 'limit' => 10]);
$keywords = [];

foreach ($cursor as $document) {
    $keywords[] = ['name' => $document['name']];
}

echo json_encode($keywords);
?>