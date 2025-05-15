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

    // Track upvote state per post in session: 1 for upvoted, 0 for not upvoted
    if (!isset($_SESSION['upvote_state'])) {
        $_SESSION['upvote_state'] = [];
    }

    $currentState = $_SESSION['upvote_state'][$postId] ?? 0; // 0 = not upvoted, 1 = upvoted

    // Alternate: if not upvoted, upvote (+1); if upvoted, remove upvote (-1)
    $inc = $currentState === 1 ? -1 : 1;

    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($postId)],
        ['$inc' => ['upvotes' => $inc]]
    );

    if ($result->getModifiedCount() === 1) {
        // Toggle state
        $_SESSION['upvote_state'][$postId] = $currentState === 1 ? 0 : 1;
        $post = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);
        echo json_encode([
            'success' => true,
            'upvotes' => $post['upvotes'] ?? 0,
            'upvoted' => $_SESSION['upvote_state'][$postId] === 1
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update upvotes']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>