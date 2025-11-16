<?php
// This navbar is for admin panel only
if (!isset($pageTitle)) {
    $pageTitle = "Admin Panel";
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>

                <!-- User Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i>Users
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="users.php?action=create"><i
                                    class="fas fa-user-plus me-1"></i>Create User</a></li>
                        <li><a class="dropdown-item" href="users.php"><i class="fas fa-list me-1"></i>All Users</a></li>
                    </ul>
                </li>

                <!-- Visual Category Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-list-alt me-1"></i>Visual Category
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="categories.php"><i class="fas fa-tags me-1"></i>Blanks
                                Category</a></li>
                    </ul>
                </li>

                <!-- Lenses Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="lensesDropdown" role="button"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-eye me-1"></i>Lense Type
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="lenses.php?action=create"><i
                                    class="fas fa-plus me-1"></i>Create Lens</a></li>
                        <li><a class="dropdown-item" href="lenses.php"><i class="fas fa-list me-1"></i>All Lenses</a>
                        </li>
                    </ul>
                </li>

                <!-- Branches Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="branchesDropdown" role="button"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-code-branch me-1"></i>Branches
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="branches.php?action=create"><i
                                    class="fas fa-plus me-1"></i>Create Branch</a></li>
                        <li><a class="dropdown-item" href="branches.php"><i class="fas fa-list me-1"></i>All
                                Branches</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
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
                </li>
            </ul>
        </div>
    </div>
</nav>