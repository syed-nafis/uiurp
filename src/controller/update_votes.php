<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

session_start(); // Start session to track user votes

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->forum;

try {
    // $data = json_decode(file_get_contents('php://input'), true);
    $postId = $data['postId'] ?? null;
    $voteType = $data['voteType'] ?? null;

    if (!$postId || !$voteType) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    // Determine the field to update based on the vote type
    $updateField = $voteType === 'upvote' ? 'upvotes' : 'downvotes';

    // Update the vote count in the database
    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($postId)],
        ['$inc' => [$updateField => 1]]
    );

    if ($result->getModifiedCount() === 1) {
        // Fetch the updated document to get the new vote counts
        $post = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);
        echo json_encode([
            'success' => true,
            'upvotes' => $post['upvotes'] ?? 0,
            'downvotes' => $post['downvotes'] ?? 0
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update votes']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>