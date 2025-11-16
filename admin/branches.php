<?php
include '../includes/config.php';
requireAdmin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        // Create new branch
        $branch_id = $_POST['branch_id'];
        $branch_name = $_POST['branch_name'];
        
        $stmt = $pdo->prepare("INSERT INTO branches (branch_id, branch_name) VALUES (?, ?)");
        $stmt->execute([$branch_id, $branch_name]);
        
        header("Location: branches.php?success=Branch created successfully");
        exit();
    } elseif ($action == 'edit') {
        // Update branch
        $id = $_POST['id'];
        $branch_id = $_POST['branch_id'];
        $branch_name = $_POST['branch_name'];
        
        $stmt = $pdo->prepare("UPDATE branches SET branch_id=?, branch_name=? WHERE id=?");
        $stmt->execute([$branch_id, $branch_name, $id]);
        
        header("Location: branches.php?success=Branch updated successfully");
        exit();
    } elseif ($action == 'delete') {
        // Delete branch
        $id = $_POST['id'];
        
        // Check if branch has users
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE branch_id = ?");
        $checkStmt->execute([$id]);
        $userCount = $checkStmt->fetchColumn();
        
        if ($userCount > 0) {
            header("Location: branches.php?error=Cannot delete branch. It has users associated with it.");
            exit();
        }
        
        $stmt = $pdo->prepare("DELETE FROM branches WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: branches.php?success=Branch deleted successfully");
        exit();
    }
}

// Set page title
if ($action == 'create') {
    $pageTitle = "Create Branch";
} elseif ($action == 'edit') {
    $pageTitle = "Edit Branch";
} else {
    $pageTitle = "Manage Branches";
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
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_GET['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($action == 'create' || $action == 'edit'): ?>
        <!-- Branch Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo $action == 'create' ? 'Create New Branch' : 'Edit Branch'; ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($action == 'edit'): ?>
                                <?php
                                $id = $_GET['id'];
                                $stmt = $pdo->prepare("SELECT * FROM branches WHERE id = ?");
                                $stmt->execute([$id]);
                                $branch = $stmt->fetch();
                                ?>
                                <input type="hidden" name="id" value="<?php echo $branch['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="branch_id" class="form-label">Branch ID</label>
                                    <input type="text" class="form-control" id="branch_id" name="branch_id" 
                                           value="<?php echo $action == 'edit' ? $branch['branch_id'] : ''; ?>" required>
                                    <div class="form-text">Unique identifier for the branch (e.g., F01, F02)</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="branch_name" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" id="branch_name" name="branch_name" 
                                           value="<?php echo $action == 'edit' ? $branch['branch_name'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary"><?php echo $action == 'create' ? 'Create Branch' : 'Update Branch'; ?></button>
                                <a href="branches.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Branches List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Branches</h4>
                        <a href="branches.php?action=create" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Branch
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="branchesTable">
                                <thead>
                                    <tr>
                                        <th>Branch ID</th>
                                        <th>Branch Name</th>
                                        <th>Created At</th>
                                        <th>User Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("
                                        SELECT b.*, COUNT(u.id) as user_count 
                                        FROM branches b 
                                        LEFT JOIN users u ON b.id = u.branch_id 
                                        GROUP BY b.id 
                                        ORDER BY b.created_at DESC
                                    ");
                                    $branches = $stmt->fetchAll();
                                    
                                    foreach ($branches as $branch): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $branch['branch_id']; ?></span>
                                            </td>
                                            <td><?php echo $branch['branch_name']; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($branch['created_at'])); ?></td>
                                            <td>
                                                <span class="badge <?php echo $branch['user_count'] > 0 ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?php echo $branch['user_count']; ?> users
                                                </span>
                                            </td>
                                            <td>
                                                <a href="branches.php?action=edit&id=<?php echo $branch['id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal<?php echo $branch['id']; ?>"
                                                        <?php echo $branch['user_count'] > 0 ? 'disabled' : ''; ?>>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $branch['id']; ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete branch <strong>"<?php echo $branch['branch_name']; ?>"</strong>?
                                                                <?php if ($branch['user_count'] > 0): ?>
                                                                    <div class="alert alert-danger mt-2">
                                                                        <small><i class="fas fa-exclamation-triangle me-1"></i>This branch has <?php echo $branch['user_count']; ?> user(s) associated with it. You cannot delete it.</small>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <?php if ($branch['user_count'] == 0): ?>
                                                                    <form method="POST" action="branches.php?action=delete">
                                                                        <input type="hidden" name="id" value="<?php echo $branch['id']; ?>">
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                <?php endif; ?>
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