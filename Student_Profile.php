<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'navbar.php'; ?>

    
    <header class="container py-5 text-center">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 style="font-size: 70px;">Hi, I'm <strong>Albert</strong></h1>
                <p>Welcome to my profile! I'm a student passionate about learning new skills, building projects, and exploring innovative ideas.</p>
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-primary me-2">LinkedIn</a>
                    <a href="#" class="btn btn-secondary">GitHub</a>
                </div>
                <p class="mt-3">Email: studentemail@example.com</p>
            </div>
            <div class="col-md-6">
                <img src="Resources/student.jpeg" alt="Student Picture" class="img-fluid rounded" style="height: 70%; width: 70%;">
            </div>
        </div>
    </header>

    <!-- Projects Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Projects</h2>
            <div class="row">
              <a  href="Projects_page.html" class="col-md-4 p-3 text-decoration-none text-dark">
                <div>
                    <div class="card p-3">
                        <img src="Resources/jp1.jpg" class="card-img-top" alt="Project Image">
                        <div class="card-body">
                            <h5 class="card-title">Project Admin Dashboard</h5>
                            <p class="card-text">A Transformer-based Spelling Error Correction Framework for Bangla and Resource Scarce Indic Languages</p>
                        </div>
                    </div>
                </div>
              </a>

              <a  href="Projects_page.html" class="col-md-4 p-3 text-decoration-none text-dark">
                <div>
                    <div class="card p-3">
                        <img src="Resources/jp1.jpg" class="card-img-top" alt="Project Image">
                        <div class="card-body">
                            <h5 class="card-title">Project Admin Dashboard</h5>
                            <p class="card-text">A Transformer-based Spelling Error Correction Framework for Bangla and Resource Scarce Indic Languages</p>
                        </div>
                    </div>
                </div>
              </a>

              <a  href="Projects_page.html" class="col-md-4 p-3 text-decoration-none text-dark">
                <div>
                    <div class="card p-3">
                        <img src="Resources/jp1.jpg" class="card-img-top" alt="Project Image">
                        <div class="card-body">
                            <h5 class="card-title">Project Admin Dashboard</h5>
                            <p class="card-text">A Transformer-based Spelling Error Correction Framework for Bangla and Resource Scarce Indic Languages</p>
                        </div>
                    </div>
                </div>
              </a>
            </div>
        </div>
    </section>

    <!-- Skills and Learning Materials Section -->
    <section class="container py-5">
        <h2 class="text-center mb-4">Skill Set & Learning Materials</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>Skills</h3>
                <ul class="list-group">
                    <li class="list-group-item">Programming Languages: Python, JavaScript</li>
                    <li class="list-group-item">Web Development: HTML, CSS, Bootstrap</li>
                    <li class="list-group-item">Version Control: Git, GitHub</li>
                    <li class="list-group-item">Data Analysis: Excel, Pandas</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Learning Materials</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#">FreeCodeCamp</a></li>
                    <li class="list-group-item"><a href="#">Khan Academy</a></li>
                    <li class="list-group-item"><a href="#">W3Schools</a></li>
                    <li class="list-group-item"><a href="#">Coursera</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="py-5 bg-dark">
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
