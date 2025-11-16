<?php
$pageTitle = "Create Prescription";
include '../includes/header.php';
?>

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
                    </div>

                    <div class="col-md-6">
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

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Lens Selection</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="lens_type" class="form-label">Lens Type</label>
                                    <select class="form-select" id="lens_type" name="lens_type">
                                        <option value="">Select Lens Type</option>
                                        <option value="Single Vision">Single Vision</option>
                                        <option value="Bifocal Flat Top">Bifocal Flat Top</option>
                                        <option value="Bifocal Round Top">Bifocal Round Top</option>
                                        <option value="Bifocal Executive">Bifocal Executive</option>
                                        <option value="Progressive">Progressive</option>
                                        <option value="Ego (HC/HMC)">Ego (HC/HMC)</option>
                                        <option value="Zion (Photochromic)">Zion (Photochromic)</option>
                                        <option value="Ego Free Form (HMC/Photochromic)">Ego Free Form
                                            (HMC/Photochromic)</option>
                                        <option value="Tokai (Japan)">Tokai (Japan)</option>
                                        <option value="Rodenstock (Germany)">Rodenstock (Germany)</option>
                                        <option value="Mr. Blue 1.56">Mr. Blue 1.56</option>
                                        <option value="Mr. Blue 1.67">Mr. Blue 1.67</option>
                                        <option value="Myopia Control Lens">Myopia Control Lens</option>
                                        <option value="Ortho K Lens">Ortho K Lens</option>
                                        <option value="Ego Tinted Lens / Sunglass">Ego Tinted Lens / Sunglass</option>
                                        <option value="Ego/Bionix Disposable Contact Lens">Ego/Bionix Disposable Contact
                                            Lens</option>
                                    </select>
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

<?php include '../includes/footer.php'; ?>