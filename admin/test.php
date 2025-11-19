<?php
include '../includes/config.php';
requireAdmin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        // Create new test
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO tests (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);

        header("Location: test.php?success=Test created successfully");
        exit();
    } elseif ($action == 'edit') {
        // Update test
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("UPDATE tests SET name=?, description=? WHERE id=?");
        $stmt->execute([$name, $description, $id]);

        header("Location: test.php?success=Test updated successfully");
        exit();
    } elseif ($action == 'delete') {
        // Delete test
        $id = $_POST['id'];

        $stmt = $pdo->prepare("DELETE FROM tests WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: test.php?success=Test deleted successfully");
        exit();
    }
}

// Set page title
if ($action == 'create') {
    $pageTitle = "Create Test";
} elseif ($action == 'edit') {
    $pageTitle = "Edit Test";
} else {
    $pageTitle = "Manage Tests";
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
        <!-- Test Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo $action == 'create' ? 'Create New Test' : 'Edit Test'; ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($action == 'edit'): ?>
                                <?php
                                $id = $_GET['id'];
                                $stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ?");
                                $stmt->execute([$id]);
                                $test = $stmt->fetch();
                                ?>
                                <input type="hidden" name="id" value="<?php echo $test['id']; ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Test Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?php echo $action == 'edit' ? $test['name'] : ''; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                        rows="4"><?php echo $action == 'edit' ? $test['description'] : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary"><?php echo $action == 'create' ? 'Create Test' : 'Update Test'; ?></button>
                                <a href="test.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Tests List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Patent Tests</h4>
                        <a href="test.php?action=create" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Test
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="testsTable">
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
                                    $stmt = $pdo->query("SELECT * FROM tests ORDER BY created_at DESC");
                                    $tests = $stmt->fetchAll();

                                    foreach ($tests as $test): ?>
                                        <tr>
                                            <td><?php echo $test['id']; ?></td>
                                            <td><?php echo $test['name']; ?></td>
                                            <td><?php echo $test['description'] ?: 'No description'; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($test['created_at'])); ?></td>
                                            <td>
                                                <a href="test.php?action=edit&id=<?php echo $test['id']; ?>"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?php echo $test['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $test['id']; ?>"
                                                    tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete test
                                                                <strong>"<?php echo $test['name']; ?>"</strong>?
                                                                <div class="alert alert-warning mt-2">
                                                                    <small><i class="fas fa-exclamation-triangle me-1"></i>This
                                                                        action cannot be undone.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="test.php?action=delete">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $test['id']; ?>">
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