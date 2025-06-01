<?php
// Start session and error handling
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include autoloader for MongoDB
require __DIR__ . '/vendor/autoload.php';

// MongoDB connection function
function connectToMongoDB() {
    try {
        $mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
        return $mongoClient->uiurp;
    } catch (Exception $e) {
        error_log("MongoDB connection failed:  " . $e->getMessage());
        return null;
    }
}

// Fetch events from MongoDB
function getEventsFromMongoDB() {
    $db = connectToMongoDB();
    if (!$db) {
        return [];
    }
    
    try {
        $collection = $db->events;
        $cursor = $collection->find([], ['sort' => ['eventDate' => 1]]);
        $events = [];
        
        foreach ($cursor as $event) {
            // Convert MongoDB document to array properly
            $eventArray = json_decode(json_encode($event), true);
            
            // Helper function to convert MongoDB date
            $convertDate = function($dateValue) {
                if (is_array($dateValue) && isset($dateValue['$date'])) {
                    if (is_array($dateValue['$date']) && isset($dateValue['$date']['$numberLong'])) {
                        return date('Y-m-d\TH:i:s\Z', intval($dateValue['$date']['$numberLong']) / 1000);
                    } elseif (is_numeric($dateValue['$date'])) {
                        return date('Y-m-d\TH:i:s\Z', $dateValue['$date'] / 1000);
                    }
                }
                return $dateValue; // Return as-is if not a MongoDB date
            };
            
            // Convert MongoDB UTCDateTime objects to readable dates
            if (isset($eventArray['eventDate'])) {
                $eventArray['eventDate'] = $convertDate($eventArray['eventDate']);
            }
            if (isset($eventArray['createdAt'])) {
                $eventArray['createdAt'] = $convertDate($eventArray['createdAt']);
            }
            if (isset($eventArray['updatedAt'])) {
                $eventArray['updatedAt'] = $convertDate($eventArray['updatedAt']);
            }
            if (isset($eventArray['registration']['deadline'])) {
                $eventArray['registration']['deadline'] = $convertDate($eventArray['registration']['deadline']);
            }
            
            $events[] = $eventArray;
        }
        
        return $events;
    } catch (Exception $e) {
        error_log("Error fetching events: " . $e->getMessage());
        return [];
    }
}

// Get events data
$events = getEventsFromMongoDB();

// Handle filtering
$filteredEvents = $events;
$searchTerm = $_GET['search'] ?? '';
$eventType = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';

if ($searchTerm || $eventType || $status) {
    $filteredEvents = array_filter($events, function($event) use ($searchTerm, $eventType, $status) {
        $matchesSearch = !$searchTerm || 
            stripos($event['title'], $searchTerm) !== false || 
            stripos($event['description'], $searchTerm) !== false;
        
        $matchesType = !$eventType || $event['eventType'] === $eventType;
        $matchesStatus = !$status || $event['status'] === $status;
        
        return $matchesSearch && $matchesType && $matchesStatus;
    });
}

// Get unique event types and statuses for filters
$eventTypes = array_unique(array_column($events, 'eventType'));
$statuses = array_unique(array_column($events, 'status'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Events - UIU Research Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4c9af1 0%, #7209b7 100%);
            --secondary-gradient: linear-gradient(135deg, #f72585 0%, #4cc9f0 100%);
            --dark-bg: #0a1121;
            --dark-surface: #1e293b;
            --dark-card: rgba(30, 41, 59, 0.8);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --accent-pink: #f72585;
            --accent-blue: #4cc9f0;
            --accent-purple: #7209b7;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .main-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a1121 0%, #1e293b 100%);
            position: relative;
        }

        /* Background Elements */
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(114, 9, 183, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(247, 37, 133, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(76, 201, 240, 0.1) 0%, transparent 50%);
            z-index: -2;
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: var(--accent-blue);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .particle:nth-child(1) { width: 2px; height: 2px; top: 20%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 3px; height: 3px; top: 60%; left: 70%; animation-delay: 5s; }
        .particle:nth-child(3) { width: 1px; height: 1px; top: 80%; left: 20%; animation-delay: 10s; }
        .particle:nth-child(4) { width: 4px; height: 4px; top: 40%; left: 90%; animation-delay: 15s; }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }

        /* Header Section */
        .page-header {
            padding: 6rem 0 4rem;
            text-align: center;
            position: relative;
            margin-top: 75px;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        /* Filter Section */
        .filter-section {
            background: var(--dark-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .filter-row {
            gap: 1rem;
        }

        .filter-input, .filter-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(76, 201, 240, 0.25);
            background: rgba(255, 255, 255, 0.1);
        }

        .filter-input::placeholder {
            color: var(--text-muted);
        }

        .filter-select option {
            background: var(--dark-surface);
            color: var(--text-primary);
        }

        /* Event Cards */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .event-card {
            background: var(--dark-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(76, 201, 240, 0.2);
            border-color: var(--accent-blue);
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            flex: 1;
        }

        .event-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-scheduled {
            background: rgba(76, 201, 240, 0.2);
            color: var(--accent-blue);
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-cancelled {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .event-type {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            background: var(--secondary-gradient);
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
        }

        .event-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .event-details {
            display: grid;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .event-detail {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .event-detail i {
            margin-right: 0.75rem;
            color: var(--accent-blue);
            font-size: 1rem;
        }

        .event-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76, 201, 240, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--accent-blue);
            color: var(--accent-blue);
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: var(--accent-blue);
            color: white;
            text-decoration: none;
        }

        /* Speakers Section */
        .speakers-section {
            margin: 1rem 0;
        }

        .speakers-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .speaker-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .speaker-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .speaker-affiliation {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .speaker-topic {
            color: var(--accent-blue);
            font-size: 0.8rem;
            font-style: italic;
        }

        /* No Events Message */
        .no-events {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .no-events i {
            font-size: 4rem;
            color: var(--accent-blue);
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .filter-row {
                flex-direction: column;
            }
            
            .event-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .event-actions {
                flex-direction: column;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="bg-gradient"></div>
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="main-container">
        <?php
        // Include navbar
        $navbar_path = 'src/includes/navbar.php';
        if (file_exists($navbar_path)) {
            include $navbar_path;
        } else {
            // Fallback navbar
            echo '<nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="index.php">UIU Research Portal</a>
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="index.php">Home</a>
                        <a class="nav-link" href="Research_page.php">Projects</a>
                        <a class="nav-link" href="Faculty_Page.php">Faculty</a>
                        <a class="nav-link active" href="events.php">Events</a>
                        <a class="nav-link" href="forum_index.php">Forum</a>
                    </div>
                </div>
            </nav>';
        }
        ?>

        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <h1 class="page-title" data-aos="fade-up">University Events</h1>
                <p class="page-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Discover upcoming conferences, seminars, workshops, and academic events at UIU
                </p>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="container">
            <div class="filter-section" data-aos="fade-up" data-aos-delay="200">
                <form method="GET" action="">
                    <div class="row filter-row">
                        <div class="col-md-4">
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control filter-input" 
                                placeholder="Search events..." 
                                value="<?= htmlspecialchars($searchTerm) ?>"
                            >
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-control filter-select">
                                <option value="">All Types</option>
                                <?php foreach ($eventTypes as $type): ?>
                                    <option value="<?= htmlspecialchars($type) ?>" <?= $eventType === $type ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($type) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control filter-select">
                                <option value="">All Status</option>
                                <?php foreach ($statuses as $statusOption): ?>
                                    <option value="<?= htmlspecialchars($statusOption) ?>" <?= $status === $statusOption ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($statusOption) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Events Grid -->
        <section class="container">
            <?php if (empty($filteredEvents)): ?>
                <div class="no-events" data-aos="fade-up">
                    <i class="bi bi-calendar-x"></i>
                    <h3>No Events Found</h3>
                    <p>No events match your current filters. Try adjusting your search criteria.</p>
                </div>
            <?php else: ?>
                <div class="events-grid">
                    <?php foreach ($filteredEvents as $index => $event): 
                        $eventDate = new DateTime($event['eventDate']);
                        $registrationDeadline = !empty($event['registration']['deadline']) 
                            ? new DateTime($event['registration']['deadline']) 
                            : null;
                    ?>
                        <div class="event-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                            <div class="event-header">
                                <div>
                                    <h3 class="event-title"><?= htmlspecialchars($event['title']) ?></h3>
                                    <span class="event-type"><?= htmlspecialchars($event['eventType']) ?></span>
                                </div>
                                <span class="event-status status-<?= strtolower($event['status']) ?>">
                                    <?= htmlspecialchars($event['status']) ?>
                                </span>
                            </div>

                            <p class="event-description">
                                <?= htmlspecialchars($event['description']) ?>
                            </p>

                            <div class="event-details">
                                <div class="event-detail">
                                    <i class="bi bi-calendar-event"></i>
                                    <span><?= $eventDate->format('F j, Y') ?></span>
                                </div>
                                <div class="event-detail">
                                    <i class="bi bi-clock"></i>
                                    <span><?= htmlspecialchars($event['startTime']) ?> - <?= htmlspecialchars($event['endTime']) ?> (<?= htmlspecialchars($event['timeZone']) ?>)</span>
                                </div>
                                <div class="event-detail">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>
                                        <?php if ($event['location']['type'] === 'Virtual'): ?>
                                            Virtual - <?= htmlspecialchars($event['location']['virtualPlatform']) ?>
                                        <?php elseif ($event['location']['type'] === 'Physical'): ?>
                                            <?= htmlspecialchars($event['location']['room']) ?>
                                        <?php else: ?>
                                            Hybrid - <?= htmlspecialchars($event['location']['room']) ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="event-detail">
                                    <i class="bi bi-building"></i>
                                    <span><?= htmlspecialchars($event['organizer']) ?></span>
                                </div>
                            </div>

                            <?php if (!empty($event['speakers'])): ?>
                                <div class="speakers-section">
                                    <div class="speakers-title">Featured Speakers:</div>
                                    <?php foreach ($event['speakers'] as $speaker): ?>
                                        <div class="speaker-item">
                                            <div class="speaker-name"><?= htmlspecialchars($speaker['name']) ?></div>
                                            <div class="speaker-affiliation"><?= htmlspecialchars($speaker['affiliation']) ?></div>
                                            <?php if (!empty($speaker['topic'])): ?>
                                                <div class="speaker-topic"><?= htmlspecialchars($speaker['topic']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="event-actions">
                                <?php if ($event['registration']['required'] && !empty($event['registration']['link'])): ?>
                                    <a href="<?= htmlspecialchars($event['registration']['link']) ?>" 
                                       target="_blank" 
                                       class="btn btn-primary">
                                        <i class="bi bi-calendar-plus me-2"></i>Register
                                    </a>
                                    <?php if ($registrationDeadline): ?>
                                        <small class="text-muted">
                                            Deadline: <?= $registrationDeadline->format('M j, Y') ?>
                                        </small>
                                    <?php endif; ?>
                                <?php elseif ($event['location']['type'] === 'Virtual' && !empty($event['location']['joinLink'])): ?>
                                    <a href="<?= htmlspecialchars($event['location']['joinLink']) ?>" 
                                       target="_blank" 
                                       class="btn btn-primary">
                                        <i class="bi bi-camera-video me-2"></i>Join Event
                                    </a>
                                <?php endif; ?>
                                
                                <a href="#" class="btn-outline">
                                    <i class="bi bi-info-circle me-2"></i>Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Auto-submit form on filter change
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
</body>
</html> 