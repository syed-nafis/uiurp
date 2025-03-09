<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$data = json_decode(file_get_contents('php://input'), true);
$keyword = $data['keyword'];

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->keywords;

$collection->updateOne(
    ['name' => $keyword],
    ['$inc' => ['frequency' => 1]],
    ['upsert' => true]
);

$cursor = $collection->find([], ['sort' => ['frequency' => -1], 'limit' => 10]);
$keywords = [];

foreach ($cursor as $document) {
    $keywords[] = ['name' => $document['name']];
}

header('Content-Type: application/json');
echo json_encode($keywords);
?>