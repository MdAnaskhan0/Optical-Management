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
                        <div class="card border-light">
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
                        <div class="card border-light mt-3">
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
                        <div class="card border-light mt-3">
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
                        <div class="card border-light">
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
                                                        <input class="form-check-input category-checkbox" type="checkbox"
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
                                        <?php if (!empty($lenses)): ?>
                                            <?php foreach ($lenses as $lens): ?>
                                                <option value="<?php echo htmlspecialchars($lens['name']); ?>"
                                                    data-category="<?php echo $lens['category_id']; ?>">
                                                    <?php echo htmlspecialchars($lens['name']); ?>
                                                    <?php if (!empty($lens['description'])): ?>
                                                        - <?php echo htmlspecialchars($lens['description']); ?>
                                                    <?php endif; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">No lenses available</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Tests Section -->
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Recommended Tests</label>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-outline-secondary btn-sm w-100 text-start dropdown-toggle"
                                            type="button" id="testsDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Select Tests
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="testsDropdown">
                                            <?php if (!empty($tests)): ?>
                                                <?php foreach ($tests as $test): ?>
                                                    <li>
                                                        <div class="dropdown-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input test-checkbox" type="checkbox"
                                                                    id="test_<?php echo $test['id']; ?>" name="tests[]"
                                                                    value="<?php echo $test['id']; ?>">
                                                                <label class="form-check-label small"
                                                                    for="test_<?php echo $test['id']; ?>">
                                                                    <?php echo htmlspecialchars($test['name']); ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li><span class="dropdown-item text-muted">No tests available</span></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div id="selectedTests" class="mt-2 small"></div>
                                </div>

                                <!-- Medicines Section -->
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Prescribed Medicines</label>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-outline-secondary btn-sm w-100 text-start dropdown-toggle"
                                            type="button" id="medicinesDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Select Medicines
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="medicinesDropdown">
                                            <?php if (!empty($medicines)): ?>
                                                <?php foreach ($medicines as $medicine): ?>
                                                    <li>
                                                        <div class="dropdown-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input medicine-checkbox"
                                                                    type="checkbox" id="medicine_<?php echo $medicine['id']; ?>"
                                                                    name="medicines[]" value="<?php echo $medicine['id']; ?>">
                                                                <label class="form-check-label small"
                                                                    for="medicine_<?php echo $medicine['id']; ?>">
                                                                    <?php echo htmlspecialchars($medicine['name']); ?>
                                                                    <?php if (!empty($medicine['strength'])): ?>
                                                                        <span
                                                                            class="text-muted">(<?php echo htmlspecialchars($medicine['strength']); ?>)</span>
                                                                    <?php endif; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li><span class="dropdown-item text-muted">No medicines available</span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div id="selectedMedicines" class="mt-2 small"></div>
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
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const testCheckboxes = document.querySelectorAll('.test-checkbox');
        const medicineCheckboxes = document.querySelectorAll('.medicine-checkbox');
        const testsDropdown = document.getElementById('testsDropdown');
        const medicinesDropdown = document.getElementById('medicinesDropdown');
        const selectedTestsDiv = document.getElementById('selectedTests');
        const selectedMedicinesDiv = document.getElementById('selectedMedicines');
        const form = document.querySelector('form');

        // Filter lenses based on selected categories
        function filterLenses() {
            const selectedCategories = Array.from(categoryCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const allOptions = lensTypeSelect.querySelectorAll('option');

            allOptions.forEach(option => {
                if (option.value === '') return; // Keep the "Select Lens Type" option

                const optionCategory = option.getAttribute('data-category');

                if (selectedCategories.length === 0) {
                    // If no categories selected, show all lenses
                    option.style.display = '';
                } else if (optionCategory && selectedCategories.includes(optionCategory)) {
                    // Show lenses that belong to selected categories
                    option.style.display = '';
                } else {
                    // Hide lenses that don't belong to selected categories
                    option.style.display = 'none';
                }
            });

            // Reset selection if current selection is hidden
            if (lensTypeSelect.value && lensTypeSelect.options[lensTypeSelect.selectedIndex].style.display === 'none') {
                lensTypeSelect.value = '';
            }
        }

        // Update tests dropdown button text
        function updateTestsDropdown() {
            const selectedTests = Array.from(testCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.nextElementSibling.textContent.trim());

            if (selectedTests.length > 0) {
                testsDropdown.textContent = selectedTests.join(', ');
                selectedTestsDiv.innerHTML = '<strong>Selected:</strong> ' + selectedTests.join(', ');
            } else {
                testsDropdown.textContent = 'Select Tests';
                selectedTestsDiv.innerHTML = '';
            }
        }

        // Update medicines dropdown button text
        function updateMedicinesDropdown() {
            const selectedMedicines = Array.from(medicineCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => {
                    const label = cb.nextElementSibling;
                    const medicineName = label.childNodes[0].textContent.trim();
                    const strength = label.querySelector('.text-muted');
                    return strength ? medicineName + ' ' + strength.textContent : medicineName;
                });

            if (selectedMedicines.length > 0) {
                medicinesDropdown.textContent = selectedMedicines.join(', ');
                selectedMedicinesDiv.innerHTML = '<strong>Selected:</strong> ' + selectedMedicines.join(', ');
            } else {
                medicinesDropdown.textContent = 'Select Medicines';
                selectedMedicinesDiv.innerHTML = '';
            }
        }

        // Add event listeners to category checkboxes
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterLenses);
        });

        // Add event listeners to test checkboxes
        testCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTestsDropdown);
        });

        // Add event listeners to medicine checkboxes
        medicineCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateMedicinesDropdown);
        });

        // Prevent dropdown from closing when clicking checkboxes
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        // Form validation
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
        box-shadow: none;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa !important;
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

    .form-check-input:checked {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-primary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-primary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
    }

    .dropdown-item .form-check {
        margin: 0;
    }

    #selectedTests,
    #selectedMedicines {
        min-height: 20px;
    }
</style>

<?php include '../includes/footer.php'; ?>