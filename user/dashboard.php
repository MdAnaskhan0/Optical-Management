<?php
include '../includes/config.php';
requireLogin();

$pageTitle = "User Dashboard";
include '../includes/header.php';
?>

<?php include '../user/component/navbar.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Welcome Section -->
            <div class="card border-light mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2">Welcome, <?php echo $_SESSION['full_name']; ?></h4>
                            <p class="text-muted mb-0">You are logged in as <?php echo ucfirst($_SESSION['role']); ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo date('M j, Y g:i A'); ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-file-medical fa-2x text-dark"></i>
                            </div>
                            <h5 class="card-title">Prescriptions</h5>
                            <p class="card-text text-muted small">Manage patient prescriptions and view history</p>
                            <a href="prescriptions.php" class="btn btn-outline-dark btn-sm">View All</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-plus fa-2x text-dark"></i>
                            </div>
                            <h5 class="card-title">New Prescription</h5>
                            <p class="card-text text-muted small">Create a new prescription for a patient</p>
                            <a href="prescriptions.php?action=create" class="btn btn-dark btn-sm">Create New</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity (Optional) -->
            <div class="card border-light">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-medical text-muted me-2"></i>
                                    <span class="small">No recent activity</span>
                                </div>
                                <span class="text-muted small">-</span>
                            </div>
                        </div>
                        <!-- You can add more recent activity items here -->
                        <div class="list-group-item px-0">
                            <div class="text-center">
                                <a href="prescriptions.php" class="text-decoration-none small">
                                    View all prescriptions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>