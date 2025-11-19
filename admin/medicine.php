<?php
include '../includes/config.php';
requireAdmin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        // Create new medicine
        $name = $_POST['name'];
        $origin = $_POST['origin'];
        $manufacturer = $_POST['manufacturer'];
        $dosage_form = $_POST['dosage_form'];
        $strength = $_POST['strength'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO medicines (name, origin, manufacturer, dosage_form, strength, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $origin, $manufacturer, $dosage_form, $strength, $description]);

        header("Location: medicine.php?success=Medicine created successfully");
        exit();
    } elseif ($action == 'edit') {
        // Update medicine
        $id = $_POST['id'];
        $name = $_POST['name'];
        $origin = $_POST['origin'];
        $manufacturer = $_POST['manufacturer'];
        $dosage_form = $_POST['dosage_form'];
        $strength = $_POST['strength'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("UPDATE medicines SET name=?, origin=?, manufacturer=?, dosage_form=?, strength=?, description=? WHERE id=?");
        $stmt->execute([$name, $origin, $manufacturer, $dosage_form, $strength, $description, $id]);

        header("Location: medicine.php?success=Medicine updated successfully");
        exit();
    } elseif ($action == 'delete') {
        // Delete medicine
        $id = $_POST['id'];

        // Check if medicine has any associated data (modify this check based on your application)
        // $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM related_table WHERE medicine_id = ?");
        // $checkStmt->execute([$id]);
        // $relatedCount = $checkStmt->fetchColumn();

        // if ($relatedCount > 0) {
        //     header("Location: medicine.php?error=Cannot delete medicine. It has related data associated with it.");
        //     exit();
        // }

        $stmt = $pdo->prepare("DELETE FROM medicines WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: medicine.php?success=Medicine deleted successfully");
        exit();
    }
}

// Set page title
if ($action == 'create') {
    $pageTitle = "Create Medicine";
} elseif ($action == 'edit') {
    $pageTitle = "Edit Medicine";
} else {
    $pageTitle = "Manage Medicines";
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
        <!-- Medicine Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo $action == 'create' ? 'Create New Medicine' : 'Edit Medicine'; ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($action == 'edit'): ?>
                                <?php
                                $id = $_GET['id'];
                                $stmt = $pdo->prepare("SELECT * FROM medicines WHERE id = ?");
                                $stmt->execute([$id]);
                                $medicine = $stmt->fetch();
                                ?>
                                <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Medicine Name *</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?php echo $action == 'edit' ? $medicine['name'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="origin" class="form-label">Origin</label>
                                    <input type="text" class="form-control" id="origin" name="origin"
                                        value="<?php echo $action == 'edit' ? $medicine['origin'] : ''; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="manufacturer" class="form-label">Manufacturer</label>
                                    <input type="text" class="form-control" id="manufacturer" name="manufacturer"
                                        value="<?php echo $action == 'edit' ? $medicine['manufacturer'] : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dosage_form" class="form-label">Dosage Form</label>
                                    <select class="form-select" id="dosage_form" name="dosage_form">
                                        <option value="">Select Dosage Form</option>
                                        <option value="Tablet" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Tablet') ? 'selected' : ''; ?>>Tablet</option>
                                        <option value="Capsule" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Capsule') ? 'selected' : ''; ?>>Capsule</option>
                                        <option value="Syrup" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Syrup') ? 'selected' : ''; ?>>Syrup</option>
                                        <option value="Injection" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Injection') ? 'selected' : ''; ?>>Injection</option>
                                        <option value="Ointment" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Ointment') ? 'selected' : ''; ?>>Ointment</option>
                                        <option value="Cream" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Cream') ? 'selected' : ''; ?>>Cream</option>
                                        <option value="Inhaler" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Inhaler') ? 'selected' : ''; ?>>Inhaler</option>
                                        <option value="Drops" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Drops') ? 'selected' : ''; ?>>Drops</option>
                                        <option value="Other" <?php echo ($action == 'edit' && $medicine['dosage_form'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="strength" class="form-label">Strength</label>
                                    <input type="text" class="form-control" id="strength" name="strength"
                                        placeholder="e.g., 500mg, 10mg/ml"
                                        value="<?php echo $action == 'edit' ? $medicine['strength'] : ''; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description / Additional Information</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"
                                        placeholder="Enter any additional information about the medicine..."><?php echo $action == 'edit' ? $medicine['description'] : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary"><?php echo $action == 'create' ? 'Create Medicine' : 'Update Medicine'; ?></button>
                                <a href="medicine.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Medicines List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Medicine Inventory</h4>
                        <a href="medicine.php?action=create" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Medicine
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="medicinesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Origin</th>
                                        <th>Manufacturer</th>
                                        <th>Dosage Form</th>
                                        <th>Strength</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("SELECT * FROM medicines ORDER BY created_at DESC");
                                    $medicines = $stmt->fetchAll();

                                    foreach ($medicines as $medicine): ?>
                                        <tr>
                                            <td><?php echo $medicine['id']; ?></td>
                                            <td><?php echo $medicine['name']; ?></td>
                                            <td><?php echo $medicine['origin'] ?: 'N/A'; ?></td>
                                            <td><?php echo $medicine['manufacturer'] ?: 'N/A'; ?></td>
                                            <td><?php echo $medicine['dosage_form'] ?: 'N/A'; ?></td>
                                            <td><?php echo $medicine['strength'] ?: 'N/A'; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($medicine['created_at'])); ?></td>
                                            <td>
                                                <a href="medicine.php?action=edit&id=<?php echo $medicine['id']; ?>"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?php echo $medicine['id']; ?>" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $medicine['id']; ?>"
                                                    tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete medicine
                                                                <strong>"<?php echo $medicine['name']; ?>"</strong>?
                                                                <div class="alert alert-warning mt-2">
                                                                    <small><i class="fas fa-exclamation-triangle me-1"></i>This
                                                                        action cannot be undone.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="medicine.php?action=delete">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $medicine['id']; ?>">
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