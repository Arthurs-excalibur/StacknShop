<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container mt-5 mb-5 flex-grow-1">
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="display-5 fw-800 text-theme mb-2">Welcome back, <span class="text-gradient"><?php echo htmlspecialchars($_SESSION['full_name']); ?></span>!</h1>
            <p class="text-secondary lead">Your central command for managing Stack N Shop resources.</p>
        </div>
        <div class="col-lg-4 text-lg-end d-flex align-items-center justify-content-lg-end mt-3 mt-lg-0">
            <div class="glass-card py-2 px-4 d-inline-flex align-items-center">
                <div class="stat-icon sm me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="text-start">
                    <small class="text-muted d-block">Today's Date</small>
                    <span class="fw-bold small"><?php echo date('M d, Y'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Products Card -->
        <div class="col-md-6 col-lg-3">
            <div class="glass-card h-100 p-4 d-flex flex-column">
                <div class="stat-icon mb-4">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="mb-2">Products</h4>
                <p class="text-muted mb-4 flex-grow-1 small">Manage and browse over 100 dynamic items from the global catalog.</p>
                <a href="products.php" class="btn btn-primary w-100 mt-auto">
                    Manage Catalog <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-md-6 col-lg-3">
            <div class="glass-card h-100 p-4 d-flex flex-column">
                <div class="stat-icon mb-4" style="background: linear-gradient(135deg, var(--secondary), var(--secondary-light))">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h4 class="mb-2">Customers</h4>
                <p class="text-muted mb-4 flex-grow-1 small">Review user profiles, credentials, and shopping behaviors.</p>
                <a href="users.php" class="btn btn-primary w-100 mt-auto">
                    View Customers <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Posts Card -->
        <div class="col-md-6 col-lg-3">
            <div class="glass-card h-100 p-4 d-flex flex-column">
                <div class="stat-icon mb-4" style="background: var(--gradient-glow)">
                    <i class="fas fa-edit"></i>
                </div>
                <h4 class="mb-2">Inventory Posts</h4>
                <p class="text-muted mb-4 flex-grow-1 small">Engage with community updates and product announcements.</p>
                <a href="posts.php" class="btn btn-primary w-100 mt-auto">
                    Read Posts <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Carts/Profile Card -->
        <div class="col-md-6 col-lg-3">
            <div class="glass-card h-100 p-4 d-flex flex-column">
                <div class="stat-icon mb-4" style="background: rgba(239, 68, 68, 0.8)">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h4 class="mb-2">Order Tracking</h4>
                <p class="text-muted mb-4 flex-grow-1 small">Monitor active shopping carts and transaction histories.</p>
                <a href="users.php" class="btn btn-secondary w-100 mt-auto">
                    Search Carts <i class="fas fa-search ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="row mt-5 g-4">
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1 text-theme">Sales Overview</h5>
                        <p class="text-muted small mb-0">Monthly transaction volume across all categories</p>
                    </div>
                    <span class="badge bg-glass text-success">+12.5%</span>
                </div>
                <div id="salesChart" style="min-height: 300px;"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card p-4">
                <h5 class="mb-4 text-theme">Distribution</h5>
                <div id="distChart" style="min-height: 300px;"></div>
                <div class="mt-4">
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">System Health</span>
                        <span class="text-success">99.9%</span>
                    </div>
                    <div class="progress" style="height: 6px; background: rgba(255,255,255,0.05);">
                        <div class="progress-bar bg-success" style="width: 99.9%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sales Trend Chart
    const salesOptions = {
        series: [{
            name: 'Sales',
            data: [31, 40, 28, 51, 42, 109, 100]
        }],
        chart: {
            height: 300,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', colors: ['#7C3AED'] },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100, 100, 100]
            }
        },
        grid: { borderColor: 'rgba(255, 255, 255, 0.05)', strokeDashArray: 4 },
        xaxis: {
            categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            labels: { style: { colors: '#94A3B8' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: '#94A3B8' } } },
        theme: { mode: 'dark' }
    };

    const distOptions = {
        series: [44, 55, 13, 33],
        chart: {
            type: 'donut',
            height: 300,
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        labels: ['Electronics', 'Home', 'Fashion', 'Beauty'],
        colors: ['#7C3AED', '#06B6D4', '#8B5CF6', '#22D3EE'],
        legend: { position: 'bottom', labels: { colors: '#94A3B8' } },
        dataLabels: { enabled: false },
        stroke: { show: false },
        theme: { mode: 'dark' }
    };

    document.addEventListener('DOMContentLoaded', function() {
        const getTheme = () => document.documentElement.getAttribute('data-theme') || 'dark';
        
        const salesChart = new ApexCharts(document.querySelector("#salesChart"), {
            ...salesOptions,
            theme: { mode: getTheme() }
        });
        
        const distChart = new ApexCharts(document.querySelector("#distChart"), {
            ...distOptions,
            theme: { mode: getTheme() }
        });

        salesChart.render();
        distChart.render();

        // Listen for theme changes to update charts
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'data-theme') {
                    const newTheme = getTheme();
                    salesChart.updateOptions({ theme: { mode: newTheme } });
                    distChart.updateOptions({ theme: { mode: newTheme } });
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });
    });
</script>

<?php include 'includes/footer.php'; ?>
