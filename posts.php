<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch posts from API
$api_url = "https://dummyjson.com/posts";
$response = @file_get_contents($api_url);
$posts_data = json_decode($response, true);
$posts = isset($posts_data['posts']) ? $posts_data['posts'] : [];
?>

<div class="container mt-5 mb-5 flex-grow-1">
    <div class="row align-items-end mb-5">
        <div class="col-md-6">
            <h2 class="display-6 fw-800 text-theme mb-0">Community <span class="text-gradient">Insights</span></h2>
            <p class="text-muted mb-0">Stay updated with the latest trends and discussions.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="glass-card d-inline-flex p-2">
                <span class="badge badge-premium"><?php echo count($posts); ?> Published Posts</span>
            </div>
        </div>
    </div>
    
    <?php if(empty($posts)): ?>
        <div class="glass-card text-center p-5">
            <i class="fas fa-pencil-alt fa-3x text-muted mb-4"></i>
            <h3 class="text-theme">No posts available</h3>
            <p class="text-muted">The community is quiet for now. Check back later!</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($posts as $post): ?>
                <div class="col-md-6">
                    <div class="glass-card h-100 p-4 d-flex flex-column transition-hover">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-glass text-primary fw-600 px-3 py-2 rounded-pill me-3">
                                <i class="far fa-id-badge me-1"></i> ID: <?php echo $post['id']; ?>
                            </span>
                            <small class="text-muted"><i class="far fa-eye me-1"></i> <?php echo rand(100, 999); ?> Views</small>
                        </div>
                        
                        <h4 class="text-theme fw-700 mb-3 line-clamp-2"><?php echo htmlspecialchars($post['title']); ?></h4>
                        <p class="text-secondary flex-grow-1 mb-4 leading-relaxed">
                            <?php echo htmlspecialchars(substr($post['body'], 0, 180)) . '...'; ?>
                        </p>
                        
                        <div class="mb-4 d-flex flex-wrap gap-2">
                            <?php foreach($post['tags'] as $tag): ?>
                                <span class="badge bg-glass text-secondary border border-secondary px-3 py-2">
                                    <i class="fas fa-hashtag me-1"></i><?php echo htmlspecialchars($tag); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary mt-auto">
                            <div class="d-flex gap-3">
                                <span class="text-success small fw-600">
                                    <i class="fas fa-thumbs-up me-1"></i> <?php echo htmlspecialchars($post['reactions']['likes'] ?? 0); ?>
                                </span>
                                <span class="text-danger small fw-600">
                                    <i class="fas fa-thumbs-down me-1"></i> <?php echo htmlspecialchars($post['reactions']['dislikes'] ?? 0); ?>
                                </span>
                            </div>
                            <a href="#" class="btn btn-link text-primary text-decoration-none p-0 fw-600">
                                Read Full <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
