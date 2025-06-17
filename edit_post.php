<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/model/db_connect.php';

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

$postId = $_GET['id'];

// Get database connection
$client = connectToDatabase();
$db = $client->uiurp;
$collection = $db->forum_posts;
$tagCollection = $db->forum_tags;

// Get the post
$post = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);

// Check if post exists and belongs to the current user
if (!$post || $post['user_id'] !== $_SESSION['user_id']) {
    header('Location: view_posts.php');
    exit();
}

// Get all available tags
$tags = $tagCollection->find()->toArray();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/forum_style.css">
    <style>
        .tag-checkbox {
            display: none;
        }
        .tag-label {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            margin: 0.2rem;
            border-radius: 2rem;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
        }
        .tag-checkbox:checked + .tag-label {
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px currentColor;
        }
        .form-section {
            margin-bottom: 1.5rem;
        }
        .current-attachments {
            margin-top: 1rem;
        }
        .attachment-item {
            display: inline-block;
            margin: 0.5rem;
            position: relative;
        }
        .attachment-item img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 4px;
        }
        .attachment-item .remove-attachment {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            text-align: center;
            line-height: 22px;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .file-name {
            font-size: 0.8rem;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        #preview-container {
            margin-top: 1rem;
        }
        .preview-item {
            display: inline-block;
            margin: 0.5rem;
            position: relative;
        }
        .preview-item img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 4px;
        }
        .preview-item .remove-file {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            text-align: center;
            line-height: 22px;
            cursor: pointer;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Edit Post</h3>
                    </div>
                    <div class="card-body">
                        <form id="edit-post-form" enctype="multipart/form-data">
                            <input type="hidden" id="postId" name="postId" value="<?= $postId ?>">
                            
                            <div class="form-section">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
                            </div>
                            
                            <div class="form-section">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
                            </div>
                            
                            <div class="form-section">
                                <label class="form-label">Tags (select at least one)</label>
                                <div class="tags-container">
                                    <?php foreach ($tags as $tag): ?>
                                        <input type="checkbox" 
                                               class="tag-checkbox" 
                                               id="tag-<?= $tag['name'] ?>" 
                                               name="tags[]" 
                                               value="<?= $tag['name'] ?>"
                                               <?= in_array($tag['name'], $post['tags']) ? 'checked' : '' ?>>
                                        <label class="tag-label" 
                                               for="tag-<?= $tag['name'] ?>" 
                                               style="color: <?= $tag['color'] ?>; border: 1px solid <?= $tag['color'] ?>;">
                                            <?= htmlspecialchars($tag['name']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($post['attachments'])): ?>
                                <div class="form-section">
                                    <label class="form-label">Current Attachments</label>
                                    <div class="current-attachments">
                                        <?php foreach ($post['attachments'] as $index => $attachment): ?>
                                            <?php $isImage = strpos($attachment['file_type'], 'image/') === 0; ?>
                                            <div class="attachment-item" data-index="<?= $index ?>">
                                                <?php if ($isImage): ?>
                                                    <img src="<?= $attachment['file_path'] ?>" alt="Attachment">
                                                <?php else: ?>
                                                    <div class="file-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="file-name"><?= htmlspecialchars($attachment['original_name']) ?></div>
                                                <div class="remove-attachment">×</div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-section">
                                <label for="attachments" class="form-label">Add New Attachments (optional)</label>
                                <input type="file" class="form-control" id="attachments" name="files[]" multiple>
                                <div id="preview-container" class="mt-2"></div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="view_posts.php" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edit-post-form');
            const fileInput = document.getElementById('attachments');
            const previewContainer = document.getElementById('preview-container');
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            let files = [];
            let deleteAttachments = [];
            
            // Handle file input change
            fileInput.addEventListener('change', function(e) {
                const selectedFiles = Array.from(e.target.files);
                
                // Clear preview
                previewContainer.innerHTML = '';
                files = [];
                
                selectedFiles.forEach(file => {
                    // Check file size
                    if (file.size > maxFileSize) {
                        alert(`File ${file.name} is too large. Maximum size is 5MB.`);
                        return;
                    }
                    
                    files.push(file);
                    
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        previewItem.appendChild(img);
                    } else {
                        const icon = document.createElement('div');
                        icon.className = 'file-icon';
                        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/></svg>';
                        previewItem.appendChild(icon);
                    }
                    
                    const fileName = document.createElement('div');
                    fileName.className = 'file-name';
                    fileName.textContent = file.name;
                    previewItem.appendChild(fileName);
                    
                    const removeBtn = document.createElement('div');
                    removeBtn.className = 'remove-file';
                    removeBtn.textContent = '×';
                    removeBtn.addEventListener('click', function() {
                        files = files.filter(f => f !== file);
                        previewItem.remove();
                    });
                    previewItem.appendChild(removeBtn);
                    
                    previewContainer.appendChild(previewItem);
                });
            });
            
            // Handle remove attachment button click
            document.querySelectorAll('.remove-attachment').forEach(button => {
                button.addEventListener('click', function() {
                    const attachmentItem = this.closest('.attachment-item');
                    const index = parseInt(attachmentItem.getAttribute('data-index'));
                    
                    // Add to delete list
                    deleteAttachments.push(index);
                    
                    // Hide from UI
                    attachmentItem.remove();
                });
            });
            
            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Check if at least one tag is selected
                const selectedTags = document.querySelectorAll('input[name="tags[]"]:checked');
                if (selectedTags.length === 0) {
                    alert('Please select at least one tag for your post');
                    return;
                }
                
                // Create FormData object
                const formData = new FormData();
                formData.append('postId', document.getElementById('postId').value);
                formData.append('title', document.getElementById('title').value);
                formData.append('content', document.getElementById('content').value);
                
                // Add selected tags
                selectedTags.forEach(tag => {
                    formData.append('tags[]', tag.value);
                });
                
                // Add files to be deleted
                if (deleteAttachments.length > 0) {
                    deleteAttachments.forEach(index => {
                        formData.append('delete_attachments[]', index);
                    });
                }
                
                // Add new files
                files.forEach(file => {
                    formData.append('files[]', file);
                });
                
                // Submit form data
                fetch('src/controller/edit_post.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'view_posts.php';
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error occurred'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating your post');
                });
            });
        });
    </script>
</body>
</html> 