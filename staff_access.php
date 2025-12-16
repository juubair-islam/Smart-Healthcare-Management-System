<?php
session_start();
// If already logged in, redirect them to their respective dashboard
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'Admin') header('Location: admin/admin_dashboard.php');
    if ($_SESSION['role'] === 'Doctor') header('Location: doctor/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal | Smart HMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --staff-dark: #0f172a;
            --staff-navy: #1e293b;
            --accent-blue: #38bdf8;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        body {
            background: radial-gradient(circle at top right, #1e293b, #0f172a, #020617);
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
            margin: 0;
            overflow: hidden;
        }

        /* Decorative background glow */
        body::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--accent-blue);
            filter: blur(150px);
            opacity: 0.15;
            top: 10%;
            left: 10%;
            z-index: -1;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            padding: 50px 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            position: relative;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(56, 189, 248, 0.2);
        }

        .brand-logo i {
            font-size: 2rem;
            color: var(--accent-blue);
        }

        .form-label {
            color: #94a3b8;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-group {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 14px;
            border: 1px solid var(--glass-border);
            transition: 0.3s;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #64748b;
            padding-left: 18px;
        }

        .form-control, .form-select {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 14px 15px;
            box-shadow: none !important;
        }

        /* Fix for select dropdown options visibility */
        .form-select option {
            background-color: var(--staff-dark);
            color: white;
        }

        .btn-staff {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            color: #0f172a;
            font-weight: 700;
            border-radius: 14px;
            padding: 14px;
            border: none;
            margin-top: 10px;
            transition: 0.3s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .btn-staff:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(56, 189, 248, 0.4);
            background: white;
            color: #0f172a;
        }

        .alert-custom {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        .back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .back-link:hover {
            color: var(--accent-blue);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-logo">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2 class="fw-bold mb-1">Staff Portal</h2>
        <p class="small text-muted">Smart Healthcare Management System</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-custom py-2 mb-4 d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill me-2"></i> 
            <div><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        </div>
    <?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success border-0 bg-success text-white small py-2 mb-3">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>
    <form action="actions/login_user.php" method="POST">
        <div class="mb-3">
            <label class="form-label small text-uppercase fw-bold">Access Level</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-layers"></i></span>
                <select class="form-select" name="role_check" required>
                    <option value="Doctor">Medical Doctor</option>
                    <option value="Admin">System Administrator</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small text-uppercase fw-bold">Staff Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Enter ID" required autocomplete="off">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small text-uppercase fw-bold">Security Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key"></i></span>
                <input type="password" class="form-control" name="password" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-staff w-100 mb-4">
            Verify & Authorize
        </button>
        
        <div class="text-center border-top border-secondary pt-3 mt-2 opacity-75">
            <a href="index.php" class="back-link">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Patient Portal
            </a>
        </div>
    </form>
</div>

</body>
</html>