<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-layer-group me-2"></i>Stack N Shop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <?php 
                $current_page = basename($_SERVER['PHP_SELF']); 
                ?>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php"><i class="fas fa-chart-line"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>" href="products.php"><i class="fas fa-shopping-bag"></i>Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'users.php' || $current_page == 'user_cart.php') ? 'active' : ''; ?>" href="users.php"><i class="fas fa-users"></i>Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'posts.php') ? 'active' : ''; ?>" href="posts.php"><i class="fas fa-newspaper"></i>Posts</a>
                    </li>
                    
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3 border border-secondary rounded-pill" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['full_name']); ?>&background=7C3AED&color=fff" class="rounded-circle" style="width: 32px; height: 32px;">
                            <span class="small d-none d-xl-inline"><?php echo explode(' ', $_SESSION['full_name'])[0]; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end glass-card p-2 mt-2 border-secondary shadow-lg" aria-labelledby="profileDropdown" style="min-width: 200px; background: var(--bg-card);">
                            <li><h6 class="dropdown-header text-muted small text-uppercase fw-800">Account Settings</h6></li>
                            <li><a class="dropdown-item rounded-3 mb-1 py-2" href="#"><i class="fas fa-user-edit me-2 small"></i> Edit Profile</a></li>
                            <li><a class="dropdown-item rounded-3 mb-1 py-2 text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2 small"></i> Sign Out</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>" href="login.php"><i class="fas fa-sign-in-alt"></i>Login</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary btn-sm px-4" href="register.php">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </li>
                <?php endif; ?>
                
                <!-- Cart Trigger -->
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <button class="nav-link btn btn-link p-2 position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary border border-2 border-dark" style="font-size: 0.5rem; padding: 0.25em 0.5em;">3</span>
                    </button>
                </li>
                <?php endif; ?>

                <!-- Theme Toggle -->
                <li class="nav-item ms-lg-2">
                    <button id="themeToggle" class="nav-link btn btn-link p-2" title="Toggle Light/Dark Mode">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Offcanvas Cart -->
<div class="offcanvas offcanvas-end glass-card border-start border-secondary" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" style="background: var(--bg-card); width: 400px;">
    <div class="offcanvas-header border-bottom border-secondary p-4">
        <h5 class="offcanvas-title fw-800 text-theme" id="cartOffcanvasLabel">
            <i class="fas fa-shopping-basket me-2 text-primary"></i>Your Basket
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="cart-items space-y-4">
            <!-- Mock Cart Item -->
            <div class="glass-card p-3 d-flex gap-3 align-items-center">
                <img src="https://cdn.dummyjson.com/product-images/1/thumbnail.jpg" class="rounded" style="width: 60px; height: 60px; object-fit: cover; background: white;">
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-700 text-theme small">iPhone 9</h6>
                    <p class="text-muted small mb-0">$549.00 x 1</p>
                </div>
                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash-alt small"></i></button>
            </div>
            <!-- Empty state placeholder -->
            <div id="cartEmptyState" class="text-center py-5 d-none">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-muted">Your cart is empty.</p>
                <a href="products.php" class="btn btn-primary btn-sm">Browse Products</a>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border-top border-secondary p-4">
        <div class="d-flex justify-content-between mb-3">
            <span class="text-muted">Subtotal</span>
            <span class="fw-800 text-theme fs-5">$549.00</span>
        </div>
        <div class="d-grid gap-2">
            <a href="user_cart.php" class="btn btn-primary py-3 fw-700">Checkout Now</a>
            <button class="btn btn-outline-secondary py-2 small" data-bs-dismiss="offcanvas">Continue Shopping</button>
        </div>
    </div>
</div>

<!-- Command Palette Modal -->
<div class="modal fade" id="commandPalette" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="modal-content glass-card p-0 overflow-hidden shadow-2xl">
            <div class="input-group p-3 border-bottom border-secondary">
                <span class="input-group-text bg-transparent border-0 text-muted fs-4">
                    <i class="fas fa-terminal"></i>
                </span>
                <input type="text" id="paletteSearch" class="form-control bg-transparent border-0 fs-5 text-theme" placeholder="Type a command or search..." autofocus>
                <span class="input-group-text bg-transparent border-0 small">
                    <kbd class="bg-glass text-muted px-2 py-1 rounded">ESC</kbd>
                </span>
            </div>
            <div class="modal-body p-2" style="max-height: 400px; overflow-y: auto;">
                <div class="command-group mb-3">
                    <h6 class="px-3 py-2 text-muted small text-uppercase fw-800">Quick Actions</h6>
                    <a href="products.php" class="command-item d-flex align-items-center gap-3 px-3 py-2 rounded-3 text-decoration-none">
                        <div class="stat-icon sm bg-primary"><i class="fas fa-shopping-bag small"></i></div>
                        <div class="flex-grow-1">
                            <p class="mb-0 text-theme fw-600">Browse Products</p>
                            <small class="text-muted">Explore the catalog</small>
                        </div>
                        <kbd class="bg-glass text-muted small px-2">G P</kbd>
                    </a>
                    <div id="paletteThemeToggle" class="command-item d-flex align-items-center gap-3 px-3 py-2 rounded-3 cursor-pointer">
                        <div class="stat-icon sm bg-secondary"><i class="fas fa-adjust small"></i></div>
                        <div class="flex-grow-1">
                            <p class="mb-0 text-theme fw-600">Toggle Theme</p>
                            <small class="text-muted">Switch between Light/Dark</small>
                        </div>
                        <kbd class="bg-glass text-muted small px-2">T</kbd>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-glass border-top-0 py-2">
                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Use arrow keys to navigate and Enter to select</small>
            </div>
        </div>
    </div>
</div>

<style>
    .command-item { 
        transition: all 0.2s ease; 
        cursor: pointer;
    }
    .command-item:hover { 
        background: var(--glass-bg);
        transform: translateX(4px);
    }
    kbd { font-family: inherit; }
</style>

<script>
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    
    function updateIcon(theme) {
        if (theme === 'light') {
            themeIcon.className = 'fas fa-sun';
        } else {
            themeIcon.className = 'fas fa-moon';
        }
    }

    // Initial icon state
    updateIcon(document.documentElement.getAttribute('data-theme'));

    const toggleTheme = () => {
        let currentTheme = document.documentElement.getAttribute('data-theme');
        let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
    };

    themeToggle.addEventListener('click', toggleTheme);

    // Sticky Navbar logic
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });

    // Simulated Page Loader
    window.addEventListener('load', () => {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.style.width = '100%';
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.width = '0';
                    loader.style.opacity = '1';
                }, 400);
            }, 500);
        }
    });

    // Command Palette Logic
    const commandPaletteModal = document.getElementById('commandPalette');
    if (commandPaletteModal) {
        const commandPalette = new bootstrap.Modal(commandPaletteModal);
        
        window.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                commandPalette.show();
            }
            if (commandPaletteModal.classList.contains('show') && e.key === 't') {
                toggleTheme();
                commandPalette.hide();
            }
        });

        document.getElementById('paletteThemeToggle').addEventListener('click', () => {
            toggleTheme();
            commandPalette.hide();
        });
    }
</script>
