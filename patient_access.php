<?php
session_start();
// Include the database connection for fetching flash messages if any
require 'config/db.php'; 

// Function to calculate age from DOB (used for display, not database storage)
function calculateAge($dob) {
    if (empty($dob)) return 0;
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    return $age;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Access - Register & Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-color: #0077b6;
            --background-color: #f8f9fa;
        }
        body {
            background-color: var(--background-color);
            padding-top: 50px;
        }
        .access-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 119, 182, 0.1);
        }
        .nav-tabs .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        .nav-tabs .nav-link {
            color: var(--primary-color);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-4">
        <a href="index.php" class="btn btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to Home</a>
        <h1 class="text-primary"><i class="bi bi-person-circle me-2"></i> Patient Access Portal</h1>
        <p class="text-muted">Login with your **Contact Number** or Register a New Account.</p>
    </div>

    <?php 
    if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show access-container mb-4" role="alert">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show access-container mb-4" role="alert">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="access-container">
        <ul class="nav nav-tabs justify-content-center mb-4" id="patientTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Patient Login
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                    <i class="bi bi-person-plus-fill me-2"></i> New Patient Registration
                </button>
            </li>
        </ul>

        <div class="tab-content" id="patientTabContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <form action="actions/login_user.php" method="POST" class="p-3">
                    <input type="hidden" name="role_check" value="Patient">
                    <div class="mb-4">
                        <label for="login_contact" class="form-label">Contact Number (Used as Username)</label>
                        <input type="tel" class="form-control form-control-lg" id="login_contact" name="username" placeholder="Enter your contact number" required>
                    </div>
                    <div class="mb-4">
                        <label for="login_password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" id="login_password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Secure Login</button>
                </form>
            </div>

            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <form action="actions/register_user.php" method="POST" class="p-3">
                    <input type="hidden" name="role" value="Patient">
                    <h5 class="text-primary mb-3">Personal Details</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="reg_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="reg_name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="reg_dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="reg_dob" name="date_of_birth" required onchange="calculatePatientAge()">
                        </div>
                        <div class="col-md-6">
                            <label for="reg_age" class="form-label">Age (Calculated)</label>
                            <input type="text" class="form-control" id="reg_age" readonly disabled placeholder="Auto-calculated">
                        </div>
                        <div class="col-md-6">
                            <label for="reg_gender" class="form-label">Gender</label>
                            <select class="form-select" id="reg_gender" name="gender" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <h5 class="text-primary mt-4 mb-3">Contact & Security</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="reg_contact" class="form-label">Contact Number (Your Login ID)</label>
                            <input type="tel" class="form-control" id="reg_contact" name="contact_phone" required>
                        </div>
                        <div class="col-md-6">
                            <label for="reg_email" class="form-label">Email Address (Optional)</label>
                            <input type="email" class="form-control" id="reg_email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="reg_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="reg_password" name="password" required>
                        </div>
                    </div>
                    
                    <h5 class="text-danger mt-4 mb-3"><i class="bi bi-exclamation-triangle-fill me-1"></i> Emergency Contact</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="ec_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="ec_name" name="ec_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ec_number" class="form-label">Number</label>
                            <input type="tel" class="form-control" id="ec_number" name="ec_number" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ec_relation" class="form-label">Relation</label>
                            <input type="text" class="form-control" id="ec_relation" name="ec_relation" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 btn-lg">Register & Complete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to calculate Age from Date of Birth
    function calculatePatientAge() {
        const dobInput = document.getElementById('reg_dob').value;
        const ageInput = document.getElementById('reg_age');
        
        if (dobInput) {
            const birthDate = new Date(dobInput);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            ageInput.value = age;
        } else {
            ageInput.value = '';
        }
    }
</script>

</body>
</html>