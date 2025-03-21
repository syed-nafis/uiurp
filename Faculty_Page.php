<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style/style.css">
    <link rel="stylesheet" href="Style/faculty_page.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="hero-section">
    <img src="Resources/faculty_hero.jpg" alt="Faculty Image" class="hero-image">
    <div class="overlay">
        <h1>Our Faculty</h1>
        <p>At the Head of the Class<br>UIU faculty are renowned leaders in their fields, extraordinary teachers, and dedicated mentors.</p>
    </div>
    </div>

    <!-- Faculty List -->
    <div class="container mt-5">
        <div class="row" id="facultyList">
            <!-- Faculty members will be dynamically inserted here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    fetch('load_faculty.php')
        .then(response => response.json())
        .then(data => {
            const facultyList = document.getElementById('facultyList');
            if (data.length === 0) {
                facultyList.innerHTML = '<p class="text-center">No faculty members found.</p>';
                return;
            }

            data.forEach(faculty => {
                const profileImage = faculty.profile_image ? faculty.profile_image : 'resources/imgPlaceholder.png';

                const facultyCard = `
                    <div class="col-md-4 d-flex">
                        <div class="faculty-card">
                            <img src="${profileImage}" alt="${faculty.name}" class="faculty-img">
                            <div class="faculty-info">
                                <h4>${faculty.name}</h4>
                                <p>${faculty.bio}</p>
                                <a href="Faculty_Profile.php?id=${faculty._id}" class="learn-more">LEARN MORE</a>
                            </div>
                        </div>
                    </div>
                `;
                facultyList.insertAdjacentHTML('beforeend', facultyCard);
            });
        })
        .catch(error => {
            document.getElementById('facultyList').innerHTML = `<p class="text-danger">Failed to load faculty data.</p>`;
            console.error('Error loading faculty data:', error);
        });
});

    </script>
</body>
</html>