<?php
include '../includes/config.php';
requireLogin();

$pageTitle = "My Profile";
include '../includes/header.php';

// Get current user data - FIXED JOIN CONDITION
$stmt = $pdo->prepare("SELECT u.*, b.branch_name as name 
                      FROM users u 
                      LEFT JOIN branches b ON u.branch_id = b.id 
                      WHERE u.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$error = '';
$success = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validate inputs
    if (empty($full_name)) {
        $error = "Full name is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        $error = "Please enter a valid email address.";
    } else {
        // Check if email already exists (excluding current user)
        if (!empty($email)) {
            $email_check = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $email_check->execute([$email, $_SESSION['user_id']]);
            if ($email_check->fetch()) {
                $error = "Email address is already in use.";
            }
        }

        if (!$error) {
            // Update profile
            $update_stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?");
            if ($update_stmt->execute([$full_name, $email, $phone, $_SESSION['user_id']])) {
                $success = "Profile updated successfully!";
                // Update session data
                $_SESSION['full_name'] = $full_name;
                // Refresh user data
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch();
            } else {
                $error = "Failed to update profile. Please try again.";
            }
        }
    }
}
?>

<?php include '../user/component/navbar.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Left Column - Profile Information -->
        <div class="col-md-4 mb-4">
            <div class="card border-light">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-4x text-muted"></i>
                    </div>
                    <h5 class="mb-1"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                    <p class="text-muted small mb-2"><?php echo ucfirst($user['role']); ?></p>
                    <?php if (!empty($user['employee_id'])): ?>
                        <p class="small mb-1"><strong>Employee ID:</strong>
                            <?php echo htmlspecialchars($user['employee_id']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($user['name'])): ?>
                        <p class="small mb-1"><strong>Branch:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <?php endif; ?>
                    <p class="small text-muted mb-0">
                        Member since <?php echo date('M Y', strtotime($user['created_at'])); ?>
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-light mt-3">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0">Account Status</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Status:</span>
                        <span class="badge bg-<?php echo $user['status'] == 'active' ? 'success' : 'secondary'; ?>">
                            <?php echo ucfirst($user['status']); ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Role:</span>
                        <span class="small"><?php echo ucfirst($user['role']); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">Last Login:</span>
                        <span class="small"><?php echo date('M j, Y g:i A'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Edit Profile -->
        <div class="col-md-8">
            <div class="card border-light">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0">Edit Profile</h6>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $success; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label small fw-semibold">Username</label>
                                <input type="text" class="form-control" id="username"
                                    value="<?php echo htmlspecialchars($user['username']); ?>" readonly disabled>
                                <div class="form-text">Username cannot be changed</div>
                            </div>

                            <div class="col-md-6">
                                <label for="employee_id" class="form-label small fw-semibold">Employee ID</label>
                                <input type="text" class="form-control" id="employee_id"
                                    value="<?php echo htmlspecialchars($user['employee_id'] ?? ''); ?>" readonly
                                    disabled>
                            </div>

                            <div class="col-12">
                                <label for="full_name" class="form-label small fw-semibold">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    value="<?php echo htmlspecialchars($user['full_name']); ?>"
                                    placeholder="Enter your full name" required>
                                <div class="invalid-feedback">
                                    Please enter your full name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                                    placeholder="Enter your email address">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label small fw-semibold">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                                    placeholder="Enter your phone number">
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label small fw-semibold">Role</label>
                                <input type="text" class="form-control" id="role"
                                    value="<?php echo ucfirst($user['role']); ?>" readonly disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="branch" class="form-label small fw-semibold">Branch</label>
                                <input type="text" class="form-control" id="branch"
                                    value="<?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?>" readonly disabled>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" name="update_profile" class="btn btn-dark">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                                <a href="dashboard.php" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card border-light mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0">Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Account Created</label>
                            <p class="small mb-0"><?php echo date('F j, Y g:i A', strtotime($user['created_at'])); ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Last Updated</label>
                            <p class="small mb-0">
                                <?php
                                // Check if updated_at column exists
                                if (isset($user['updated_at']) && !empty($user['updated_at'])) {
                                    echo date('F j, Y g:i A', strtotime($user['updated_at']));
                                } else {
                                    echo 'Never';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // Auto-focus on first editable field
    document.getElementById('full_name').focus();
</script>

<style>
    .card {
        border: 1px solid #dee2e6;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa !important;
    }

    .btn-dark {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }

    .btn-dark:hover {
        background-color: #34495e;
        border-color: #34495e;
    }

    .badge {
        font-size: 0.75em;
    }
</style>

<?php include '../includes/footer.php'; ?>