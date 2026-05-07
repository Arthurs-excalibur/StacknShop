<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch products from API
$api_url = "https://dummyjson.com/products";
$response = @file_get_contents($api_url);
$products_data = json_decode($response, true);
$products = isset($products_data['products']) ? $products_data['products'] : [];
?>

<div class="container mt-5 mb-5 flex-grow-1">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h2 class="display-6 fw-800 text-theme mb-0">Global <span class="text-gradient">Catalog</span></h2>
            <p class="text-muted mb-0">Explore our curated selection of premium products.</p>
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="row g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-glass border-secondary text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="productSearch" class="form-control border-secondary" placeholder="Search products...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="categoryFilter" class="form-select bg-glass text-theme border-secondary">
                        <option value="all">All Categories</option>
                        <?php 
                        $categories = array_unique(array_column($products, 'category'));
                        foreach($categories as $cat): 
                        ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo ucfirst(htmlspecialchars($cat)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <div id="noResults" class="glass-card text-center p-5 d-none">
        <i class="fas fa-search fa-3x text-muted mb-4"></i>
        <h3 class="text-theme">No matches found</h3>
        <p class="text-muted">Try adjusting your search or filters.</p>
    </div>

    <?php if(empty($products)): ?>
        <div class="glass-card text-center p-5">
            <i class="fas fa-search fa-3x text-muted mb-4"></i>
            <h3 class="text-theme">No items found</h3>
            <p class="text-muted">We couldn't retrieve the product catalog at this moment.</p>
            <a href="products.php" class="btn btn-primary mt-3">Try Reloading</a>
        </div>
    <?php else: ?>
        <div class="row g-4" id="productGrid">
            <?php foreach($products as $product): ?>
                <div class="col-md-6 col-lg-4 col-xl-3 product-item" data-category="<?php echo htmlspecialchars($product['category']); ?>" data-title="<?php echo strtolower(htmlspecialchars($product['title'])); ?>">
                    <div class="glass-card product-card h-100 d-flex flex-column p-0 overflow-hidden transition-hover">
                        <div class="card-img-container cursor-pointer view-details" 
                             data-title="<?php echo htmlspecialchars($product['title']); ?>"
                             data-price="<?php echo htmlspecialchars($product['price']); ?>"
                             data-desc="<?php echo htmlspecialchars($product['description']); ?>"
                             data-img="<?php echo htmlspecialchars($product['thumbnail']); ?>"
                             data-rating="<?php echo htmlspecialchars($product['rating']); ?>"
                             data-stock="<?php echo htmlspecialchars($product['stock']); ?>">
                            <img src="<?php echo htmlspecialchars($product['thumbnail']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" style="mix-blend-mode: multiply;">
                            <div class="card-overlay">
                                <span class="btn btn-light btn-sm rounded-pill px-3 fw-600">Quick View</span>
                            </div>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small text-uppercase fw-600 letter-spacing-1"><?php echo htmlspecialchars($product['category']); ?></span>
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i> <?php echo isset($product['rating']) ? htmlspecialchars($product['rating']) : '4.5'; ?>
                                </div>
                            </div>
                            <h5 class="text-theme fw-700 mb-2 line-clamp-2 cursor-pointer view-details" 
                                data-title="<?php echo htmlspecialchars($product['title']); ?>"
                                data-price="<?php echo htmlspecialchars($product['price']); ?>"
                                data-desc="<?php echo htmlspecialchars($product['description']); ?>"
                                data-img="<?php echo htmlspecialchars($product['thumbnail']); ?>"
                                data-rating="<?php echo htmlspecialchars($product['rating']); ?>"
                                data-stock="<?php echo htmlspecialchars($product['stock']); ?>">
                                <?php echo htmlspecialchars($product['title']); ?>
                            </h5>
                            <p class="text-muted small mb-3 line-clamp-2"><?php echo htmlspecialchars($product['description'] ?? ''); ?></p>
                            
                            <div class="mt-auto pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 fw-800 text-gradient">$<?php echo htmlspecialchars($product['price']); ?></span>
                                </div>
                                <span class="badge bg-glass text-muted border border-secondary small"><?php echo htmlspecialchars($product['stock']); ?> left</span>
                            </div>
                            <button class="btn btn-primary w-100 mt-4 py-2 add-to-cart" data-name="<?php echo htmlspecialchars($product['title']); ?>">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content overflow-hidden border-secondary">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 bg-white d-flex align-items-center justify-content-center p-4">
                        <img id="modalImg" src="" alt="" class="img-fluid" style="mix-blend-mode: multiply; max-height: 400px;">
                    </div>
                    <div class="col-md-7 p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 id="modalTitle" class="fw-800 text-theme mb-1"></h3>
                                <div id="modalRating" class="text-warning small"></div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <p id="modalDesc" class="text-secondary leading-relaxed mb-4"></p>
                        <div class="d-flex align-items-center gap-3 mb-5">
                            <span id="modalPrice" class="display-6 fw-800 text-gradient"></span>
                            <span id="modalStock" class="badge bg-glass border border-secondary text-muted"></span>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg py-3 modal-add-to-cart">
                                <i class="fas fa-cart-plus me-2"></i>Add to Shopping Cart
                            </button>
                            <button class="btn btn-secondary btn-lg py-3" data-bs-dismiss="modal">
                                Continue Shopping
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
    // Search and Filter Logic
    const searchInput = document.getElementById('productSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const productItems = document.querySelectorAll('.product-item');
    const noResults = document.getElementById('noResults');
    const productGrid = document.getElementById('productGrid');

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        let visibleCount = 0;

        productItems.forEach(item => {
            const title = item.getAttribute('data-title');
            const category = item.getAttribute('data-category');
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

            if (matchesSearch && matchesCategory) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        noResults.classList.toggle('d-none', visibleCount > 0);
        productGrid.classList.toggle('d-none', visibleCount === 0);
    }

    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);

    // Quick View Logic
    const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
    const modalTitle = document.getElementById('modalTitle');
    const modalPrice = document.getElementById('modalPrice');
    const modalDesc = document.getElementById('modalDesc');
    const modalImg = document.getElementById('modalImg');
    const modalRating = document.getElementById('modalRating');
    const modalStock = document.getElementById('modalStock');
    let currentProductName = '';

    document.querySelectorAll('.view-details').forEach(el => {
        el.addEventListener('click', function() {
            modalTitle.innerText = this.getAttribute('data-title');
            modalPrice.innerText = '$' + this.getAttribute('data-price');
            modalDesc.innerText = this.getAttribute('data-desc');
            modalImg.src = this.getAttribute('data-img');
            modalStock.innerText = this.getAttribute('data-stock') + ' in stock';
            currentProductName = this.getAttribute('data-title');
            
            const rating = Math.round(parseFloat(this.getAttribute('data-rating')));
            modalRating.innerHTML = '<i class="fas fa-star"></i>'.repeat(rating) + '<i class="far fa-star"></i>'.repeat(5-rating);
            
            quickViewModal.show();
        });
    });

    document.querySelector('.modal-add-to-cart').addEventListener('click', function() {
        showToast(`${currentProductName} added to cart!`);
        quickViewModal.hide();
    });

    // Toast Logic
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `custom-toast ${type}`;
        
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-info-circle';
        
        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add to Cart Simulation
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const name = this.getAttribute('data-name');
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
            
            setTimeout(() => {
                showToast(`${name} added to cart!`);
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-cart-plus me-2"></i>Add to Cart';
                
                // Trigger Offcanvas Cart
                const cartDrawer = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
                cartDrawer.show();
                
                // Update badge (simple simulation)
                const badge = document.querySelector('.nav-item .badge');
                if (badge) {
                    badge.innerText = parseInt(badge.innerText) + 1;
                }
            }, 800);
        });
    });

    // Magnetic Glow Tracking
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
