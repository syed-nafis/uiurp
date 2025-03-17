<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Faculty List -->
    <div class="container mt-5">
        <div class="row" id="facultyList">
            <!-- Faculty members will be dynamically inserted here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    fetch('load_faculty.php')
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            const facultyList = document.getElementById('facultyList');
            console.log("Data loaded:", data);

            if (data.length === 0) {
                facultyList.innerHTML = '<p class="text-center">No faculty members found.</p>';
                return;
            }

            data.forEach(faculty => {
                // Use faculty's Google Drive image or a default placeholder
                const profileImage = faculty.profile_image ? faculty.profile_image : 'resources/imgPlaceholder.png';

                const facultyCard = `
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <a href="Faculty_Profile.php?id=${faculty._id}" class="text-decoration-none text-dark">
                                <img src="${profileImage}" class="card-img-top" alt="${faculty.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${faculty.name}</h5>
                                    <p class="card-text">${faculty.bio}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                `;
                facultyList.insertAdjacentHTML('beforeend', facultyCard);
            });
        })
        .catch(error => {
            console.error('Error loading faculty data:', error);
            document.getElementById('facultyList').innerHTML = `
                <p class="text-danger">Failed to load faculty data. Error: ${error.message}</p>
            `;
        });
    });
    </script>
</body>
</html>