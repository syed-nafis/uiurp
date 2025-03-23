<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$facultyId = $_GET['id'];

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->faculties;

$faculty = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($facultyId)]);

header('Content-Type: application/json');
echo json_encode($faculty);
?>