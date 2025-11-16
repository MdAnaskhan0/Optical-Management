<?php
$pageTitle = "All Prescriptions";
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Main content -->
        <main class="col-md-12 ms-sm-auto px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">My Prescriptions</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="prescriptions.php?action=create" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>New Prescription
                    </a>
                </div>
            </div>

            <?php if ($stmt->rowCount() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>Date</th>
                                <th>Lens Type</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                    <td><?php echo $row['age']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo htmlspecialchars($row['lens_type']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="prescriptions.php?action=view&id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="prescriptions.php?action=view&id=<?php echo $row['id']; ?>&print=true"
                                            class="btn btn-sm btn-outline-success" title="Print">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No prescriptions found.
                    <a href="prescriptions.php?action=create" class="alert-link">Create your first prescription</a>.
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>