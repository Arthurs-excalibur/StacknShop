<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
require_once 'config/database.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = trim($_POST['login_id']); // Can be email or username
    $password = $_POST['password'];

    if (empty($login_id) || empty($password)) {
        $error = "Please enter username/email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$login_id, $login_id]);
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username/email or password.";
            }
        } else {
            $error = "Invalid username/email or password.";
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container flex-grow-1 d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="glass-card p-4 p-md-5" style="max-width: 480px; width: 100%;">
        <div class="text-center mb-5">
            <div class="stat-icon mx-auto mb-4">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="fw-800">Welcome Back</h2>
            <p class="text-muted">Sign in to your Stack N Shop account</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-3"></i>
                <div><?php echo htmlspecialchars($error); ?></div>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-4">
                <label class="form-label"><i class="fas fa-user-circle me-2"></i>Username or Email</label>
                <div class="input-group">
                    <input type="text" name="login_id" class="form-control" placeholder="Enter your email or username" required>
                </div>
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label class="form-label"><i class="fas fa-key me-2"></i>Password</label>
                    <a href="#" class="small text-primary text-decoration-none">Forgot password?</a>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required>
                    <button class="btn btn-outline-secondary border-start-0 text-muted" type="button" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label text-muted small" for="rememberMe">Remember me for 30 days</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
            <p class="text-center text-muted mb-0">Don't have an account? <a href="register.php" class="text-primary fw-bold text-decoration-none">Create account</a></p>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('passwordInput');
    const passwordIcon = document.getElementById('passwordIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?php include 'includes/footer.php'; ?>
