<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container flex-grow-1">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="row align-items-center">
            <div class="col-lg-7 text-lg-start">
                <span class="badge badge-premium mb-3 fade-in">Powered by DummyJSON API</span>
                <h1 class="hero-title">Experience the Next Generation of <span class="text-gradient">E-commerce Dashboards</span></h1>
                <p class="lead text-secondary mb-5 pe-lg-5">
                    Stack N Shop combines high-performance PHP backend architecture with a premium, sleek interface. Manage products, users, and carts with professional-grade tools.
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="login.php" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-rocket me-2"></i>Get Started
                    </a>
                    <a href="register.php" class="btn btn-secondary btn-lg px-5">
                        <i class="fas fa-user-plus me-2"></i>Join Now
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="glass-card text-center p-4">
                    <div class="mb-4">
                        <i class="fas fa-microchip fa-4x text-gradient"></i>
                    </div>
                    <h3 class="mb-3">Robust Architecture</h3>
                    <p class="text-muted small">Built with modern security practices, prepared statements, and secure session management.</p>
                    <div class="d-flex justify-content-around mt-4">
                        <div class="text-center">
                            <h4 class="mb-0">100+</h4>
                            <small class="text-muted">Products</small>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">50+</h4>
                            <small class="text-muted">Endpoints</small>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">99.9%</h4>
                            <small class="text-muted">Uptime</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card">
                <div class="stat-icon mb-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Secure Auth</h4>
                <p class="text-muted">Advanced password hashing and protected session management for ultimate security.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card">
                <div class="stat-icon mb-4" style="background: linear-gradient(135deg, var(--secondary), var(--secondary-light))">
                    <i class="fas fa-bolt"></i>
                </div>
                <h4>API Driven</h4>
                <p class="text-muted">Real-time data synchronization with the powerful DummyJSON API infrastructure.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card">
                <div class="stat-icon mb-4" style="background: var(--gradient-glow)">
                    <i class="fas fa-magic"></i>
                </div>
                <h4>Premium UI</h4>
                <p class="text-muted">A beautiful, responsive dark theme designed for modern professional workflows.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
