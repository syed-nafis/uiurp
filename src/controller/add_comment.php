<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$collection = $db->forum;

header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $postId = $_POST['postId'] ?? null;
    $comment = $_POST['comment'] ?? null;

    // Validate input
    if (empty($postId) || empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    try {
        session_start();
        $username = $_SESSION['user_data']['name'] ?? 'Anonymous';
        $sanitizedComment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

        $commentData = [
            'user' => $username,
            'text' => $sanitizedComment,
            'time' => new MongoDB\BSON\UTCDateTime()
        ];

        $result = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($postId)],
            ['$push' => ['comments' => $commentData]]
        );

        if ($result->getModifiedCount() === 1) {
            echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>