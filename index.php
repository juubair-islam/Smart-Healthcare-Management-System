<?php
session_start();
require 'config/db.php'; 

$doctors = [];
$error_message = null;

try {
    // Fetching doctors for the "Meet our Specialists" section
    $stmt_doctors = $pdo->query("SELECT d.doctor_id, d.full_name, d.expertise, d.image_url FROM Doctors d");
    $doctors = $stmt_doctors->fetchAll();
} catch (PDOException $e) {
    $error_message = "Database Error: Could not load listings.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart HMS | Intelligent Healthcare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary: #0077b6;
            --accent: #90e0ef;
            --dark: #1e293b;
            --bg: #f8fafc;
        }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); color: var(--dark); }
        
        /* Navbar */
        .navbar { background: white; border-bottom: 1px solid #e2e8f0; padding: 15px 0; }
        .navbar-brand { font-weight: 800; color: var(--primary) !important; letter-spacing: -0.5px; }
        
        /* Hero Section */
        .hero-section { padding: 80px 0; background: white; border-bottom: 1px solid #f1f5f9; }
        .hero-title { font-weight: 800; font-size: 3rem; color: var(--dark); line-height: 1.2; }
        
        /* Doctor Cards */
        .doctor-card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .doctor-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .doctor-img { height: 260px; object-fit: cover; width: 100%; background: var(--accent); }
        
        /* Features */
        .feature-box {
            padding: 30px;
            background: white;
            border-radius: 20px;
            height: 100%;
            border: 1px solid #f1f5f9;
            transition: 0.3s;
        }
        .feature-box:hover { border-color: var(--primary); }
        .feature-icon {
            width: 60px; height: 60px; background: #eff6ff;
            color: var(--primary); border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 20px;
        }

        .btn-primary { background: var(--primary); border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; }
        .btn-outline-primary { border-radius: 12px; padding: 12px 25px; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php">
            <i class="bi bi-heart-pulse-fill me-2"></i>Smart HMS
        </a>
        <div class="d-flex gap-2">
            <a href="patient_access.php" class="btn btn-outline-primary">
                Patient Portal
            </a>
            <a href="staff_access.php" class="btn btn-primary">
                <i class="bi bi-person-badge me-2"></i>Staff Portal
            </a>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <h1 class="hero-title mb-4">Smart Care for a <span class="text-primary">Healthier</span> Tomorrow.</h1>
                <p class="lead text-muted mb-5">Experience AI-driven diagnostics, seamless appointment booking, and secure medical records in one unified ecosystem.</p>
                <div class="d-flex gap-3">
                    <a href="#doctors" class="btn btn-primary btn-lg px-4">Find a Doctor</a>
                    <a href="#features" class="btn btn-light btn-lg px-4 border">Learn More</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div id="hmsCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Hospital">
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Technology">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="features">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">INTELLIGENT SYSTEM</span>
            <h2 class="fw-bold fs-1">Next-Gen Healthcare Features</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-robot"></i></div>
                    <h4 class="fw-bold">AI Disease Prediction</h4>
                    <p class="text-muted">Advanced ML models analyze symptoms to provide instant health risk assessments and confidence scores.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h4 class="fw-bold">Secure Health Records</h4>
                    <p class="text-muted">Your medical history, encrypted and centralized. Accessible only to you and your assigned doctors.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-bell"></i></div>
                    <h4 class="fw-bold">Preventive Alerts</h4>
                    <p class="text-muted">Smart reminders for annual checkups and screenings based on your age and health profile.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white" id="doctors">
    <div class="container py-5">
        <h2 class="fw-bold mb-5"><i class="bi bi-star-fill text-warning me-2"></i>Our Specialists</h2>
        
        <?php if ($error_message): ?>
            <div class="alert alert-warning"><?= $error_message ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <?php foreach ($doctors as $doctor): ?>
                <div class="col-md-3">
                    <div class="doctor-card">
                        <img src="<?= htmlspecialchars($doctor['image_url'] ?: 'https://via.placeholder.com/400') ?>" class="doctor-img" alt="Doctor">
                        <div class="p-4 text-center">
                            <h5 class="fw-bold mb-1"><?= htmlspecialchars($doctor['full_name']) ?></h5>
                            <p class="text-primary small fw-bold mb-3"><?= htmlspecialchars($doctor['expertise']) ?></p>
                            <a href="patient_access.php" class="btn btn-outline-primary btn-sm w-100 rounded-pill">Book Appointment</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<footer class="py-5 bg-dark text-white-50 mt-5 text-center">
    <div class="container">
        <p class="mb-0 small">&copy; <?= date('Y'); ?> Smart Healthcare Management System. Built for excellence.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>