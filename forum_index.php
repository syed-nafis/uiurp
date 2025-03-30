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
    <title>Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/forum_style.css">
</head>
<body>
  <?php include 'src/includes/navbar.php'; ?>
  
    <div class="container">
        <h1>Day 1</h1>
        <div class="post-form">
            <input type="text" id="postTitle" placeholder="Post Title">
            <textarea id="postContent" placeholder="What's on your mind?"></textarea>
            <button id="submitPost">Submit Post</button>
        </div>
        <div id="postsContainer"></div>
    </div>
    <script src="assets/scripts/forum_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>