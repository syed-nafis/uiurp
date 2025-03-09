<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$data = json_decode(file_get_contents('php://input'), true);
$projectId = $_GET['id'];
$newPrivacy = $data['privacy'];

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->projects;

$updateResult = $collection->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($projectId)],
    ['$set' => ['privacy' => $newPrivacy]]
);

$updatedProject = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);

header('Content-Type: application/json');
echo json_encode($updatedProject);
?>