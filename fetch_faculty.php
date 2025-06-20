<?php
require 'vendor/autoload.php'; // MongoDB library

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;; // Change to your DB/collection

$searchText = $_GET['query'] ?? '';

$filter = [];
if (!empty($searchText)) {
    $filter = ['name' => ['$regex' => $searchText, '$options' => 'i']];
}

$cursor = $collection->find($filter);

$results = [];
foreach ($cursor as $doc) {
    $results[] = [
        'name' => $doc['name'] ?? '',
        'title' => $doc['title'] ?? '',
        'email' => $doc['email'] ?? '',
    ];
}

header('Content-Type: application/json');
echo json_encode($results);
?>
