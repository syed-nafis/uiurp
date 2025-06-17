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
        $postId = new ObjectId($_GET['id']);
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
    <title><?= htmlspecialchars($post['title']) ?> - Forum Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/forum_style.css">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .container {
            max-width: 900px;
        }
        .post-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .post-header {
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
        }
        .post-content {
            padding: 20px 16px;
        }
        .post-footer {
            padding: 12px 16px;
            border-top: 1px solid #f0f0f0;
        }
        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
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
            margin-top: 20px;
        }
        .comment {
            margin-bottom: 16px;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .comment-bubble {
            background-color: #f0f2f5;
            border-radius: 18px;
            padding: 12px;
        }
        .share-link {
            padding: 8px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .attachments {
            margin-top: 20px;
        }
        .attachment-item {
            display: inline-block;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }
        .attachment-img {
            max-width: 200px;
            max-height: 200px;
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
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <div class="container mt-4">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="post-card">
            <div class="post-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex">
                        <img src="<?= $post['user_profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" 
                             alt="Avatar" class="author-avatar">
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
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="edit_post.php?id=<?= $post['_id'] ?>">Edit</a></li>
                                <li><a class="dropdown-item delete-post-btn" href="#" data-post-id="<?= $post['_id'] ?>">Delete</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="post-content">
                <h1 class="h3 mb-3"><?= htmlspecialchars($post['title']) ?></h1>
                
                <div class="post-tags mb-3">
                    <?php foreach ($post['tags'] as $tag): ?>
                        <span class="post-tag tag-<?= $tag ?>">
                            <?= ucfirst(str_replace('_', ' ', $tag)) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                
                <div class="post-text mb-4">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>
                
                <?php if (!empty($post['attachments'])): ?>
                    <div class="attachments">
                        <?php foreach ($post['attachments'] as $attachment): ?>
                            <?php 
                            $isImage = strpos($attachment['file_type'], 'image/') === 0;
                            ?>
                            <div class="attachment-item">
                                <a href="<?= $attachment['file_path'] ?>" target="_blank" class="text-decoration-none">
                                    <?php if ($isImage): ?>
                                        <img src="<?= $attachment['file_path'] ?>" alt="Attachment" class="attachment-img">
                                    <?php else: ?>
                                        <div class="attachment-file">
                                            <i class="bi bi-file-earmark me-2"></i>
                                            <span><?= htmlspecialchars($attachment['original_name']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Share Link -->
                <div class="mt-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted">Share this post:</span>
                        <div class="share-link flex-grow-1">
                            <span id="share-url"><?= 'http://' . $_SERVER['HTTP_HOST'] . '/post_details.php?id=' . $post['_id'] ?></span>
                        </div>
                        <button class="btn btn-outline-primary btn-sm" onclick="copyShareLink()">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                    </div>
                </div>
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
                
                <hr class="my-2">
                
                <!-- Action buttons -->
                <div class="d-flex justify-content-between">
                    <?php 
                    $isUpvoted = in_array($_SESSION['user_id'], $post['upvoted_by'] ?? []);
                    ?>
                    <button class="btn btn-link text-decoration-none flex-fill upvote-btn <?= $isUpvoted ? 'text-primary fw-bold' : 'text-muted' ?>" 
                            data-post-id="<?= $post['_id'] ?>">
                        <i class="bi bi-hand-thumbs-up me-1"></i> Like
                    </button>
                    
                    <button class="btn btn-link text-decoration-none flex-fill text-muted" id="comment-focus-btn">
                        <i class="bi bi-chat-left-text me-1"></i> Comment
                    </button>
                    
                    <button class="btn btn-link text-decoration-none flex-fill text-muted" onclick="copyShareLink()">
                        <i class="bi bi-share me-1"></i> Share
                    </button>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comment-section">
            <h3 class="h5 mb-4">Comments</h3>
            
            <div class="comments-container mb-4">
                <?php if (!empty($post['comments'])): ?>
                    <?php foreach ($post['comments'] as $index => $comment): ?>
                        <div class="comment" id="comment-<?= $post['_id'] ?>-<?= $index ?>">
                            <div class="d-flex">
                                <img src="<?= isset($comment['user_profile_pic']) ? $comment['user_profile_pic'] : 'uploads/profile_images/user_avater.png' ?>" 
                                     alt="Avatar" class="author-avatar" style="width: 32px; height: 32px;">
                                <div class="flex-grow-1">
                                    <div class="comment-bubble">
                                        <div class="d-flex justify-content-between align-items-start">
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
            
            <!-- Add Comment Form -->
            <form class="add-comment-form" data-post-id="<?= $post['_id'] ?>">
                <div class="d-flex gap-2">
                    <img src="<?= $_SESSION['profile_pic'] ?? 'uploads/profile_images/user_avater.png' ?>" 
                         alt="Your Avatar" class="author-avatar" style="width: 32px; height: 32px;">
                    <div class="flex-grow-1">
                        <textarea class="form-control mb-2" placeholder="Write a comment..." required id="comment-input"></textarea>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </div>
                </div>
            </form>
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
                        const countElements = document.querySelectorAll(`.upvote-count[data-post-id="${postId}"]`);
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
        document.getElementById('confirm-delete-btn').addEventListener('click', function() {
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
                        window.location.href = 'view_posts.php';
                    } else {
                        const commentElement = document.getElementById(
                            `comment-${deleteTarget.postId}-${deleteTarget.commentIndex}`
                        );
                        if (commentElement) {
                            commentElement.remove();
                        }
                        confirmationModal.hide();
                    }
                } else {
                    throw new Error(data.message || 'Failed to delete');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        });
        
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
        
        // Handle add comment form
        document.querySelector('.add-comment-form').addEventListener('submit', function(e) {
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
        
        // Handle comment focus button
        document.getElementById('comment-focus-btn').addEventListener('click', function() {
            document.getElementById('comment-input').focus();
        });
        
        // Handle share link copying
        window.copyShareLink = function() {
            const shareUrl = document.getElementById('share-url').textContent;
            navigator.clipboard.writeText(shareUrl).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy link:', err);
                alert('Failed to copy link. Please try selecting and copying manually.');
            });
        };
        
        debug('All event listeners initialized');
    });
    </script>
</body>
</html> 