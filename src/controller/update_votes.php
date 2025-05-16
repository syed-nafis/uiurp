<?php
require __DIR__ . '/../../vendor/autoload.php';

session_start();

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->forum;

header('Content-Type: application/json');

function isValidObjectId($id) {
    return preg_match('/^[a-f\d]{24}$/i', $id);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $postId = $data['postId'] ?? null;

    if (!$postId || !isValidObjectId($postId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to upvote.']);
        exit;
    }

    if (!isset($_SESSION['upvoted_posts'])) {
        $_SESSION['upvoted_posts'] = [];
    }

    // If already upvoted, just return current upvotes without incrementing or error
    if (in_array($postId, $_SESSION['upvoted_posts'])) {
        $post = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);
        echo json_encode([
            'success' => true,
            'upvotes' => $post['upvotes'] ?? 0
        ]);
        exit;
    }

    // Update upvotes by 1
    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($postId)],
        ['$inc' => ['upvotes' => 1]]
    );

    if ($result->getModifiedCount() === 1) {
        $_SESSION['upvoted_posts'][] = $postId;
        $post = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);
        echo json_encode([
            'success' => true,
            'upvotes' => $post['upvotes'] ?? 0
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update upvotes']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>