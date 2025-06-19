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
use MongoDB\Driver\Exception\ConnectionException;
use MongoDB\Driver\Exception\ConnectionTimeoutException;

session_start();

// Redirect if not logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: view_posts.php');
    exit();
}

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    $forumPostsCollection = $db->forum_posts;
    
    // Try to convert the ID to ObjectId
    $postId = null;
    try {
        $postId = new \MongoDB\BSON\ObjectId($_GET['id']);
    } catch (Exception $e) {
        // If the ID is not a valid ObjectId, keep it as is
        $postId = $_GET['id'];
    }
    
    // Find post
    $post = $forumPostsCollection->findOne(['_id' => $postId]);
    
    // If post doesn't exist in forum_posts, try the old forum collection
    if (!$post) {
        $forumCollection = $db->forum;
        $post = $forumCollection->findOne(['_id' => $postId]);
        
        if (!$post) {
            $_SESSION['error'] = 'Post not found';
            header('Location: view_posts.php');
            exit();
        }
    }
    
    // Convert BSON arrays to PHP arrays
    if (isset($post['tags']) && $post['tags'] instanceof MongoDB\Model\BSONArray) {
        $post['tags'] = $post['tags']->getArrayCopy();
    }
    
    if (isset($post['upvoted_by']) && $post['upvoted_by'] instanceof MongoDB\Model\BSONArray) {
        $post['upvoted_by'] = $post['upvoted_by']->getArrayCopy();
    }
    
    if (isset($post['comments']) && $post['comments'] instanceof MongoDB\Model\BSONArray) {
        $post['comments'] = $post['comments']->getArrayCopy();
    }
    
    if (isset($post['attachments']) && $post['attachments'] instanceof MongoDB\Model\BSONArray) {
        $post['attachments'] = $post['attachments']->getArrayCopy();
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = 'Error loading post: ' . $e->getMessage();
    header('Location: view_posts.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - Research Forum</title>
    
    <!-- Core styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Animation libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/theme.css">
    <link rel="stylesheet" href="assets/styles/forum_style.css">
    <!-- Performance optimization styles -->
    <link rel="stylesheet" href="assets/styles/performance.css">
    
    <!-- Prevent Theme Flash Script - Must run immediately -->
    <script>
    (function() {
        // Get saved theme immediately to prevent flash
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        }
    })();
    </script>
    
    <!-- Performance optimization script - Load early for immediate optimizations -->
    <script src="assets/js/performance-optimizer.js" defer></script>
    
    <!-- Preload fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Modern UI Styles */
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #0f172a;
            --success-color: #06b6d4;
            --warning-color: #f59e0b;
            --modern-blue: #0ea5e9;
            --modern-purple: #8b5cf6;
            --modern-teal: #14b8a6;
            --modern-gray: #6b7280;
            --card-bg: rgba(15, 23, 42, 0.6);
            --glass-bg: rgba(22, 28, 45, 0.7);
            --border-glow: rgba(37, 99, 235, 0.5);
            --surface-1: rgba(30, 41, 59, 0.6);
            --surface-2: rgba(15, 23, 42, 0.8);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
        }

        body {
            background: linear-gradient(135deg, #0a0d1a 0%, #1a1a2e 50%, #16213e 100%);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
        }

        /* Background Effects */
        .background-effects {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(to right, rgba(37, 99, 235, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            animation: grid-pulse 4s ease-in-out infinite;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.4;
            animation: float-orb 15s ease-in-out infinite;
            box-shadow: 0 0 50px currentColor;
        }

        .orb-1 {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, rgba(37, 99, 235, 0.1) 50%, transparent 70%);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, rgba(14, 165, 233, 0.08) 50%, transparent 70%);
            top: 60%;
            right: 10%;
            animation-delay: 7s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.3) 0%, rgba(6, 182, 212, 0.1) 50%, transparent 70%);
            bottom: 20%;
            left: 20%;
            animation-delay: 14s;
        }

        @keyframes float-orb {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            25% { transform: translate(30px, -20px) scale(1.05) rotate(90deg); }
            50% { transform: translate(-20px, 30px) scale(0.95) rotate(180deg); }
            75% { transform: translate(25px, 15px) scale(1.02) rotate(270deg); }
        }

        @keyframes grid-pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        /* Post Details Specific Styles */
        .container {
            max-width: 900px;
            position: relative;
            z-index: 1;
        }

        .post-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .post-content {
            padding: 2rem 1.5rem;
        }

        .post-footer {
            padding: 1rem 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .post-tag {
            background: var(--modern-blue);
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 500;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .post-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .comment-section {
            margin-top: 2rem;
            background: var(--surface-1);
            border-radius: 1rem;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .comment {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .comment:hover {
            transform: translateY(-2px);
        }

        .comment-bubble {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1rem;
        }

        .share-link {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .share-link:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--modern-blue);
        }

        .attachments {
            margin-top: 1.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .attachment-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .attachment-item:hover {
            transform: translateY(-2px);
        }

        .attachment-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .attachment-file {
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .attachment-file:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--modern-blue);
        }

        /* Form Controls */
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            border-radius: 0.5rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--modern-blue);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <!-- Background Effects -->
    <div class="background-effects">
        <div class="cyber-grid"></div>
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <div class="container mt-5">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger fade-in">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="post-card fade-in" data-aos="fade-up">
            <div class="post-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex">
                        <img src="<?= $post['user_profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" 
                             alt="Avatar" class="author-avatar">
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($post['user_name'] ?? 'Unknown User') ?></h5>
                            <p class="text-muted mb-0">
                                <?php
                                    $dateTime = null;
                                    if (is_object($post['created_at']) && method_exists($post['created_at'], 'toDateTime')) {
                                        $dateTime = $post['created_at']->toDateTime();
                                        $dateTime->setTimezone(new DateTimeZone('Asia/Dhaka'));
                                    } elseif (is_string($post['created_at']) || is_numeric($post['created_at'])) {
                                        $dateTime = new DateTime('@' . (int)$post['created_at']);
                                        $dateTime->setTimezone(new DateTimeZone('Asia/Dhaka'));
                                    }
                                    echo $dateTime ? $dateTime->format('F j, Y \a\t g:i a') : 'Unknown date';
                                    
                                    if (isset($post['updated_at']) && $post['updated_at'] != $post['created_at']) {
                                        echo ' (edited)';
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="edit_post.php?id=<?= $post['_id'] ?>">
                                        <i class="bi bi-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="src/controller/delete_post.php" method="POST" class="d-inline">
                                        <input type="hidden" name="post_id" value="<?= $post['_id'] ?>">
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                            <i class="bi bi-trash me-2"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="post-content">
                <h2 class="mb-4"><?= htmlspecialchars($post['title']) ?></h2>
                <div class="mb-3">
                    <?php foreach ($post['tags'] as $tag): ?>
                        <span class="post-tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="content-text">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>

                <?php if (!empty($post['attachments'])): ?>
                    <div class="attachments">
                        <?php foreach ($post['attachments'] as $attachment): ?>
                            <?php
                                $fileExtension = strtolower(pathinfo($attachment['filename'], PATHINFO_EXTENSION));
                                $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                            ?>
                            <div class="attachment-item">
                                <?php if ($isImage): ?>
                                    <a href="<?= htmlspecialchars($attachment['path']) ?>" target="_blank">
                                        <img src="<?= htmlspecialchars($attachment['path']) ?>" alt="Attachment" class="attachment-img">
                                    </a>
                                <?php else: ?>
                                    <a href="<?= htmlspecialchars($attachment['path']) ?>" class="attachment-file" download>
                                        <i class="bi bi-file-earmark me-2"></i>
                                        <?= htmlspecialchars($attachment['filename']) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="post-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-3">
                        <button class="btn btn-link text-decoration-none text-muted vote-btn" data-post-id="<?= $post['_id'] ?>" data-vote-type="upvote">
                            <i class="bi bi-hand-thumbs-up<?= in_array($_SESSION['user_id'], $post['upvoted_by'] ?? []) ? '-fill' : '' ?>"></i>
                            <span class="upvote-count"><?= count($post['upvoted_by'] ?? []) ?></span>
                        </button>
                        <button class="btn btn-link text-decoration-none text-muted toggle-comments-btn" data-post-id="<?= $post['_id'] ?>">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="comment-count"><?= count($post['comments'] ?? []) ?></span>
                        </button>
                        <button class="btn btn-link text-decoration-none text-muted share-btn" 
                                data-post-url="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
                            <i class="bi bi-share"></i> Share
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comment-section fade-in" data-aos="fade-up" data-aos-delay="100">
            <h3 class="mb-4">Comments</h3>
            
            <!-- Add Comment Form -->
            <form action="src/controller/add_comment.php" method="POST" class="mb-4">
                <input type="hidden" name="post_id" value="<?= $post['_id'] ?>">
                <div class="form-group">
                    <textarea name="content" class="form-control mb-3" rows="3" placeholder="Write a comment..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>

            <!-- Comments List -->
            <div class="comments-list">
                <?php if (!empty($post['comments'])): ?>
                    <?php foreach (array_reverse($post['comments']) as $comment): ?>
                        <div class="comment fade-in" data-aos="fade-up" data-aos-delay="150">
                            <div class="d-flex mb-2">
                                <img src="<?= $comment['user_profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" 
                                     alt="Avatar" class="author-avatar" style="width: 32px; height: 32px;">
                                <div class="ms-2">
                                    <h6 class="mb-0"><?= htmlspecialchars($comment['user_name'] ?? 'Unknown User') ?></h6>
                                    <small class="text-muted">
                                        <?php
                                            $commentDateTime = null;
                                            if (is_object($comment['created_at']) && method_exists($comment['created_at'], 'toDateTime')) {
                                                $commentDateTime = $comment['created_at']->toDateTime();
                                                $commentDateTime->setTimezone(new DateTimeZone('Asia/Dhaka'));
                                            } elseif (is_string($comment['created_at']) || is_numeric($comment['created_at'])) {
                                                $commentDateTime = new DateTime('@' . (int)$comment['created_at']);
                                                $commentDateTime->setTimezone(new DateTimeZone('Asia/Dhaka'));
                                            }
                                            echo $commentDateTime ? $commentDateTime->format('F j, Y \a\t g:i a') : 'Unknown date';
                                        ?>
                                    </small>
                                </div>
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                    <div class="dropdown ms-auto">
                                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item edit-comment-btn" 
                                                        data-comment-id="<?= $comment['_id'] ?>"
                                                        data-comment-content="<?= htmlspecialchars($comment['content']) ?>">
                                                    <i class="bi bi-pencil me-2"></i> Edit
                                                </button>
                                            </li>
                                            <li>
                                                <form action="src/controller/delete_comment.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="post_id" value="<?= $post['_id'] ?>">
                                                    <input type="hidden" name="comment_id" value="<?= $comment['_id'] ?>">
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="comment-bubble">
                                <?= nl2br(htmlspecialchars($comment['content'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Handle share button clicks
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const postUrl = this.getAttribute('data-post-url');
                try {
                    await navigator.clipboard.writeText(postUrl);
                    
                    // Show success tooltip
                    const tooltip = document.createElement('div');
                    tooltip.textContent = 'Link copied!';
                    tooltip.style.cssText = `
                        position: fixed;
                        background: var(--glass-bg);
                        color: var(--text-primary);
                        padding: 8px 16px;
                        border-radius: 4px;
                        z-index: 1000;
                        left: 50%;
                        transform: translateX(-50%);
                        bottom: 20px;
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                        animation: fadeInUp 0.3s ease-out;
                    `;
                    document.body.appendChild(tooltip);
                    
                    setTimeout(() => {
                        tooltip.style.animation = 'fadeOutDown 0.3s ease-out';
                        setTimeout(() => tooltip.remove(), 300);
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy:', err);
                }
            });
        });

        // Handle comment editing
        document.querySelectorAll('.edit-comment-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const content = this.getAttribute('data-comment-content');
                const commentBubble = this.closest('.comment').querySelector('.comment-bubble');
                
                const textarea = document.createElement('textarea');
                textarea.className = 'form-control mb-2';
                textarea.value = content;
                
                const saveBtn = document.createElement('button');
                saveBtn.className = 'btn btn-primary btn-sm me-2';
                saveBtn.textContent = 'Save';
                
                const cancelBtn = document.createElement('button');
                cancelBtn.className = 'btn btn-secondary btn-sm';
                cancelBtn.textContent = 'Cancel';
                
                const buttonsDiv = document.createElement('div');
                buttonsDiv.appendChild(saveBtn);
                buttonsDiv.appendChild(cancelBtn);
                
                const originalContent = commentBubble.innerHTML;
                commentBubble.innerHTML = '';
                commentBubble.appendChild(textarea);
                commentBubble.appendChild(buttonsDiv);
                
                saveBtn.addEventListener('click', async () => {
                    const formData = new FormData();
                    formData.append('comment_id', commentId);
                    formData.append('post_id', '<?= $post['_id'] ?>');
                    formData.append('content', textarea.value);
                    
                    try {
                        const response = await fetch('src/controller/edit_comment.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        if (response.ok) {
                            commentBubble.innerHTML = textarea.value.replace(/\n/g, '<br>');
                            this.setAttribute('data-comment-content', textarea.value);
                        } else {
                            throw new Error('Failed to update comment');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        commentBubble.innerHTML = originalContent;
                    }
                });
                
                cancelBtn.addEventListener('click', () => {
                    commentBubble.innerHTML = originalContent;
                });
            });
        });

        // Handle voting
        document.querySelectorAll('.vote-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const postId = this.getAttribute('data-post-id');
                const voteType = this.getAttribute('data-vote-type');
                const icon = this.querySelector('i');
                const countSpan = this.querySelector('.upvote-count');
                
                try {
                    const response = await fetch('src/controller/update_votes.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `post_id=${postId}&vote_type=${voteType}`
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        icon.className = `bi bi-hand-thumbs-up${data.hasVoted ? '-fill' : ''}`;
                        countSpan.textContent = data.voteCount;
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
</body>
</html> 