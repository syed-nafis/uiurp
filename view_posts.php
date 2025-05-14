<?php
require __DIR__ . '/vendor/autoload.php'; // Updated path to Composer's autoloader

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$collection = $db->forum;

$posts = $collection->find()->toArray();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/forum_style.css">
    <style>
        .forum-post {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .forum-post h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .forum-post p {
            margin: 5px 0;
        }

        .comments ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .comments p {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
  <?php include 'src/includes/navbar.php'; ?>

  <div class="container">
      <h1>All Posts</h1>
      <div id="postsContainer">
          <?php foreach ($posts as $post): ?>
              <div class="forum-post border p-3 mb-3">
                  <h3><?= htmlspecialchars($post['title']) ?></h3>
                  <p><?= htmlspecialchars($post['content']) ?></p>
                  <p><strong>Views:</strong> <?= $post['views'] ?? 0 ?></p>
                  <p>
                      <button class="btn btn-success btn-sm upvote-btn" data-post-id="<?= $post['_id'] ?>">Upvote</button>
                      <span id="upvotes-<?= $post['_id'] ?>" class="ms-2"><?= $post['upvotes'] ?? 0 ?></span>
                  </p>
                  <p>
                      <button class="btn btn-danger btn-sm downvote-btn" data-post-id="<?= $post['_id'] ?>">Downvote</button>
                      <span id="downvotes-<?= $post['_id'] ?>" class="ms-2"><?= $post['downvotes'] ?? 0 ?></span>
                  </p>
                  <div class="comments">
                      <strong>Comments:</strong>
                      <?php if (!empty($post['comments'])): ?>
                          <ul>
                              <?php foreach ($post['comments'] as $comment): ?>
                                  <li><?= htmlspecialchars($comment) ?></li>
                              <?php endforeach; ?>
                          </ul>
                      <?php else: ?>
                          <p>No comments yet.</p>
                      <?php endif; ?>

                      <!-- Add Comment Form -->
                      <form method="POST" action="add_comment.php">
                          <input type="hidden" name="postId" value="<?= $post['_id'] ?>">
                          <textarea name="comment" placeholder="Add a comment..." class="form-control mb-2"></textarea>
                          <button type="submit" class="btn btn-primary">Submit Comment</button>
                      </form>
                  </div>
              </div>
          <?php endforeach; ?>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Handle upvote button clicks
      document.querySelectorAll('.upvote-btn').forEach(button => {
          button.addEventListener('click', function() {
              const postId = this.getAttribute('data-post-id');
              fetch('update_votes.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({ postId: postId, voteType: 'upvote' })
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // Update the upvotes count in the UI
                      document.getElementById(`upvotes-${postId}`).textContent = data.upvotes;
                  } else {
                      alert(data.message);
                  }
              })
              .catch(error => console.error('Error:', error));
          });
      });

      // Handle downvote button clicks
      document.querySelectorAll('.downvote-btn').forEach(button => {
          button.addEventListener('click', function() {
              const postId = this.getAttribute('data-post-id');
              fetch('update_votes.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({ postId: postId, voteType: 'downvote' })
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // Update the downvotes count in the UI
                      document.getElementById(`downvotes-${postId}`).textContent = data.downvotes;
                  } else {
                      alert(data.message);
                  }
              })
              .catch(error => console.error('Error:', error));
          });
      });
  });
  </script>
</body>
</html>