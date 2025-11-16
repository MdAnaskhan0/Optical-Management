<?php
include '../includes/config.php';
requireAdmin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        // Create new lens
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        
        $stmt = $pdo->prepare("INSERT INTO lenses (name, category_id, description) VALUES (?, ?, ?)");
        $stmt->execute([$name, $category_id, $description]);
        
        header("Location: lenses.php?success=Lens created successfully");
        exit();
    } elseif ($action == 'edit') {
        // Update lens
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        
        $stmt = $pdo->prepare("UPDATE lenses SET name=?, category_id=?, description=? WHERE id=?");
        $stmt->execute([$name, $category_id, $description, $id]);
        
        header("Location: lenses.php?success=Lens updated successfully");
        exit();
    } elseif ($action == 'delete') {
        // Delete lens
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM lenses WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: lenses.php?success=Lens deleted successfully");
        exit();
    }
}

// Set page title
if ($action == 'create') {
    $pageTitle = "Create Lens";
} elseif ($action == 'edit') {
    $pageTitle = "Edit Lens";
} else {
    $pageTitle = "Manage Lenses";
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
        <!-- Lens Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo $action == 'create' ? 'Create New Lens' : 'Edit Lens'; ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($action == 'edit'): ?>
                                <?php
                                $id = $_GET['id'];
                                $stmt = $pdo->prepare("SELECT * FROM lenses WHERE id = ?");
                                $stmt->execute([$id]);
                                $lens = $stmt->fetch();
                                ?>
                                <input type="hidden" name="id" value="<?php echo $lens['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Lens Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo $action == 'edit' ? $lens['name'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
                                        foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>" 
                                                <?php if ($action == 'edit' && $lens['category_id'] == $category['id']) echo 'selected'; ?>>
                                                <?php echo $category['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo $action == 'edit' ? $lens['description'] : ''; ?></textarea>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary"><?php echo $action == 'create' ? 'Create Lens' : 'Update Lens'; ?></button>
                                <a href="lenses.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Lenses List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Lenses</h4>
                        <a href="lenses.php?action=create" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Lens
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="lensesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("
                                        SELECT l.*, c.name as category_name 
                                        FROM lenses l 
                                        LEFT JOIN categories c ON l.category_id = c.id 
                                        ORDER BY l.created_at DESC
                                    ");
                                    $lenses = $stmt->fetchAll();
                                    
                                    foreach ($lenses as $lens): ?>
                                        <tr>
                                            <td><?php echo $lens['id']; ?></td>
                                            <td><?php echo $lens['name']; ?></td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $lens['category_name']; ?></span>
                                            </td>
                                            <td><?php echo $lens['description'] ?: 'No description'; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($lens['created_at'])); ?></td>
                                            <td>
                                                <a href="lenses.php?action=edit&id=<?php echo $lens['id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal<?php echo $lens['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $lens['id']; ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete lens <strong>"<?php echo $lens['name']; ?>"</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="lenses.php?action=delete">
                                                                    <input type="hidden" name="id" value="<?php echo $lens['id']; ?>">
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