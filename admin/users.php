<?php
include '../includes/config.php';
requireAdmin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        // Create new user
        $employee_id = $_POST['employee_id'];
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $status = $_POST['status'];
        $branch_id = $_POST['branch_id'];
        
        $stmt = $pdo->prepare("INSERT INTO users (employee_id, username, full_name, email, password, role, status, branch_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$employee_id, $username, $full_name, $email, $password, $role, $status, $branch_id]);
        
        header("Location: users.php?success=User created successfully");
        exit();
    } elseif ($action == 'edit') {
        // Update user
        $id = $_POST['id'];
        $employee_id = $_POST['employee_id'];
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        $branch_id = $_POST['branch_id'];
        
        // Check if password is being updated
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET employee_id=?, username=?, full_name=?, email=?, password=?, role=?, status=?, branch_id=? WHERE id=?");
            $stmt->execute([$employee_id, $username, $full_name, $email, $password, $role, $status, $branch_id, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET employee_id=?, username=?, full_name=?, email=?, role=?, status=?, branch_id=? WHERE id=?");
            $stmt->execute([$employee_id, $username, $full_name, $email, $role, $status, $branch_id, $id]);
        }
        
        header("Location: users.php?success=User updated successfully");
        exit();
    } elseif ($action == 'delete') {
        // Delete user
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: users.php?success=User deleted successfully");
        exit();
    }
}

// Set page title
if ($action == 'create') {
    $pageTitle = "Create User";
} elseif ($action == 'edit') {
    $pageTitle = "Edit User";
} else {
    $pageTitle = "Manage Users";
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container-fluid mt-4">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_GET['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($action == 'create' || $action == 'edit'): ?>
        <!-- User Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo $action == 'create' ? 'Create New User' : 'Edit User'; ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($action == 'edit'): ?>
                                <?php
                                $id = $_GET['id'];
                                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                                $stmt->execute([$id]);
                                $user = $stmt->fetch();
                                ?>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id" 
                                           value="<?php echo $action == 'edit' ? $user['employee_id'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo $action == 'edit' ? $user['username'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" 
                                           value="<?php echo $action == 'edit' ? $user['full_name'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo $action == 'edit' ? $user['email'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        Password <?php if ($action == 'edit'): ?><small class="text-muted">(Leave blank to keep current password)</small><?php endif; ?>
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           <?php echo $action == 'create' ? 'required' : ''; ?>>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="branch_id" class="form-label">Branch</label>
                                    <select class="form-select" id="branch_id" name="branch_id" required>
                                        <option value="">Select Branch</option>
                                        <?php
                                        $branches = $pdo->query("SELECT * FROM branches")->fetchAll();
                                        foreach ($branches as $branch): ?>
                                            <option value="<?php echo $branch['id']; ?>" 
                                                <?php if ($action == 'edit' && $user['branch_id'] == $branch['id']) echo 'selected'; ?>>
                                                <?php echo $branch['branch_id'] . ' - ' . $branch['branch_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="user" <?php if ($action == 'edit' && $user['role'] == 'user') echo 'selected'; ?>>User</option>
                                        <option value="admin" <?php if ($action == 'edit' && $user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" <?php if ($action == 'edit' && $user['status'] == 'active') echo 'selected'; ?>>Active</option>
                                        <option value="inactive" <?php if ($action == 'edit' && $user['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary"><?php echo $action == 'create' ? 'Create User' : 'Update User'; ?></button>
                                <a href="users.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Users List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">All Users</h4>
                        <a href="users.php?action=create" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i>Create User
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Branch</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("
                                        SELECT u.*, b.branch_id, b.branch_name 
                                        FROM users u 
                                        LEFT JOIN branches b ON u.branch_id = b.id 
                                        ORDER BY u.created_at DESC
                                    ");
                                    $users = $stmt->fetchAll();
                                    
                                    foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['employee_id']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['full_name']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td>
                                                <span class="badge <?php echo $user['role'] == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                                    <?php echo ucfirst($user['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $user['status'] == 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?php echo ucfirst($user['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $user['branch_id'] . ' - ' . $user['branch_name']; ?></td>
                                            <td>
                                                <a href="users.php?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal<?php echo $user['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $user['id']; ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete user <strong><?php echo $user['full_name']; ?></strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="users.php?action=delete">
                                                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>