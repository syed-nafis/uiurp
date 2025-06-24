<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

if (!isset($_GET['id'])) {
    header("Location: faculty_page.php");
    exit();
}

try {
    $faculty_id = new MongoDB\BSON\ObjectId($_GET['id']);
    $faculty = $collection->findOne(['_id' => $faculty_id]);

    if (!$faculty || $_SESSION['user_id'] !== (string)$faculty['_id']) {
        die("Unauthorized access.");
    }
} catch (Exception $e) {
    die("Invalid ID or error fetching data.");
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Edit Faculty Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/edit_faculty_modern.css">
</head>
<body>
<?php include 'src/includes/navbar.php'; ?>

<div class="container my-5">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Edit Profile</h2>

        <form method="POST" action="update_faculty.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $faculty['_id']; ?>">

            <!-- Name -->
            <div class="mb-4">
                <h5 class="mb-3">Name</h5>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($faculty['name'] ?? ''); ?>" required>
            </div>

            <!-- Bio -->
            <div class="mb-4">
                <h5 class="mb-3">Bio</h5>
                <textarea name="bio" class="form-control" rows="4" required><?= htmlspecialchars($faculty['bio'] ?? ''); ?></textarea>
            </div>

            <!-- Profile Image -->
             <div class="mb-4">
                <h5 class="mb-3">Profile Image</h5>
                <input type="file" name="profile_image" class="form-control">
                <?php if (!empty($faculty['profile_image'])): ?>
                    <div class="mt-2">
                        <strong>Current Image:</strong><br>
                        <img src="<?= htmlspecialchars($faculty['profile_image']); ?>" alt="Profile Image" width="150" class="mt-2">
                    </div>
                <?php endif; ?>
            </div>

            <!-- Interested Fields -->
            <div class="mb-4">
                <h5 class="mb-3">Interested Fields (comma-separated)</h5>
                <input type="text" name="interested_fields" class="form-control"
                       value="<?= isset($faculty['interested_fields_of_research']) ? htmlspecialchars(implode(', ', (array)$faculty['interested_fields_of_research'])) : ''; ?>">
            </div>

            <!-- Projects -->
            <div class="mb-4">
                <h5 class="mb-3">Projects</h5>
                <?php $projects = isset($faculty['projects']) ? (array)$faculty['projects'] : []; ?>

                <div id="projectsContainer">
                    <?php if (!empty($projects)): ?>
                        <?php foreach ($projects as $index => $project): ?>
                            <?php if ($project instanceof \MongoDB\Model\BSONDocument) $project = (array)$project; ?>
                            <div class="mb-3 p-3 project-block">
                                <label class="form-label">Title:</label>
                                <input type="text" name="projects[<?= $index; ?>][title]" class="form-control mb-2"
                                    value="<?= htmlspecialchars($project['title'] ?? ''); ?>">

                                <label class="form-label">Description:</label>
                                <textarea name="projects[<?= $index; ?>][description]" class="form-control mb-2"><?= htmlspecialchars($project['description'] ?? ''); ?></textarea>

                                <label class="form-label">Link:</label>
                                <input type="url" name="projects[<?= $index; ?>][link]" class="form-control mb-2"
                                    value="<?= htmlspecialchars($project['link'] ?? ''); ?>">

                                <!-- Remove Project Button -->
                                <button type="button" class="btn btn-danger btn-sm remove-project-btn">Remove Project</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No projects available.</p>
                    <?php endif; ?>
                </div>

                <!-- Add Project Button -->
                <button type="button" class="btn btn-outline-primary mt-3" id="addProjectBtn">
                    <i class="bi bi-plus-lg"></i> Add Project
                </button>
            </div>



            <!-- Prerequisites -->
            <div class="mb-4"> 
                <h5 class="mb-3">Prerequisites (comma-separated)</h5>
                <input type="text" name="prerequisites" class="form-control"
                       value="<?= isset($faculty['prerequisites']) && $faculty['prerequisites'] instanceof \MongoDB\Model\BSONArray
                                   ? htmlspecialchars(implode(', ', (array) $faculty['prerequisites']))
                                   : ''; ?>">
            </div>

            <!-- Resources -->
            <div class="mb-4">
                <h5 class="mb-3">Resources to Learn Prerequisites</h5>

                <?php
                $resources = $faculty['resources_to_learn_prerequisites'] ?? [];
                if ($resources instanceof \MongoDB\Model\BSONArray) {
                    $resources = (array)$resources;
                }
                ?>

                <div id="resourcesContainer">
                    <?php if (!empty($resources) && is_array($resources)): ?>
                        <?php foreach ($resources as $index => $res): ?>
                            <?php if ($res instanceof \MongoDB\Model\BSONDocument) $res = (array)$res; ?>
                            <div class="mb-3 p-3 resource-block">
                                <label class="form-label">Topic:</label>
                                <input type="text" name="resources[<?= $index; ?>][topic]" class="form-control mb-2"
                                    value="<?= htmlspecialchars($res['topic'] ?? ''); ?>">

                                <label class="form-label">Link:</label>
                                <input type="text" name="resources[<?= $index; ?>][link]" class="form-control mb-2"
                                    value="<?= htmlspecialchars($res['link'] ?? ''); ?>">

                                <!-- Remove Resource Button -->
                                <button type="button" class="btn btn-danger btn-sm remove-resource-btn">Remove Resource</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No resources listed.</p>
                    <?php endif; ?>
                </div>

                <!-- Add Resource Button -->
                <button type="button" class="btn btn-outline-primary mt-3" id="addResourceBtn">
                    <i class="bi bi-plus-lg"></i> Add Resource
                </button>
            </div>


            <!-- Submit Button -->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="bi bi-check-lg"></i> Update Information
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    // Pass PHP value to JS
    window.initialResourceCount = <?= count($resources); ?>;
    
    // Check for user's theme preference
    document.addEventListener('DOMContentLoaded', function() {
        // Check for saved theme preference or default to 'dark'
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        // Listen for theme changes from navbar (if it has theme toggle functionality)
        window.addEventListener('themeChanged', function(e) {
            const newTheme = e.detail.theme;
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    });
</script>
<script src="assets/scripts/resource_update.js"></script>
<script src="assets/scripts/faculty_project.js"></script>


<?php include 'src/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
