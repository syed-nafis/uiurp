<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->faqs;

$cursor = $collection->find();
$faqs = [];

foreach ($cursor as $document) {
    $faqs[] = [
        'question' => $document['question'],
        'answer' => $document['answer']
    ];
}


echo json_encode($faqs);
?>