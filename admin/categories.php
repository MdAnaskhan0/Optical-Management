<?php
include '../includes/config.php';
requireAdmin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        // Create new category
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);

        header("Location: categories.php?success=Category created successfully");
        exit();
    } elseif ($action == 'edit') {
        // Update category
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
        $stmt->execute([$name, $description, $id]);

        header("Location: categories.php?success=Category updated successfully");
        exit();
    } elseif ($action == 'delete') {
        // Delete category
        $id = $_POST['id'];

        // Check if category has lenses
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM lenses WHERE category_id = ?");
        $checkStmt->execute([$id]);
        $lensCount = $checkStmt->fetchColumn();

        if ($lensCount > 0) {
            header("Location: categories.php?error=Cannot delete category. It has lenses associated with it.");
            exit();
        }

        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: categories.php?success=Category deleted successfully");
        exit();
    }
}

// Set page title
if ($action == 'create') {
    $pageTitle = "Create Category";
} elseif ($action == 'edit') {
    $pageTitle = "Edit Category";
} else {
    $pageTitle = "Manage Categories";
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
        <!-- Category Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo $action == 'create' ? 'Create New Category' : 'Edit Category'; ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($action == 'edit'): ?>
                                <?php
                                $id = $_GET['id'];
                                $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
                                $stmt->execute([$id]);
                                $category = $stmt->fetch();
                                ?>
                                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?php echo $action == 'edit' ? $category['name'] : ''; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                        rows="4"><?php echo $action == 'edit' ? $category['description'] : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary"><?php echo $action == 'create' ? 'Create Category' : 'Update Category'; ?></button>
                                <a href="categories.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Categories List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Visual Categories</h4>
                        <a href="categories.php?action=create" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Category
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("SELECT * FROM categories ORDER BY created_at DESC");
                                    $categories = $stmt->fetchAll();

                                    foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?php echo $category['id']; ?></td>
                                            <td><?php echo $category['name']; ?></td>
                                            <td><?php echo $category['description'] ?: 'No description'; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($category['created_at'])); ?></td>
                                            <td>
                                                <a href="categories.php?action=edit&id=<?php echo $category['id']; ?>"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?php echo $category['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $category['id']; ?>"
                                                    tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete category
                                                                <strong>"<?php echo $category['name']; ?>"</strong>?
                                                                <div class="alert alert-warning mt-2">
                                                                    <small><i class="fas fa-exclamation-triangle me-1"></i>This
                                                                        action cannot be undone if the category has lenses
                                                                        associated with it.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="categories.php?action=delete">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $category['id']; ?>">
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
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