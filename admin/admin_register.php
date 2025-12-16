<?php
session_start();
require '../config/db.php';

try {
    // Check if an Admin already exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM Users WHERE role = 'Admin'");
    $adminExists = $stmt->fetchColumn();
    
    // CHANGE IS HERE: 
    // We only kick the user out if an Admin exists AND they aren't looking at a success message.
    if ($adminExists > 0 && !isset($_SESSION['success'])) {
        header('Location: ../index.php');
        exit;
    }
} catch (PDOException $e) {
    $adminExists = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initial Setup | Smart HMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --accent-blue: #38bdf8;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background: radial-gradient(circle at top right, #1e293b, #0f172a, #020617);
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
            padding: 20px;
        }

        .setup-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .brand-icon {
            width: 60px; height: 60px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(56, 189, 248, 0.2);
            color: var(--accent-blue);
            font-size: 1.8rem;
        }

        .form-control {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid var(--glass-border) !important;
            color: white !important;
            padding: 12px 15px;
            border-radius: 12px;
        }

        .form-control:focus {
            border-color: var(--accent-blue) !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1) !important;
        }

        .btn-setup {
            background: var(--accent-blue);
            color: #0f172a;
            font-weight: 700;
            border-radius: 12px;
            padding: 14px;
            border: none;
            transition: 0.3s;
        }

        .btn-setup:hover {
            background: white;
            transform: translateY(-2px);
        }

        .warning-box {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border-radius: 12px;
            padding: 15px;
            font-size: 0.85rem;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="setup-card">
    <div class="text-center">
        <div class="brand-icon"><i class="bi bi-gear-wide-connected"></i></div>
        <h3 class="fw-bold">Initial Admin Setup</h3>
        <p class="text-muted small mb-4">Create the master administrator account</p>
    </div>

    <div class="warning-box">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Security Warning:</strong> This setup will lock automatically once the first administrator is created.
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger border-0 bg-danger text-white py-2 small">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success border-0 bg-success text-white py-2 small">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <br><a href="../staff_access.php" class="text-white fw-bold">Login Now &rarr;</a>
        </div>
    <?php endif; ?>

    <form action="../actions/register_admin.php" method="POST">
        <div class="mb-3">
            <label class="form-label small text-uppercase fw-bold opacity-75">Full Name</label>
            <input type="text" class="form-control" name="name" placeholder="e.g. System Admin" required>
        </div>
        <div class="mb-3">
            <label class="form-label small text-uppercase fw-bold opacity-75">Admin Username</label>
            <input type="text" class="form-control" name="username" placeholder="Choose a login ID" required>
        </div>
        <div class="mb-4">
            <label class="form-label small text-uppercase fw-bold opacity-75">Master Password</label>
            <input type="password" class="form-control" name="password" placeholder="••••••••" required>
        </div>
        
        <button type="submit" class="btn btn-setup w-100">
            Initialize System <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </form>
</div>

</body>
</html>