<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'includes/navbar.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$user_carts = [];

if ($user_id > 0) {
    // Fetch carts from API
    $api_url = "https://dummyjson.com/carts";
    $response = @file_get_contents($api_url);
    if ($response) {
        $carts_data = json_decode($response, true);
        $all_carts = isset($carts_data['carts']) ? $carts_data['carts'] : [];
        
        // Filter by userId
        foreach ($all_carts as $cart) {
            if ($cart['userId'] == $user_id) {
                $user_carts[] = $cart;
            }
        }
    }
}
?>

<div class="container mt-5 mb-5 flex-grow-1">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="display-6 fw-800 text-theme mb-0">Shopping <span class="text-gradient">Carts</span></h2>
            <p class="text-muted mb-0">Reviewing active inventory for Customer #<?php echo $user_id; ?></p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="users.php" class="btn btn-secondary px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <?php if ($user_id <= 0): ?>
        <div class="glass-card text-center p-5 border-danger">
            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-4"></i>
            <h3 class="text-theme">Invalid Request</h3>
            <p class="text-muted">The user ID provided is not valid in our system.</p>
        </div>
    <?php elseif (empty($user_carts)): ?>
        <div class="glass-card p-5 text-center">
            <div class="stat-icon mx-auto mb-4" style="background: rgba(255,255,255,0.05)">
                <i class="fas fa-shopping-basket text-muted"></i>
            </div>
            <h4 class="text-theme">No active carts found</h4>
            <p class="text-muted">This customer hasn't initiated any shopping sessions yet.</p>
            <a href="products.php" class="btn btn-primary mt-3">Browse Products</a>
        </div>
    <?php else: ?>
        <?php foreach($user_carts as $cart): ?>
            <div class="glass-card p-0 mb-5 overflow-hidden">
                <div class="p-4 bg-glass border-bottom border-secondary d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="mb-1 text-theme fw-700">Order Ref: <span class="text-primary">#<?php echo htmlspecialchars($cart['id']); ?></span></h4>
                        <span class="badge bg-glass text-muted"><i class="far fa-clock me-1"></i> Active Session</span>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-end">
                            <small class="text-muted d-block">Items Count</small>
                            <span class="fw-bold text-theme"><?php echo htmlspecialchars($cart['totalProducts']); ?> Units</span>
                        </div>
                        <div class="text-end border-start border-secondary ps-3">
                            <small class="text-muted d-block">Total Value</small>
                            <span class="fw-800 text-gradient fs-5">$<?php echo htmlspecialchars($cart['total']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                        <thead class="small text-uppercase text-muted letter-spacing-1">
                            <tr>
                                <th class="ps-4 py-3">Product Description</th>
                                <th class="text-center py-3">Quantity</th>
                                <th class="text-end py-3">Unit Price</th>
                                <th class="text-end pe-4 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cart['products'] as $item): ?>
                                <tr style="border-bottom: 1px solid var(--glass-border);">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white rounded p-1 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-tag text-primary small"></i>
                                            </div>
                                            <span class="fw-600 text-theme"><?php echo htmlspecialchars($item['title']); ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="badge bg-glass text-theme px-3"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                    </td>
                                    <td class="text-end py-3 text-secondary">$<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td class="text-end pe-4 py-3 fw-700 text-theme">$<?php echo htmlspecialchars($item['total']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end py-4 text-muted">Discounted Total:</td>
                                <td class="text-end pe-4 py-4 fs-5 fw-800 text-success">$<?php echo htmlspecialchars($cart['discountedTotal']); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
