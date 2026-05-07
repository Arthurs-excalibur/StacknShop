<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords must match.";
    } else {
        // Check uniqueness
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->rowCount() > 0) {
            $error = "Email or Username already exists.";
        } else {
            // Insert
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$full_name, $email, $username, $hashed_password])) {
                $success = "Registration successful. You may now login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container flex-grow-1 d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="glass-card p-4 p-md-5" style="max-width: 550px; width: 100%;">
        <div class="text-center mb-5">
            <div class="stat-icon mx-auto mb-4" style="background: var(--gradient-glow)">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2 class="fw-800">Create Account</h2>
            <p class="text-muted">Join Stack N Shop and start exploring</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-3"></i>
                <div><?php echo htmlspecialchars($error); ?></div>
            </div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-check-circle me-3"></i>
                <div><?php echo htmlspecialchars($success); ?></div>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label"><i class="fas fa-id-card me-2"></i>Full Name</label>
                    <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-at me-2"></i>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="johndoe123" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-key me-2"></i>Password</label>
                    <input type="password" name="password" id="regPassword" class="form-control" placeholder="••••••••" onkeyup="checkStrength(this.value)" required>
                    <div class="progress mt-2" style="height: 4px; background: rgba(255,255,255,0.05);">
                        <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small id="strengthText" class="text-muted mt-1 d-block" style="font-size: 0.7rem;">Password strength</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-check-double me-2"></i>Confirm</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="termsCheck" required>
                <label class="form-check-label text-muted small" for="termsCheck">I agree to the <a href="#" class="text-primary text-decoration-none">Terms of Service</a> and <a href="#" class="text-primary text-decoration-none">Privacy Policy</a></label>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                <i class="fas fa-user-plus me-2"></i>Register Now
            </button>
            <p class="text-center text-muted mb-0">Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
        </form>
    </div>
</div>

<script>
function checkStrength(password) {
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let strength = 0;
    
    if (password.length > 5) strength += 25;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
    if (password.match(/\d/)) strength += 25;
    if (password.match(/[^a-zA-Z\d]/)) strength += 25;
    
    bar.style.width = strength + '%';
    
    if (strength <= 25) {
        bar.className = 'progress-bar bg-danger';
        text.innerHTML = 'Weak password';
    } else if (strength <= 50) {
        bar.className = 'progress-bar bg-warning';
        text.innerHTML = 'Medium password';
    } else if (strength <= 75) {
        bar.className = 'progress-bar bg-info';
        text.innerHTML = 'Strong password';
    } else {
        bar.className = 'progress-bar bg-success';
        text.innerHTML = 'Very strong password';
    }
}
</script>

<?php include 'includes/footer.php'; ?>
