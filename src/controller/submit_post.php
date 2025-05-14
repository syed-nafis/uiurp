<?php
require __DIR__ . '/src/includes/db_connection.php'; // Include your database connection


$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$collection = $db->forum;

$posts = $collection->find()->toArray();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $post = [
        'user_id' => new MongoDB\BSON\ObjectId("661e174ee04e47be9b0e337b"), // Replace if dynamic
        'title' => $data['title'],
        'content' => $data['content'],
        'views' => 0,
        'upvotes' => 0,
        'downvotes' => 0,
        'comments' => [],
        'tags' => [],
        'timestamp' => new MongoDB\BSON\UTCDateTime()
    ];

    $result = $collection->insertOne($post);

    if ($result->getInsertedCount() === 1) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>