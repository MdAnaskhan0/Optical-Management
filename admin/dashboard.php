<?php
include '../includes/config.php';
requireAdmin();

$pageTitle = "Admin Dashboard";
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 mb-0">Admin Dashboard</h1>
                <small class="text-muted"><?php echo date('F j, Y'); ?></small>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted small fw-semibold mb-1">Total Users</h6>
                            <h4 class="mb-0 fw-bold">
                                <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                                echo $stmt->fetchColumn();
                                ?>
                            </h4>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted small fw-semibold mb-1">Categories</h6>
                            <h4 class="mb-0 fw-bold">
                                <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM categories");
                                echo $stmt->fetchColumn();
                                ?>
                            </h4>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-list-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted small fw-semibold mb-1">Lenses</h6>
                            <h4 class="mb-0 fw-bold">
                                <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM lenses");
                                echo $stmt->fetchColumn();
                                ?>
                            </h4>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted small fw-semibold mb-1">Branches</h6>
                            <h4 class="mb-0 fw-bold">
                                <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM branches");
                                echo $stmt->fetchColumn();
                                ?>
                            </h4>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-code-branch fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-semibold">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="users.php?action=create" class="btn btn-outline-dark w-100">
                                <i class="fas fa-user-plus me-2"></i>Add User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="categories.php" class="btn btn-outline-dark w-100">
                                <i class="fas fa-tags me-2"></i>Manage Categories
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="lenses.php?action=create" class="btn btn-outline-dark w-100">
                                <i class="fas fa-plus me-2"></i>Add Lens
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="branches.php?action=create" class="btn btn-outline-dark w-100">
                                <i class="fas fa-code-branch me-2"></i>Add Branch
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-semibold">Recent Users</h6>
                </div>
                <div class="card-body">
                    <?php
                    $stmt = $pdo->query("SELECT username, full_name, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");
                    $recentUsers = $stmt->fetchAll();

                    if ($recentUsers): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentUsers as $user): ?>
                                <div class="list-group-item px-0 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1 small"><?php echo htmlspecialchars($user['full_name']); ?></h6>
                                            <p class="mb-0 text-muted small">@<?php echo htmlspecialchars($user['username']); ?>
                                            </p>
                                        </div>
                                        <span
                                            class="badge bg-light text-dark small"><?php echo ucfirst($user['role']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-0">No users found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-semibold">System Overview</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">System Status</span>
                                <span class="badge bg-success small">Operational</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Last Backup</span>
                                <span class="small text-muted"><?php echo date('M j, Y'); ?></span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Active Sessions</span>
                                <span class="small text-muted">1</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Server Time</span>
                                <span class="small text-muted"><?php echo date('g:i A'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: 1px solid #dee2e6;
        box-shadow: none;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa !important;
    }

    .btn-outline-dark {
        border-color: #2c3e50;
        color: #2c3e50;
    }

    .btn-outline-dark:hover {
        background-color: #2c3e50;
        border-color: #2c3e50;
        color: white;
    }

    .badge {
        font-size: 0.7em;
        font-weight: normal;
    }

    .list-group-item {
        padding: 0.75rem 0;
    }
</style>

<?php include '../includes/footer.php'; ?>