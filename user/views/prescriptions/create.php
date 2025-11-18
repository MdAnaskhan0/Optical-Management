<?php
$pageTitle = "Create Prescription";
include '../includes/header.php';

$categories = $view_categories ?? [];
$lenses_by_category = $view_lenses_by_category ?? [];
$lenses = $view_lenses ?? [];

?>

<?php include '../user/component/navbar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-12">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-3 mb-3 border-bottom">
                <h1 class="h4 mb-0">New Prescription</h1>
                <a href="prescriptions.php" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
            </div>

            <form action="prescriptions.php?action=create" method="post">
                <div class="row g-3">
                    <!-- Left Column - Patient Info & Vision -->
                    <div class="col-lg-6">
                        <!-- Patient Information -->
                        <div class="card">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">Patient Information</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label for="patient_name" class="form-label small fw-semibold">Patient Name
                                            *</label>
                                        <input type="text" class="form-control form-control-sm" id="patient_name"
                                            name="patient_name" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="age" class="form-label small fw-semibold">Age</label>
                                        <input type="number" class="form-control form-control-sm" id="age" name="age">
                                    </div>
                                    <div class="col-6">
                                        <label for="phone" class="form-label small fw-semibold">Phone *</label>
                                        <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        <label for="date" class="form-label small fw-semibold">Date *</label>
                                        <input type="date" class="form-control form-control-sm" id="date" name="date"
                                            value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Distance Vision -->
                        <div class="card mt-3">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">Distance Vision</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 12%"></th>
                                                <th class="small">SPH</th>
                                                <th class="small">CYL</th>
                                                <th class="small">AXIS</th>
                                                <th class="small">VA</th>
                                                <th class="small">PRISM</th>
                                                <th class="small">BASE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="small fw-bold">OD</td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="od_sph"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="od_cyl"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="od_axis"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="od_va"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="od_prism"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="od_base"></td>
                                            </tr>
                                            <tr>
                                                <td class="small fw-bold">OS</td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="os_sph"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="os_cyl"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="os_axis"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="os_va"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="os_prism"></td>
                                                <td><input type="text" class="form-control form-control-sm border-0 p-1"
                                                        name="os_base"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Near Vision & PD -->
                        <div class="card mt-3">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">Near Vision & PD</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small fw-semibold">NEAR ADD</label>
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text bg-light small" style="width: 40px;">OD</span>
                                            <input type="text" class="form-control" name="near_add_od">
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light small" style="width: 40px;">OS</span>
                                            <input type="text" class="form-control" name="near_add_os">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-semibold">PD</label>
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text bg-light small" style="width: 40px;">OD</span>
                                            <input type="text" class="form-control" name="pd_od">
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light small" style="width: 40px;">OS</span>
                                            <input type="text" class="form-control" name="pd_os">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="remarks" class="form-label small fw-semibold">Remarks</label>
                                    <textarea class="form-control form-control-sm" id="remarks" name="remarks"
                                        rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Lens Selection -->
                    <div class="col-lg-6">
                        <!-- Lens Selection -->
                        <div class="card">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">Lens Selection</h6>
                            </div>
                            <div class="card-body p-3">
                                <!-- Categories Section -->
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Visual Categories</label>
                                    <div class="row g-1">
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                                <div class="col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="category_<?php echo $category['id']; ?>"
                                                            name="visual_categories[]" value="<?php echo $category['id']; ?>">
                                                        <label class="form-check-label small"
                                                            for="category_<?php echo $category['id']; ?>">
                                                            <?php echo htmlspecialchars($category['name']); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <p class="text-muted small mb-0">No categories available</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Lenses Section -->
                                <div class="mb-3">
                                    <label for="lens_type" class="form-label small fw-semibold">Lens Type *</label>
                                    <select class="form-select form-select-sm" id="lens_type" name="lens_type" required>
                                        <option value="">Select Lens Type</option>
                                        <?php if (!empty($lenses_by_category)): ?>
                                            <?php foreach ($lenses_by_category as $category_name => $category_lenses): ?>
                                                <?php if (!empty($category_lenses)): ?>
                                                    <optgroup label="<?php echo htmlspecialchars($category_name); ?>">
                                                        <?php foreach ($category_lenses as $lens): ?>
                                                            <option value="<?php echo htmlspecialchars($lens['name']); ?>"
                                                                data-category="<?php echo $lens['category_id']; ?>">
                                                                <?php echo htmlspecialchars($lens['name']); ?>
                                                                <?php if (!empty($lens['description'])): ?>
                                                                    - <?php echo htmlspecialchars($lens['description']); ?>
                                                                <?php endif; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- Uncategorized lenses -->
                                        <?php
                                        $uncategorized_lenses = [];
                                        if (!empty($lenses)) {
                                            $uncategorized_lenses = array_filter($lenses, function ($lens) {
                                                return empty($lens['category_id']);
                                            });
                                        }
                                        if (!empty($uncategorized_lenses)): ?>
                                            <optgroup label="Other Lenses">
                                                <?php foreach ($uncategorized_lenses as $lens): ?>
                                                    <option value="<?php echo htmlspecialchars($lens['name']); ?>">
                                                        <?php echo htmlspecialchars($lens['name']); ?>
                                                        <?php if (!empty($lens['description'])): ?>
                                                            - <?php echo htmlspecialchars($lens['description']); ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (empty($lenses_by_category) && empty($uncategorized_lenses)): ?>
                                        <div class="form-text text-warning">No lenses available in database</div>
                                    <?php endif; ?>
                                </div>

                                <!-- Next Examination -->
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Next Examination</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="next_examination"
                                                    id="exam1" value="1">
                                                <label class="form-check-label small" for="exam1">1 Month</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="next_examination"
                                                    id="exam2" value="2">
                                                <label class="form-check-label small" for="exam2">2 Months</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="next_examination"
                                                    id="exam3" value="3">
                                                <label class="form-check-label small" for="exam3">3 Months</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="next_examination"
                                                    id="exam6" value="6">
                                                <label class="form-check-label small" for="exam6">6 Months</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-save me-1"></i>Save Prescription
                                    </button>
                                    <a href="prescriptions.php" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lensTypeSelect = document.getElementById('lens_type');
        const form = document.querySelector('form');

        form.addEventListener('submit', function (e) {
            const lensType = lensTypeSelect.value;
            if (!lensType) {
                e.preventDefault();
                alert('Please select a lens type');
                lensTypeSelect.focus();
            }
        });

        document.getElementById('patient_name').focus();
    });
</script>

<style>
    .card {
        border: 1px solid #dee2e6;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
    }

    .form-control-sm {
        font-size: 0.875rem;
    }

    .table input {
        background-color: transparent;
        min-width: 40px;
    }

    .table input:focus {
        background-color: white;
        box-shadow: inset 0 0 0 1px #86b7fe;
    }

    .small {
        font-size: 0.875rem;
    }

    optgroup {
        font-weight: 600;
    }

    optgroup option {
        font-weight: normal;
    }
</style>

<?php include '../includes/footer.php'; ?>