<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch users from API
$api_url = "https://dummyjson.com/users";
$response = @file_get_contents($api_url);
$users_data = json_decode($response, true);
$users = isset($users_data['users']) ? $users_data['users'] : [];
?>

<div class="container mt-5 mb-5 flex-grow-1">
    <div class="row align-items-end mb-5">
        <div class="col-md-6">
            <h2 class="display-6 fw-800 text-theme mb-0">Customer <span class="text-gradient">Profiles</span></h2>
            <p class="text-muted mb-0">Manage and view registered community members.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="glass-card d-inline-flex p-2">
                <span class="badge badge-premium"><?php echo count($users); ?> Active Users</span>
            </div>
        </div>
    </div>
    
    <?php if(empty($users)): ?>
        <div class="glass-card text-center p-5">
            <i class="fas fa-user-slash fa-3x text-muted mb-4"></i>
            <h3 class="text-theme">No users found</h3>
            <p class="text-muted">We couldn't retrieve the user database at this moment.</p>
            <a href="users.php" class="btn btn-primary mt-3">Try Reloading</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($users as $user): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4 h-100 transition-hover">
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="position-relative">
                                <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="User" class="avatar" style="width: 64px; height: 64px; background: rgba(255,255,255,0.05);">
                                <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-dark rounded-circle" style="width: 14px; height: 14px;" title="Online"></span>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1 text-theme fw-700"><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></h5>
                                <p class="mb-0 text-primary small fw-600">@<?php echo htmlspecialchars($user['username']); ?></p>
                                <div class="d-flex gap-2 mt-2">
                                    <span class="badge bg-glass text-muted small px-2">ID: <?php echo $user['id']; ?></span>
                                    <span class="badge bg-glass text-muted small px-2" style="text-transform: capitalize;"><?php echo htmlspecialchars($user['gender']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="fas fa-envelope me-2 text-primary-light" style="width: 16px;"></i>
                                <span class="text-truncate"><?php echo htmlspecialchars($user['email']); ?></span>
                            </div>
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="fas fa-phone me-2 text-primary-light" style="width: 16px;"></i>
                                <span><?php echo htmlspecialchars($user['phone']); ?></span>
                            </div>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-map-marker-alt me-2 text-primary-light" style="width: 16px;"></i>
                                <span class="text-truncate"><?php echo htmlspecialchars($user['address']['city'] ?? 'New York'); ?>, <?php echo htmlspecialchars($user['address']['state'] ?? 'NY'); ?></span>
                            </div>
                        </div>

                        <div class="pt-3 border-top border-secondary d-flex gap-2">
                            <a href="user_cart.php?user_id=<?php echo $user['id']; ?>" class="btn btn-secondary btn-sm flex-grow-1 py-2">
                                <i class="fas fa-shopping-cart me-2"></i>View Cart
                            </a>
                            <button class="btn btn-outline-secondary btn-sm px-3" title="User Actions">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
