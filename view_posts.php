<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/model/db_connect.php';

// Import MongoDB classes
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;

session_start();

// Redirect if not logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    $forumPostsCollection = $db->forum_posts;
    
    // Get filter and sorting parameters
    $sortOption = $_GET['sort'] ?? 'newest';
    $tagFilter = $_GET['tag'] ?? '';
    
    // Build query for forum_posts collection
    $queryPosts = [];
    if (!empty($tagFilter)) {
        // Use $in operator to find posts that contain the specified tag
        $queryPosts['tags'] = ['$in' => [$tagFilter]];
    }
    
    // Set up sorting
    $sortPosts = [];
    switch ($sortOption) {
        case 'upvotes':
            $sortPosts = ['upvotes' => -1];
            break;
        case 'newest':
        default:
            $sortPosts = ['created_at' => -1];
            break;
    }
    
    // Fetch posts from forum_posts collection
    $optionsPosts = ['sort' => $sortPosts];
    $newPosts = $forumPostsCollection->find($queryPosts, $optionsPosts)->toArray();
    
    // Debug output
    error_log("Found " . count($newPosts) . " posts in forum_posts collection");
    
    // Map posts to ensure consistent structure
    $allPosts = [];
    foreach ($newPosts as $post) {
        try {
            $currentTime = new UTCDateTime();
            
            // Convert BSONArray objects to PHP arrays
            $tags = $post['tags'] ?? ['discussion'];
            if ($tags instanceof MongoDB\Model\BSONArray) {
                $tags = $tags->getArrayCopy();
            }
            
            $upvotedBy = $post['upvoted_by'] ?? [];
            if ($upvotedBy instanceof MongoDB\Model\BSONArray) {
                $upvotedBy = $upvotedBy->getArrayCopy();
            }
            
            $comments = $post['comments'] ?? [];
            if ($comments instanceof MongoDB\Model\BSONArray) {
                $comments = $comments->getArrayCopy();
            }
            
            $attachments = $post['attachments'] ?? [];
            if ($attachments instanceof MongoDB\Model\BSONArray) {
                $attachments = $attachments->getArrayCopy();
            }
            
            $mappedPost = [
                '_id' => $post['_id'],
                'user_id' => $post['user_id'] ?? null,
                'user_name' => $post['user_name'] ?? 'Unknown User',
                'user_profile_pic' => $post['user_profile_pic'] ?? 'uploads/profile_images/user_avater.png',
                'title' => $post['title'] ?? 'Untitled Post',
                'content' => $post['content'] ?? '',
                'tags' => $tags,
                'upvotes' => $post['upvotes'] ?? 0,
                'upvoted_by' => $upvotedBy,
                'comments' => $comments,
                'created_at' => $post['created_at'] ?? $currentTime,
                'updated_at' => $post['updated_at'] ?? $post['created_at'] ?? $currentTime,
                'attachments' => $attachments
            ];
            $allPosts[] = $mappedPost;
        } catch (Exception $e) {
            error_log("Error mapping post: " . $e->getMessage());
            continue;
        }
    }
    
    // Debug output
    error_log("Mapped " . count($allPosts) . " posts total");
    
    // Sort all posts according to sorting option
    if ($sortOption === 'upvotes') {
        usort($allPosts, function($a, $b) {
            return ($b['upvotes'] ?? 0) - ($a['upvotes'] ?? 0);
        });
    } else {
        // Sort by creation date
        usort($allPosts, function($a, $b) {
            $timeA = isset($a['created_at']) && !empty($a['created_at']) ? 
                (is_object($a['created_at']) && method_exists($a['created_at'], 'toDateTime') ? 
                    $a['created_at']->toDateTime()->getTimestamp() : 
                    (is_object($a['created_at']) ? $a['created_at']->__toString() : 0)) : 0;
            
            $timeB = isset($b['created_at']) && !empty($b['created_at']) ? 
                (is_object($b['created_at']) && method_exists($b['created_at'], 'toDateTime') ? 
                    $b['created_at']->toDateTime()->getTimestamp() : 
                    (is_object($b['created_at']) ? $b['created_at']->__toString() : 0)) : 0;
            
            return $timeB - $timeA;
        });
    }
    
    // Get all available tags
    $tagCollection = $db->forum_tags;
    $allTags = $tagCollection->find()->toArray();
    
    // Debug output
    error_log("Found " . count($allTags) . " tags");
    
} catch (Exception $e) {
    // Log the error and show a user-friendly message
    error_log("Forum error: " . $e->getMessage());
    $error = "An error occurred while loading the forum. Please try again later.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/forum_style.css">
    <style>
        .forum-post {
            border-radius: 8px;
            margin-bottom: 1.5rem;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .post-header {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .post-content {
            padding: 1.25rem;
        }
        .post-footer {
            padding: 0.75rem 1rem;
            background-color: #f9f9f9;
            border-top: 1px solid #f0f0f0;
        }
        .post-author {
            display: flex;
            align-items: center;
        }
        .author-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        .post-tag {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            margin-right: 0.5rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #fff;
        }
        .tag-member_recruitment { background-color: #28a745; }
        .tag-bug_fixes { background-color: #dc3545; }
        .tag-discussion { background-color: #007bff; }
        .tag-tutorial { background-color: #17a2b8; }
        .tag-announcement { background-color: #ffc107; color: #212529; }
        .tag-question { background-color: #6f42c1; }
        .tag-resource { background-color: #fd7e14; }
        
        .comment-section {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }
        .comment {
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .comment-author {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .comment-content {
            margin-bottom: 0.5rem;
        }
        .comment-time {
            font-size: 0.75rem;
            color: #6c757d;
        }
        .attachments {
            margin-top: 1rem;
        }
        .attachment-item {
            display: inline-block;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }
        .attachment-img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .attachment-file {
            padding: 0.5rem;
            border: 1px solid #eee;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }
        .attachment-file i {
            margin-right: 0.5rem;
        }
        .post-actions {
            display: flex;
            gap: 10px;
        }
        .dropdown-menu .dropdown-item {
            cursor: pointer;
        }
        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .comment-meta {
            display: flex;
            justify-content: space-between;
        }
        .hide-comment-form {
            display: none;
        }
        /* New Facebook-style styles */
        body {
            background-color: #f0f2f5;
        }
        .container {
            max-width: 900px;
        }
        .create-post-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            padding: 16px;
            margin-bottom: 20px;
        }
        .create-post-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .create-post-input {
            flex-grow: 1;
            background-color: #f0f2f5;
            border-radius: 20px;
            padding: 8px 16px;
            margin-left: 10px;
            cursor: pointer;
            color: #65676b;
        }
        .create-post-input:hover {
            background-color: #e4e6e9;
        }
        .forum-post {
            border-radius: 8px;
            margin-bottom: 16px;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .post-header {
            padding: 12px 16px;
            border-bottom: none;
        }
        .post-content {
            padding: 0 16px 16px;
        }
        .post-footer {
            padding: 8px 16px;
            background-color: white;
            border-top: 1px solid #f0f0f0;
        }
        .filters-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            padding: 16px;
            margin-bottom: 20px;
        }
        .forum-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #1877f2;
        }
        /* Additional Facebook-style enhancements */
        .reaction-count {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }
        .reaction-count i {
            font-size: 1.1rem;
            margin-right: 5px;
        }
        .comment-bubble {
            background-color: #f0f2f5;
            border-radius: 18px;
        }
        .comment {
            margin-bottom: 12px;
        }
        textarea.rounded-pill {
            padding-right: 40px;
            padding-left: 15px;
            height: 40px;
            background-color: #f0f2f5;
            border: none;
        }
        textarea.rounded-pill:focus {
            background-color: #f0f2f5;
            box-shadow: none;
            border: none;
        }
        .post-text {
            font-size: 1.1rem;
            line-height: 1.5;
        }
        .post-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        /* Make the layout more responsive */
        @media (max-width: 576px) {
            .container {
                padding-left: 8px;
                padding-right: 8px;
            }
            .create-post-card, .forum-post, .filters-card {
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <div class="container mt-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="forum-title text-center mb-4">
            Forum
        </div>

        <!-- Create Post Card -->
        <div class="create-post-card">
            <div class="create-post-header">
                <img src="<?= $_SESSION['profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" alt="Your Avatar" class="author-avatar">
                <a href="forum_index.php" class="create-post-input text-decoration-none">
                    What's on your mind, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>?
                </a>
            </div>
            <div class="d-flex justify-content-center border-top pt-3">
                <a href="forum_index.php" class="btn btn-primary w-100">
                    <i class="bi bi-pencil-square me-2"></i>Create New Post
                </a>
            </div>
        </div>

        <!-- Debug info -->
        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
            <div class="alert alert-info">
                <h5>Debug Information:</h5>
                <ul>
                    <li>Total posts: <?= count($allPosts) ?></li>
                    <li>Sort option: <?= htmlspecialchars($sortOption) ?></li>
                    <li>Tag filter: <?= htmlspecialchars($tagFilter) ?></li>
                    <li>Current user ID: <?= htmlspecialchars($_SESSION['user_id']) ?></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Filters Card -->
        <div class="filters-card">
            <form method="GET" class="d-flex gap-2">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" <?= $sortOption == 'newest' ? 'selected' : '' ?>>Newest</option>
                    <option value="upvotes" <?= $sortOption == 'upvotes' ? 'selected' : '' ?>>Most Upvoted</option>
                </select>
                
                <select name="tag" class="form-select" onchange="this.form.submit()">
                    <option value="">All Tags</option>
                    <?php foreach ($allTags as $tag): ?>
                        <option value="<?= $tag['name'] ?>" <?= $tagFilter == $tag['name'] ? 'selected' : '' ?>>
                            <?= ucfirst(str_replace('_', ' ', $tag['name'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <?php if (!empty($tagFilter) || $sortOption != 'newest'): ?>
                    <a href="view_posts.php" class="btn btn-outline-secondary">Clear Filters</a>
                <?php endif; ?>
            </form>
        </div>
        
        <div id="posts-container">
            <?php if (empty($allPosts)): ?>
                <div class="alert alert-info">No posts found. Be the first to create a post!</div>
            <?php else: ?>
                <?php foreach ($allPosts as $post): ?>
                    <div class="forum-post" id="post-<?= $post['_id'] ?>">
                        <div class="post-header">
                            <div class="post-meta">
                                <div class="post-author">
                                    <img src="<?= $post['user_profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" alt="Avatar" class="author-avatar">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($post['user_name'] ?? 'Unknown User') ?></div>
                                        <div class="text-muted small">
                                            <?php if (isset($post['created_at']) && !empty($post['created_at'])): ?>
                                                <?php
                                                    $dateTime = null;
                                                    if (is_object($post['created_at']) && method_exists($post['created_at'], 'toDateTime')) {
                                                        $dateTime = $post['created_at']->toDateTime();
                                                    } elseif (is_string($post['created_at']) || is_numeric($post['created_at'])) {
                                                        $dateTime = new DateTime('@' . (int)$post['created_at']);
                                                    }
                                                    
                                                    echo $dateTime ? date('M j, Y \a\t g:i a', $dateTime->getTimestamp()) : 'Unknown date';
                                                    
                                                    // Check if updated
                                                    if (isset($post['updated_at']) && !empty($post['updated_at'])) {
                                                        $updateDateTime = null;
                                                        if (is_object($post['updated_at']) && method_exists($post['updated_at'], 'toDateTime')) {
                                                            $updateDateTime = $post['updated_at']->toDateTime();
                                                        } elseif (is_string($post['updated_at']) || is_numeric($post['updated_at'])) {
                                                            $updateDateTime = new DateTime('@' . (int)$post['updated_at']);
                                                        }
                                                        
                                                        if ($dateTime && $updateDateTime && $updateDateTime->getTimestamp() > $dateTime->getTimestamp()) {
                                                            echo ' (edited)';
                                                        }
                                                    }
                                                ?>
                                            <?php else: ?>
                                                Unknown date
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (isset($_SESSION['user_id']) && isset($post['user_id']) && $_SESSION['user_id'] === $post['user_id']): ?>
                                    <div class="post-actions">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item edit-post-btn" href="edit_post.php?id=<?= $post['_id'] ?>">Edit</a></li>
                                                <li><a class="dropdown-item delete-post-btn" href="#" data-post-id="<?= $post['_id'] ?>">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="post-content">
                            <h3 class="post-title mb-3">
                                <a href="post_details.php?id=<?= $post['_id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h3>
                            
                            <div class="post-tags mb-3">
                                <?php 
                                // Tags are already converted in the mapping function
                                if (!empty($post['tags'])):
                                    foreach ($post['tags'] as $tag): 
                                ?>
                                        <span class="post-tag tag-<?= $tag ?>">
                                            <?= ucfirst(str_replace('_', ' ', $tag)) ?>
                                        </span>
                                <?php 
                                    endforeach;
                                endif; 
                                ?>
                            </div>
                            
                            <div class="post-text mb-3">
                                <a href="post_details.php?id=<?= $post['_id'] ?>" class="text-decoration-none text-dark">
                                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                                </a>
                            </div>
                            
                            <?php if (!empty($post['attachments'])): ?>
                                <div class="attachments">
                                    <?php foreach ($post['attachments'] as $attachment): ?>
                                        <?php 
                                        $isImage = strpos($attachment['file_type'], 'image/') === 0;
                                        $fileExt = pathinfo($attachment['original_name'], PATHINFO_EXTENSION);
                                        ?>
                                        
                                        <div class="attachment-item">
                                            <a href="<?= $attachment['file_path'] ?>" target="_blank" class="text-decoration-none">
                                                <?php if ($isImage): ?>
                                                    <img src="<?= $attachment['file_path'] ?>" alt="Attachment" class="attachment-img">
                                                <?php else: ?>
                                                    <div class="attachment-file">
                                                        <i class="bi bi-file-earmark"></i>
                                                        <span><?= htmlspecialchars($attachment['original_name']) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="post-footer">
                            <!-- Reaction counts display -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="reaction-count">
                                    <i class="bi bi-hand-thumbs-up-fill text-primary"></i>
                                    <span class="upvote-count" data-post-id="<?= $post['_id'] ?>"><?= $post['upvotes'] ?? 0 ?></span>
                                </div>
                                <div class="ms-auto">
                                    <span class="text-muted"><?= count($post['comments'] ?? []) ?> comments</span>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <hr class="my-1">
                            
                            <!-- Action buttons -->
                            <div class="d-flex justify-content-between">
                                <?php 
                                // All arrays are already converted in the mapping function
                                $isUpvoted = in_array($_SESSION['user_id'], $post['upvoted_by'] ?? []);
                                ?>
                                <button class="btn btn-link text-decoration-none flex-fill upvote-btn <?= $isUpvoted ? 'text-primary fw-bold' : 'text-muted' ?>" 
                                        data-post-id="<?= $post['_id'] ?>">
                                    <i class="bi bi-hand-thumbs-up me-1"></i> Like
                                </button>
                                
                                <button class="btn btn-link text-decoration-none flex-fill text-muted toggle-comments-btn" data-post-id="<?= $post['_id'] ?>">
                                    <i class="bi bi-chat-left-text me-1"></i> Comment
                                </button>
                                
                                <button class="btn btn-link text-decoration-none flex-fill text-muted">
                                    <i class="bi bi-share me-1"></i> Share
                                </button>
                            </div>
                            
                            <div class="comment-section" id="comments-<?= $post['_id'] ?>" style="display: none;">
                                <hr class="my-2">
                                <div class="comments-container">
                                    <?php if (!empty($post['comments'])): ?>
                                        <?php foreach ($post['comments'] as $index => $comment): ?>
                                            <div class="comment" id="comment-<?= $post['_id'] ?>-<?= $index ?>">
                                                <div class="d-flex">
                                                    <img src="<?= isset($comment['user_profile_pic']) ? $comment['user_profile_pic'] : 'uploads/profile_images/user_avater.png' ?>" 
                                                         alt="Avatar" class="author-avatar" style="width: 32px; height: 32px;">
                                                    <div class="flex-grow-1">
                                                        <div class="comment-bubble p-2 bg-light rounded">
                                                            <div class="comment-meta">
                                                                <div class="comment-author fw-bold"><?= htmlspecialchars($comment['user_name'] ?? 'Unknown') ?></div>
                                                                
                                                                <?php if (isset($_SESSION['user_id']) && isset($comment['user_id']) && $_SESSION['user_id'] === $comment['user_id']): ?>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-sm text-muted p-0 ms-2" type="button" data-bs-toggle="dropdown">
                                                                            <i class="bi bi-three-dots"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                                            <li><a class="dropdown-item edit-comment-btn" href="#" 
                                                                                data-post-id="<?= $post['_id'] ?>" 
                                                                                data-comment-index="<?= $index ?>">Edit</a></li>
                                                                            <li><a class="dropdown-item delete-comment-btn" href="#" 
                                                                                data-post-id="<?= $post['_id'] ?>" 
                                                                                data-comment-index="<?= $index ?>">Delete</a></li>
                                                                        </ul>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <div class="comment-content"><?= nl2br(htmlspecialchars($comment['text'] ?? '')) ?></div>
                                                        </div>
                                                        <div class="comment-actions small mt-1">
                                                            <span class="text-muted comment-time">
                                                                <?php if (isset($comment['time']) && !empty($comment['time'])): ?>
                                                                    <?php
                                                                        $commentTime = null;
                                                                        if (is_object($comment['time']) && method_exists($comment['time'], 'toDateTime')) {
                                                                            $commentTime = $comment['time']->toDateTime();
                                                                        } elseif (is_string($comment['time']) || is_numeric($comment['time'])) {
                                                                            $commentTime = new DateTime('@' . (int)$comment['time']);
                                                                        }
                                                                        
                                                                        echo $commentTime ? date('M j, Y \a\t g:i a', $commentTime->getTimestamp()) : 'Unknown time';
                                                                        
                                                                        if (isset($comment['edited']) && $comment['edited']) {
                                                                            echo ' (edited)';
                                                                        }
                                                                    ?>
                                                                <?php else: ?>
                                                                    Unknown time
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                        
                                                        <!-- Edit form (hidden by default) -->
                                                        <form class="edit-comment-form hide-comment-form mt-2" 
                                                            id="edit-comment-form-<?= $post['_id'] ?>-<?= $index ?>">
                                                            <textarea class="form-control mb-2" required><?= htmlspecialchars($comment['text'] ?? '') ?></textarea>
                                                            <div class="d-flex gap-2">
                                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                                <button type="button" class="btn btn-sm btn-secondary cancel-edit-btn">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                                    <?php endif; ?>
                                </div>
                                
                                <form class="add-comment-form mt-3 d-flex" data-post-id="<?= $post['_id'] ?>">
                                    <img src="<?= $_SESSION['profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" 
                                         alt="Your Avatar" class="author-avatar" style="width: 32px; height: 32px;">
                                    <div class="flex-grow-1 ms-2">
                                        <div class="position-relative">
                                            <textarea class="form-control rounded-pill" placeholder="Write a comment..." required></textarea>
                                            <button type="submit" class="btn btn-link position-absolute end-0 top-50 translate-middle-y">
                                                <i class="bi bi-send-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmation-message">Are you sure you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debug flag - set to true to see console messages
        const DEBUG = true;
        
        function debug(message) {
            if (DEBUG) {
                console.log(message);
            }
        }
        
        // Initialize Bootstrap components
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        let deleteTarget = null;
        let deleteType = '';
        
        // Toggle comments visibility
        document.querySelectorAll('.toggle-comments-btn').forEach(btn => {
            debug('Initializing comment toggle for button: ' + btn.getAttribute('data-post-id'));
            btn.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const commentsSection = document.getElementById(`comments-${postId}`);
                
                if (commentsSection) {
                    if (commentsSection.style.display === 'none') {
                        commentsSection.style.display = 'block';
                        this.classList.add('text-primary');
                        this.classList.remove('text-muted');
                    } else {
                        commentsSection.style.display = 'none';
                        this.classList.add('text-muted');
                        this.classList.remove('text-primary');
                    }
                } else {
                    console.error(`Comments section not found for post ${postId}`);
                }
            });
        });
        
        // Handle upvotes
        document.querySelectorAll('.upvote-btn').forEach(btn => {
            debug('Initializing upvote for button: ' + btn.getAttribute('data-post-id'));
            btn.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const button = this;
                
                fetch('src/controller/update_votes.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ postId: postId })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update UI
                        const countElements = document.querySelectorAll(`.upvote-count[data-post-id="${postId}"], .upvote-btn[data-post-id="${postId}"] .upvote-count`);
                        countElements.forEach(el => {
                            el.textContent = data.upvotes;
                        });
                        
                        if (data.upvoted) {
                            button.classList.add('text-primary', 'fw-bold');
                            button.classList.remove('text-muted');
                        } else {
                            button.classList.add('text-muted');
                            button.classList.remove('text-primary', 'fw-bold');
                        }
                    } else {
                        throw new Error(data.message || 'Failed to update vote');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating vote: ' + error.message);
                });
            });
        });
        
        // Auto-resize textarea for comments
        document.querySelectorAll('.add-comment-form textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            
            // Focus event to expand textarea
            textarea.addEventListener('focus', function() {
                this.style.height = 'auto';
                this.style.height = Math.max(80, this.scrollHeight) + 'px';
            });
            
            // Blur event to collapse textarea if empty
            textarea.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.style.height = '40px';
                }
            });
        });
        
        // Add comment
        document.querySelectorAll('.add-comment-form').forEach(form => {
            debug('Initializing comment form for post: ' + form.getAttribute('data-post-id'));
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const postId = this.getAttribute('data-post-id');
                const textarea = this.querySelector('textarea');
                const submitButton = this.querySelector('button[type="submit"]');
                
                if (!textarea || !submitButton) {
                    console.error('Required form elements not found');
                    return;
                }
                
                const commentText = textarea.value.trim();
                if (!commentText) {
                    alert('Please enter a comment');
                    return;
                }
                
                // Disable form while submitting
                textarea.disabled = true;
                submitButton.disabled = true;
                
                fetch('src/controller/add_comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        postId: postId,
                        comment: commentText
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Reload the page to show the new comment
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to add comment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding comment: ' + error.message);
                })
                .finally(() => {
                    // Re-enable form
                    textarea.disabled = false;
                    submitButton.disabled = false;
                });
            });
        });
        
        // Handle delete post button
        document.querySelectorAll('.delete-post-btn').forEach(btn => {
            debug('Initializing delete button for post: ' + btn.getAttribute('data-post-id'));
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                deleteTarget = this.getAttribute('data-post-id');
                deleteType = 'post';
                
                document.getElementById('confirmation-message').textContent = 
                    'Are you sure you want to delete this post? This action cannot be undone.';
                confirmationModal.show();
            });
        });
        
        // Handle delete comment button
        document.querySelectorAll('.delete-comment-btn').forEach(btn => {
            debug('Initializing delete button for comment');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                deleteTarget = {
                    postId: this.getAttribute('data-post-id'),
                    commentIndex: this.getAttribute('data-comment-index')
                };
                deleteType = 'comment';
                
                document.getElementById('confirmation-message').textContent = 
                    'Are you sure you want to delete this comment? This action cannot be undone.';
                confirmationModal.show();
            });
        });
        
        // Handle confirm delete button
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                if (!deleteTarget || !deleteType) {
                    console.error('Delete target or type not set');
                    return;
                }
                
                let url = deleteType === 'post' ? 'src/controller/delete_post.php' : 'src/controller/delete_comment.php';
                let data = deleteType === 'post' ? { postId: deleteTarget } : deleteTarget;
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (deleteType === 'post') {
                            const postElement = document.getElementById(`post-${deleteTarget}`);
                            if (postElement) {
                                postElement.remove();
                            }
                        } else {
                            const commentElement = document.getElementById(
                                `comment-${deleteTarget.postId}-${deleteTarget.commentIndex}`
                            );
                            if (commentElement) {
                                commentElement.remove();
                            }
                        }
                        confirmationModal.hide();
                    } else {
                        throw new Error(data.message || 'Failed to delete');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                });
            });
        }
        
        // Handle edit comment
        document.querySelectorAll('.edit-comment-btn').forEach(btn => {
            debug('Initializing edit button for comment');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const postId = this.getAttribute('data-post-id');
                const commentIndex = this.getAttribute('data-comment-index');
                const commentElement = document.getElementById(`comment-${postId}-${commentIndex}`);
                const editForm = document.getElementById(`edit-comment-form-${postId}-${commentIndex}`);
                
                if (commentElement && editForm) {
                    // Show the edit form
                    const contentElement = commentElement.querySelector('.comment-content');
                    if (contentElement) {
                        contentElement.style.display = 'none';
                    }
                    editForm.classList.remove('hide-comment-form');
                }
            });
        });
        
        // Handle cancel edit button
        document.querySelectorAll('.cancel-edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('.edit-comment-form');
                const commentElement = form.closest('.comment');
                
                if (commentElement) {
                    // Hide the edit form and show the content
                    form.classList.add('hide-comment-form');
                    const contentElement = commentElement.querySelector('.comment-content');
                    if (contentElement) {
                        contentElement.style.display = 'block';
                    }
                }
            });
        });
        
        // Handle edit comment form submission
        document.querySelectorAll('.edit-comment-form').forEach(form => {
            debug('Initializing edit form for comment');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formId = this.id;
                const matches = formId.match(/edit-comment-form-([a-f0-9]+)-(\d+)/);
                if (!matches) {
                    console.error('Invalid form ID format');
                    return;
                }
                
                const [_, postId, commentIndex] = matches;
                const textarea = this.querySelector('textarea');
                const submitButton = this.querySelector('button[type="submit"]');
                
                if (!textarea || !submitButton) {
                    console.error('Required form elements not found');
                    return;
                }
                
                const newText = textarea.value.trim();
                if (!newText) {
                    alert('Please enter a comment');
                    return;
                }
                
                // Disable form while submitting
                textarea.disabled = true;
                submitButton.disabled = true;
                
                fetch('src/controller/edit_comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        postId: postId,
                        commentIndex: parseInt(commentIndex),
                        text: newText
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update the UI
                        const commentElement = document.getElementById(`comment-${postId}-${commentIndex}`);
                        if (commentElement) {
                            const contentElement = commentElement.querySelector('.comment-content');
                            if (contentElement) {
                                contentElement.textContent = newText;
                                contentElement.style.display = 'block';
                            }
                            this.classList.add('hide-comment-form');
                            
                            // Add "edited" text if not already there
                            const timeElement = commentElement.querySelector('.comment-time');
                            if (timeElement && !timeElement.textContent.includes('(edited)')) {
                                timeElement.textContent += ' (edited)';
                            }
                        }
                    } else {
                        throw new Error(data.message || 'Failed to update comment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating comment: ' + error.message);
                })
                .finally(() => {
                    // Re-enable form
                    textarea.disabled = false;
                    submitButton.disabled = false;
                });
            });
        });
        
        debug('All event listeners initialized');
    });
    </script>
</body>
</html>