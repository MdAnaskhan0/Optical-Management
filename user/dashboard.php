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
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i><?php echo $_SESSION['full_name']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-1"></i>Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
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

                            <div class="mt-4">
                                <h5>Your Information:</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Username:</strong> <?php echo $_SESSION['username']; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Role:</strong> <?php echo ucfirst($_SESSION['role']); ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Branch ID:</strong> <?php echo $_SESSION['branch_id']; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                                    <h5><?php echo $_SESSION['full_name']; ?></h5>
                                    <p class="text-muted"><?php echo ucfirst($_SESSION['role']); ?></p>
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