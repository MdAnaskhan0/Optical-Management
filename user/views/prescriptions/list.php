<?php
$pageTitle = "All Prescriptions";
include '../includes/header.php';

// Get filter parameters
$search = $_GET['search'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
?>

<?php include '../user/component/navbar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-12">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-3 mb-3 border-bottom">
                <h1 class="h4 mb-0">Prescriptions</h1>
                <a href="prescriptions.php?action=create" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-plus me-1"></i>New Prescription
                </a>
            </div>

            <!-- Search and Filter Section -->
            <div class="card border-light mb-4">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3 align-items-end">
                        <input type="hidden" name="action" value="list">

                        <!-- Search Field -->
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Search Patient</label>
                            <input type="text" class="form-control form-control-sm" name="search"
                                value="<?php echo htmlspecialchars($search); ?>" placeholder="Patient name...">
                        </div>

                        <!-- Date From -->
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Date From</label>
                            <input type="date" class="form-control form-control-sm" name="date_from"
                                value="<?php echo htmlspecialchars($date_from); ?>">
                        </div>

                        <!-- Date To -->
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Date To</label>
                            <input type="date" class="form-control form-control-sm" name="date_to"
                                value="<?php echo htmlspecialchars($date_to); ?>">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-sm btn-outline-dark w-100">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                        </div>

                        <!-- Reset Button -->
                        <div class="col-md-1">
                            <a href="prescriptions.php?action=list" class="btn btn-sm btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($stmt->rowCount() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="small fw-semibold">ID</th>
                                <th class="small fw-semibold">Patient Name</th>
                                <th class="small fw-semibold">Age</th>
                                <th class="small fw-semibold">Date</th>
                                <th class="small fw-semibold">Lens Type</th>
                                <th class="small fw-semibold">Created</th>
                                <th class="small fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td class="small"><?php echo $row['id']; ?></td>
                                    <td class="small"><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                    <td class="small"><?php echo $row['age']; ?></td>
                                    <td class="small"><?php echo $row['date']; ?></td>
                                    <td class="small"><?php echo htmlspecialchars($row['lens_type']); ?></td>
                                    <td class="small"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="prescriptions.php?action=view&id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-outline-dark" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="prescriptions.php?action=view&id=<?php echo $row['id']; ?>&print=true"
                                            class="btn btn-sm btn-outline-dark" title="Print">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="card border-light">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-medical text-muted fa-2x mb-3"></i>
                        <h6 class="text-muted">No prescriptions found</h6>
                        <p class="text-muted small mb-3">
                            <?php if ($search || $date_from || $date_to): ?>
                                No results match your search criteria.
                            <?php else: ?>
                                Get started by creating your first prescription.
                            <?php endif; ?>
                        </p>
                        <a href="prescriptions.php?action=create" class="btn btn-sm btn-outline-dark">
                            <i class="fas fa-plus me-1"></i>Create Prescription
                        </a>
                        <?php if ($search || $date_from || $date_to): ?>
                            <a href="prescriptions.php?action=list" class="btn btn-sm btn-outline-secondary ms-2">
                                <i class="fas fa-times me-1"></i>Clear Filters
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>