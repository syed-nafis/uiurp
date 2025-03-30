<?php
require __DIR__ . '/src/includes/db_connection.php'; // Include your database connection

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->forum_posts;

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
                  <p><strong>Views:</strong> <?= $post['views'] ?></p>
                  <p><strong>Upvotes:</strong> <?= $post['upvotes'] ?></p>
                  <p><strong>Downvotes:</strong> <?= $post['downvotes'] ?></p>
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
                  </div>
              </div>
          <?php endforeach; ?>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>