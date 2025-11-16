<?php
include '../includes/config.php';
requireLogin();

$pageTitle = "User Dashboard";
include '../includes/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <i class="fas fa-glasses me-2"></i>Optical Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="prescriptions.php">
                        <i class="fas fa-file-medical me-1"></i>Prescriptions
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i><?php echo $_SESSION['full_name']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-1"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../logout.php"><i
                                    class="fas fa-sign-out-alt me-1"></i>Logout</a></li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">User Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Welcome, <?php echo $_SESSION['full_name']; ?>!</h4>
                            <p class="lead">You are logged in as a <?php echo $_SESSION['role']; ?>.</p>

                            <!-- Quick Actions -->
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <i class="fas fa-file-medical fa-3x text-primary mb-3"></i>
                                            <h5>Prescriptions</h5>
                                            <p>Manage patient prescriptions</p>
                                            <a href="prescriptions.php" class="btn btn-primary">View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <i class="fas fa-plus-circle fa-3x text-success mb-3"></i>
                                            <h5>New Prescription</h5>
                                            <p>Create a new prescription</p>
                                            <a href="prescriptions.php?action=create" class="btn btn-success">Create
                                                New</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                                    <h5><?php echo $_SESSION['full_name']; ?></h5>
                                    <p class="text-muted"><?php echo ucfirst($_SESSION['role']); ?></p>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Last login: <?php echo date('M j, Y g:i A'); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>