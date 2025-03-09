<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$projectId = $_GET['id'];

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->projects;

$project = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);

header('Content-Type: application/json');
echo json_encode($project);
?>