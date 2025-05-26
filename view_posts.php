<?php
require __DIR__ . '/vendor/autoload.php'; // Updated path to Composer's autoloader

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$collection = $db->forum;

// Sorting logic
$sortOption = $_GET['sort'] ?? '';
$sort = [];

switch ($sortOption) {
    case 'newest':
        $sort = ['timestamp' => -1];
        break;
    case 'upvotes':
        $sort = ['upvotes' => -1];
        break;

    default:
        $sort = ['timestamp' => -1];
        break;
}

$posts = $collection->find([], ['sort' => $sort])->toArray();
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
      <form method="GET" class="mb-3">
        <label for="sort" class="form-label">Sort by:</label>
        <select name="sort" id="sort" class="form-select w-auto d-inline" onchange="this.form.submit()">
          <option value="">-- Select --</option>
          <option value="newest" <?= isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'selected' : '' ?>>Newest</option>
          <option value="upvotes" <?= isset($_GET['sort']) && $_GET['sort'] == 'upvotes' ? 'selected' : '' ?>>Most Upvoted</option>
          
        </select>
      </form>
      <h1>All Posts</h1>
      <div id="postsContainer">
          <?php foreach ($posts as $post): ?>
              <div class="forum-post border p-3 mb-3">
<?php
    $posterName = $post['user_name'] ?? 'Unknown';
?>
                  <div class="text-start text-muted mb-2" style="font-size: 0.9rem;">
                      Posted by <?= htmlspecialchars($posterName) ?>
                  </div>
                  <h3>
                      <?= htmlspecialchars($post['title']) ?>
                  </h3>
                  <p><?= htmlspecialchars($post['content']) ?></p>
                 
                  <p>
                      <button class="btn btn-success btn-sm upvote-btn" data-post-id="<?= $post['_id'] ?>">Upvote</button>
                      <span id="upvotes-<?= $post['_id'] ?>" class="ms-2"><?= $post['upvotes'] ?? 0 ?></span>
                  </p>
                  <div class="comments">
                      <strong>Comments:</strong>
                      <?php if (!empty($post['comments'])): ?>
                          <ul>
                              <?php foreach ($post['comments'] as $comment): ?>
                                  <li>
                                      <strong><?= htmlspecialchars($comment['user'] ?? 'Anonymous') ?>:</strong>
                                      <?= htmlspecialchars($comment['text'] ?? '') ?>
                                      <br>
                                      <small>
                                          <?= isset($comment['time']) ? date('g:i a, F j, Y', $comment['time']->toDateTime()->getTimestamp()) : '' ?>
                                      </small>
                                  </li>
                              <?php endforeach; ?>
                          </ul>
                      <?php else: ?>
                          <p>No comments yet.</p>
                      <?php endif; ?>

                      <!-- Add Comment Form -->
                      <form method="POST" action="src/controller/add_comment.php" class="add-comment-form">
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
              fetch('src/controller/update_votes.php', {
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
  });
  </script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Handle comment form submissions
      document.querySelectorAll('.add-comment-form').forEach(form => {
          form.addEventListener('submit', function(event) {
              event.preventDefault();

              const formData = new FormData(form);

              fetch('src/controller/add_comment.php', {
                  method: 'POST',
                  body: formData
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert('Comment added successfully!');
                      location.reload();
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
</body>
</html>