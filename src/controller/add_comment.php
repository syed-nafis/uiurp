<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$collection = $db->forum;

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
        // Update the post's comments array
        $result = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($postId)], // Query by ObjectId
            ['$push' => ['comments' => $comment]] // Add the comment to the comments array
        );

        if ($result->getModifiedCount() === 1) {
            echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to all forms with the class "add-comment-form"
    document.querySelectorAll('.add-comment-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            const formData = new FormData(form); // Collect form data
            const postId = formData.get('postId');
            const comment = formData.get('comment');

            // Send the data via AJAX
            fetch('add_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Comment added successfully!');
                    // Optionally, reload the page or update the comments section dynamically
                    location.reload(); // Reload the page to show the updated comments
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the comment.');
            });
        });
    });
});
</script>