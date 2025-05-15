<?php
header('Content-Type: text/html');

// Get the first project ID from JSON for testing
$jsonPath = 'assets/json/uiurp.projectsV2.json';
$jsonContent = file_get_contents($jsonPath);
$projects = json_decode($jsonContent, true);
$projectId = '';

if ($projects && is_array($projects) && !empty($projects)) {
    $projectId = $projects[0]['_id']['$oid'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Project Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Debug Project Update Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="src/model/update_project.php" method="POST" id="debugForm">
                            <h5>Basic Fields</h5>
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Project ID</label>
                                <input type="text" class="form-control" id="project_id" name="project_id" required value="<?php echo htmlspecialchars($projectId); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required value="Debug Test Project">
                            </div>
                            
                            <div class="mb-3">
                                <label for="abstract" class="form-label">Abstract</label>
                                <textarea class="form-control" id="abstract" name="abstract" rows="2">This is a test abstract</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2">This is a test description</textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="field" class="form-label">Field</label>
                                        <input type="text" class="form-control" id="field" name="field" required value="Computer Science">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="institution" class="form-label">Institution</label>
                                        <input type="text" class="form-control" id="institution" name="institution" value="United International University">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="privacy" class="form-label">Privacy</label>
                                <select class="form-select" id="privacy" name="privacy" required>
                                    <option value="0">Public</option>
                                    <option value="1">Private</option>
                                    <option value="">Empty (for testing error)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="keywords" class="form-label">Keywords (JSON array)</label>
                                <input type="text" class="form-control" id="keywords" name="keywords" value='["test", "debug", "example"]'>
                            </div>
                            
                            <h5 class="mt-4">Links</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="github_url" class="form-label">GitHub URL</label>
                                        <input type="text" class="form-control" id="github_url" name="github_url" value="https://github.com/example/test">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="project_url" class="form-label">Project URL</label>
                                        <input type="text" class="form-control" id="project_url" name="project_url" value="https://example.com/project">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="paper_url" class="form-label">Paper URL</label>
                                        <input type="text" class="form-control" id="paper_url" name="paper_url" value="https://example.com/paper">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="doi" class="form-label">DOI</label>
                                        <input type="text" class="form-control" id="doi" name="doi" value="10.1000/example">
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mt-4">Team & Timeline (Simplified)</h5>
                            <div class="mb-3">
                                <label for="team_members" class="form-label">Team Members (JSON array)</label>
                                <input type="text" class="form-control" id="team_members" name="team_members" value='[{"name":"Test User","role":"Author","contribution":100}]'>
                            </div>
                            
                            <div class="mb-3">
                                <label for="timeline" class="form-label">Timeline (JSON array)</label>
                                <input type="text" class="form-control" id="timeline" name="timeline" value='[{"title":"Test Milestone","description":"Description","date":"2023-01-01","status":"Completed"}]'>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Submit Direct Update</button>
                        </form>
                        
                        <div id="result" class="mt-4 alert" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('debugForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing...';
            
            // Send the form data
            fetch('src/model/update_project.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                // Show result
                const resultDiv = document.getElementById('result');
                resultDiv.style.display = 'block';
                
                if (data.status === 'success') {
                    resultDiv.className = 'mt-4 alert alert-success';
                    resultDiv.innerHTML = '<strong>Success!</strong> ' + data.message;
                } else {
                    resultDiv.className = 'mt-4 alert alert-danger';
                    resultDiv.innerHTML = '<strong>Error:</strong> ' + data.message;
                }
            })
            .catch(error => {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                // Show error
                const resultDiv = document.getElementById('result');
                resultDiv.style.display = 'block';
                resultDiv.className = 'mt-4 alert alert-danger';
                resultDiv.innerHTML = '<strong>Error:</strong> ' + error.message;
            });
        });
    </script>
</body>
</html> 