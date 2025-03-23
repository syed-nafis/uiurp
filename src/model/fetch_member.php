<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

$memberId = $_GET['id'];

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->students;

$member = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($memberId)]);

header('Content-Type: application/json');
echo json_encode($member);
?>