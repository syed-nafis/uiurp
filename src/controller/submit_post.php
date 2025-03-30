<?php
require __DIR__ . '/src/includes/db_connection.php'; // Include your database connection

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->forum_posts;

$posts = $collection->find()->toArray();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $post = [
        'title' => $data['title'],
        'content' => $data['content'],
        'views' => 0,
        'upvotes' => 0,
        'downvotes' => 0,
        'comments' => []
    ];

    $result = $collection->insertOne($post);

    if ($result->getInsertedCount() === 1) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>