<?php
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Test Project Edit Page</h4>
                    </div>
                    <div class="card-body">
                        <h5>Step 1: Create a test project</h5>
                        <button id="createTestProject" class="btn btn-primary mb-4">Create Test Project</button>
                        
                        <div id="result" style="display: none;" class="alert alert-success"></div>
                        
                        <div id="editLink" style="display: none;">
                            <h5>Step 2: Edit the test project</h5>
                            <a href="#" id="editProjectLink" class="btn btn-success">Edit Project</a>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5>Or: Edit an existing project</h5>
                        <div class="input-group mb-3">
                            <input type="text" id="projectIdInput" class="form-control" placeholder="Enter project ID">
                            <button class="btn btn-outline-primary" type="button" id="editExistingProject">Edit</button>
                        </div>
                        
                        <h5>Or: Use JSON collection</h5>
                        <p>You can also use a project ID from the uiurp.projectsV2.json collection:</p>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-secondary" id="editFirstProject">Edit First Project from JSON Collection</button>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5>Import from JSON</h5>
                        <p>This will import all projects from the JSON file into the database:</p>
                        <button id="importFromJson" class="btn btn-warning">Import Projects from JSON</button>
                        <div id="importResult" class="mt-3 alert alert-info" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('createTestProject').addEventListener('click', function() {
            fetch('src/model/add_test_project.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const resultDiv = document.getElementById('result');
                        resultDiv.style.display = 'block';
                        resultDiv.innerHTML = `
                            <strong>Success!</strong> Test project created.
                            <br>Project ID: ${data.projectId}
                        `;
                        
                        const editLink = document.getElementById('editLink');
                        editLink.style.display = 'block';
                        
                        const editProjectLink = document.getElementById('editProjectLink');
                        editProjectLink.href = `edit_project.php?id=${data.projectId}`;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        });
        
        // Handle manual project ID entry
        document.getElementById('editExistingProject').addEventListener('click', function() {
            const projectId = document.getElementById('projectIdInput').value.trim();
            if (projectId) {
                window.location.href = `edit_project.php?id=${projectId}`;
            } else {
                alert('Please enter a project ID');
            }
        });
        
        // Handle keyboard enter key
        document.getElementById('projectIdInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('editExistingProject').click();
            }
        });
        
        // Use first project from the JSON file
        document.getElementById('editFirstProject').addEventListener('click', function() {
            const firstProjectId = '6795338cb2fbbc6383814726'; // First project ID from the JSON collection
            window.location.href = `edit_project.php?id=${firstProjectId}`;
        });
        
        // Import projects from JSON to database
        document.getElementById('importFromJson').addEventListener('click', function() {
            const importBtn = this;
            const importResult = document.getElementById('importResult');
            
            // Disable button and show loading state
            importBtn.disabled = true;
            importBtn.innerHTML = 'Importing... Please wait';
            importResult.style.display = 'none';
            
            fetch('src/model/import_json_projects.php')
                .then(response => response.json())
                .then(data => {
                    // Re-enable button
                    importBtn.disabled = false;
                    importBtn.innerHTML = 'Import Projects from JSON';
                    
                    // Show result
                    importResult.style.display = 'block';
                    
                    if (data.success) {
                        importResult.className = 'mt-3 alert alert-success';
                        importResult.innerHTML = `
                            <strong>Success!</strong> ${data.message}
                            <br>Total projects: ${data.total}, Inserted: ${data.inserted}
                        `;
                    } else {
                        importResult.className = 'mt-3 alert alert-danger';
                        importResult.innerHTML = `<strong>Error:</strong> ${data.message}`;
                    }
                })
                .catch(error => {
                    // Re-enable button
                    importBtn.disabled = false;
                    importBtn.innerHTML = 'Import Projects from JSON';
                    
                    // Show error
                    importResult.style.display = 'block';
                    importResult.className = 'mt-3 alert alert-danger';
                    importResult.innerHTML = `<strong>Error:</strong> ${error.message}`;
                });
        });
    </script>
</body>
</html> 