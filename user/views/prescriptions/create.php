<?php
$pageTitle = "Create Prescription";
include '../includes/header.php';

// Get data passed from controller
$categories = $view_data['categories'];
$lenses_by_category = $view_data['lenses_by_category'];
$lenses = $view_data['lenses'];
?>

<?php include '../user/component/navbar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <!-- Main content -->
        <main class="col-md-12 ms-sm-auto px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">New Prescription</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="prescriptions.php" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>
                </div>
            </div>

            <form action="prescriptions.php?action=create" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Patient Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="patient_name" class="form-label">Patient Name *</label>
                                    <input type="text" class="form-control" id="patient_name" name="patient_name"
                                        required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" name="age">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date *</label>
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Distance Vision</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th></th>
                                                <th>SPH</th>
                                                <th>CYL</th>
                                                <th>AXIS</th>
                                                <th>VA</th>
                                                <th>PRISM</th>
                                                <th>BASE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>OD</strong></td>
                                                <td><input type="text" class="form-control" name="od_sph"></td>
                                                <td><input type="text" class="form-control" name="od_cyl"></td>
                                                <td><input type="text" class="form-control" name="od_axis"></td>
                                                <td><input type="text" class="form-control" name="od_va"></td>
                                                <td><input type="text" class="form-control" name="od_prism"></td>
                                                <td><input type="text" class="form-control" name="od_base"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>OS</strong></td>
                                                <td><input type="text" class="form-control" name="os_sph"></td>
                                                <td><input type="text" class="form-control" name="os_cyl"></td>
                                                <td><input type="text" class="form-control" name="os_axis"></td>
                                                <td><input type="text" class="form-control" name="os_va"></td>
                                                <td><input type="text" class="form-control" name="os_prism"></td>
                                                <td><input type="text" class="form-control" name="os_base"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Near Vision & PD</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">NEAR ADD</label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">OD</span>
                                            <input type="text" class="form-control" name="near_add_od">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">OS</span>
                                            <input type="text" class="form-control" name="near_add_os">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">PD</label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">OD</span>
                                            <input type="text" class="form-control" name="pd_od">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">OS</span>
                                            <input type="text" class="form-control" name="pd_os">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">


                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Lens Selection</h5>
                            </div>
                            <div class="card-body">
                                <!-- Categories Section -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Visual Categories (Blanks Category)</label>
                                    <div class="row">
                                        <?php foreach ($categories as $category): ?>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input category-checkbox" type="checkbox"
                                                        id="category_<?php echo $category['id']; ?>"
                                                        value="<?php echo $category['id']; ?>">
                                                    <label class="form-check-label"
                                                        for="category_<?php echo $category['id']; ?>">
                                                        <?php echo htmlspecialchars($category['name']); ?>
                                                        <?php if ($category['description']): ?>
                                                            <small class="text-muted">-
                                                                <?php echo htmlspecialchars($category['description']); ?></small>
                                                        <?php endif; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Lenses Section -->
                                <div class="mb-3">
                                    <label for="lens_type" class="form-label fw-bold">Available Lenses</label>
                                    <select class="form-select" id="lens_type" name="lens_type" required>
                                        <option value="">Select Lens Type</option>

                                        <!-- Group lenses by category -->
                                        <?php foreach ($lenses_by_category as $category_name => $category_lenses): ?>
                                            <optgroup label="<?php echo htmlspecialchars($category_name); ?>">
                                                <?php foreach ($category_lenses as $lens): ?>
                                                    <option value="<?php echo htmlspecialchars($lens['name']); ?>"
                                                        data-category="<?php echo $lens['category_id']; ?>">
                                                        <?php echo htmlspecialchars($lens['name']); ?>
                                                        <?php if ($lens['description']): ?>
                                                            - <?php echo htmlspecialchars($lens['description']); ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach; ?>

                                        <!-- Uncategorized lenses -->
                                        <?php
                                        $uncategorized_lenses = array_filter($lenses, function ($lens) {
                                            return empty($lens['category_id']);
                                        });
                                        if (!empty($uncategorized_lenses)): ?>
                                            <optgroup label="Other Lenses">
                                                <?php foreach ($uncategorized_lenses as $lens): ?>
                                                    <option value="<?php echo htmlspecialchars($lens['name']); ?>">
                                                        <?php echo htmlspecialchars($lens['name']); ?>
                                                        <?php if ($lens['description']): ?>
                                                            - <?php echo htmlspecialchars($lens['description']); ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                    <div class="form-text">Select from available lens types in our database</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Next Examination Advised</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="next_examination"
                                                id="exam1" value="1">
                                            <label class="form-check-label" for="exam1">1 Month</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="next_examination"
                                                id="exam2" value="2">
                                            <label class="form-check-label" for="exam2">2 Months</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="next_examination"
                                                id="exam3" value="3">
                                            <label class="form-check-label" for="exam3">3 Months</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="next_examination"
                                                id="exam6" value="6">
                                            <label class="form-check-label" for="exam6">6 Months</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save Prescription
                            </button>
                            <a href="prescriptions.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Quick lens selection buttons
        const quickLensButtons = document.querySelectorAll('.quick-lens-btn');
        const lensTypeSelect = document.getElementById('lens_type');

        quickLensButtons.forEach(button => {
            button.addEventListener('click', function () {
                const lensName = this.getAttribute('data-lens-name');
                lensTypeSelect.value = lensName;

                // Highlight the selected button
                quickLensButtons.forEach(btn => btn.classList.remove('btn-primary', 'active'));
                this.classList.add('btn-primary', 'active');
            });
        });

        // Category filtering (optional enhancement)
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const categoryId = this.value;
                const isChecked = this.checked;

                // This is where you could implement category-based filtering
                // For now, we'll just show a visual feedback
                if (isChecked) {
                    console.log('Category ' + categoryId + ' selected');
                }
            });
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            const lensType = lensTypeSelect.value;
            if (!lensType) {
                e.preventDefault();
                alert('Please select a lens type');
                lensTypeSelect.focus();
            }
        });

        // Auto-focus on patient name
        document.getElementById('patient_name').focus();
    });
</script>

<style>
    .quick-lens-btn {
        transition: all 0.2s ease-in-out;
    }

    .quick-lens-btn:hover {
        transform: translateY(-1px);
    }

    .quick-lens-btn.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .category-checkbox:checked+label {
        font-weight: bold;
        color: #0d6efd;
    }

    optgroup {
        font-weight: bold;
        font-style: normal;
        background-color: #f8f9fa;
    }

    optgroup option {
        font-weight: normal;
        padding-left: 20px;
    }
</style>

<?php include '../includes/footer.php'; ?>