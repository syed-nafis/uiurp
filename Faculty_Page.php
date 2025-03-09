<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
                .then(response => response.json())
                .then(data => {
                    const facultyList = document.getElementById('facultyList');
                    data.forEach(faculty => {
                        const interestedFields = faculty.interested_fields_of_research.map(field => `<li>${field}</li>`).join('');

                        const facultyCard = `
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <a href="Faculty_Profile.html?name=${encodeURIComponent(faculty.name)}" class="text-decoration-none text-dark">
                                        <img src="resources/imgPlaceholder.png" class="card-img-top" alt="Profile Picture">
                                        <div class="card-body">
                                            <h5 class="card-title">${faculty.name}</h5>
                                            <p class="card-text">${faculty.job_title}</p>
                                            <ul>
                                                ${interestedFields}
                                            </ul>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        `;
                        facultyList.insertAdjacentHTML('beforeend', facultyCard);
                    });
                })
                .catch(error => console.error('Error loading faculty data:', error));
        });
    </script>
</body>
</html>