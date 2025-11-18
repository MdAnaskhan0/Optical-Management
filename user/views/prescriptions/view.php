<?php
// Include config only if not already included
if (!defined('OPTICAL_MANAGEMENT_CONFIG')) {
    include '../includes/config.php';
}
requireLogin();

// Get prescription data from controller - using local variables instead of $view_data
$prescription = $prescription ?? null;
$categories = $categories ?? [];
$lenses_by_category = $lenses_by_category ?? [];
$lenses = $lenses ?? [];



if (!$prescription) {
    echo "<div class='alert alert-danger'>Prescription not found.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Report</title>
    <link rel="stylesheet" href="assets/prescriptionstyle.css">
</head>

<body>
    <div class="container">
        <div class="btn-container no-print">
            <a href="prescriptions.php" class="btn btn-secondary">Back to List</a>
            <button onclick="window.print()" class="btn btn-primary">Print Prescription</button>
        </div>

        <div class="prescription-report">
            <!-- Header Section -->
            <div class="header-section">
                <h1>OPTICAL MANAGEMENT SYSTEM</h1>
                <h2>PRESCRIPTION REPORT</h2>
                <div class="tagline">Quality Eye Care & Vision Solutions</div>
                <div class="brand">Professional Optical Services</div>
            </div>

            <div class="divider"></div>

            <!-- Company Info -->
            <div class="company-info compact-row">
                <strong>Your Optical Store Name</strong> | 123 Vision Street, Eye City | Phone: (555) 123-4567
            </div>

            <div class="divider"></div>

            <!-- RG Number -->
            <div style="text-align: center; margin: 5px 0;" class="compact-row">
                <strong>Prescription No: P<?php echo str_pad($prescription->id, 6, '0', STR_PAD_LEFT); ?></strong>
            </div>

            <!-- Patient Information -->
            <div class="patient-info compact-row">
                <table>
                    <tr>
                        <td width="15%"><strong>Name :</strong></td>
                        <td width="35%"><span
                                class="empty-field"><?php echo htmlspecialchars($prescription->patient_name ?? ''); ?></span>
                        </td>
                        <td width="15%"><strong>Age :</strong></td>
                        <td width="35%"><span
                                class="empty-field"><?php echo htmlspecialchars($prescription->age ?? ''); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Phone :</strong></td>
                        <td width="35%"><span
                                class="empty-field"><?php echo htmlspecialchars($prescription->phone ?? ''); ?></span>
                        </td>
                        <td width="15%"><strong>Date :</strong></td>
                        <td width="35%"><span
                                class="empty-field"><?php echo htmlspecialchars($prescription->date ?? ''); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Distance Vision Table -->
            <table class="prescription-table compact-row">
                <thead>
                    <tr>
                        <th width="14%">DISTANCE</th>
                        <th width="14%">SPH</th>
                        <th width="14%">CYL</th>
                        <th width="14%">AXIS</th>
                        <th width="14%">VA</th>
                        <th width="15%">PRISM</th>
                        <th width="15%">BASE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>OD</strong></td>
                        <td><?php echo htmlspecialchars($prescription->od_sph ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_cyl ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_axis ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_va ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_prism ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_base ?? ''); ?></td>
                    </tr>
                    <tr>
                        <td><strong>OS</strong></td>
                        <td><?php echo htmlspecialchars($prescription->os_sph ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_cyl ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_axis ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_va ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_prism ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_base ?? ''); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Near ADD and PD Table -->
            <table class="near-pd-table compact-row">
                <tr>
                    <td width="20%" class="section-title">NEAR ADD</td>
                    <td width="30%">
                        <strong>OD</strong> <?php echo htmlspecialchars($prescription->near_add_od ?? ''); ?>
                    </td>
                    <td width="20%" class="section-title">PD</td>
                    <td width="30%">
                        <strong>OD</strong> <?php echo htmlspecialchars($prescription->pd_od ?? ''); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <strong>OS</strong> <?php echo htmlspecialchars($prescription->near_add_os ?? ''); ?>
                    </td>
                    <td></td>
                    <td>
                        <strong>OS</strong> <?php echo htmlspecialchars($prescription->pd_os ?? ''); ?>
                    </td>
                </tr>
            </table>

            <!-- Selected Visual Categories -->
            <div class="lens-selection compact-row">
                <div>
                    <?php if (!empty($prescription->visual_categories)): ?>
                        <div class="selected-categories compact-row">
                            <strong>Selected Categories:</strong>
                            <?php
                            $selected_category_ids = explode(',', $prescription->visual_categories);
                            foreach ($categories as $category):
                                if (in_array($category['id'], $selected_category_ids)):
                                    ?>
                                    <span class="category-tag"><?php echo htmlspecialchars($category['name']); ?></span>
                                    <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="selected-categories compact-row">
                    <strong>Selected Lens:</strong>
                    <span
                        class="category-tag"><?php echo htmlspecialchars($prescription->lens_type ?? 'Not selected'); ?></span>
                </div>
            </div>

            <!-- Remarks -->
            <div class="remarks compact-row">
                <strong>Remarks:</strong>
                <span
                    class="empty-field"><?php echo htmlspecialchars($prescription->remarks ?? 'No remarks'); ?></span><br>
                <em>(Please preserve this card for future reference.)</em>
            </div>

            <div class="divider"></div>

            <!-- Visual Wardrobe -->
            <div class="visual-wardrobe">


            </div>

            <!-- Next Examination -->
            <div class="examination-advised compact-row">
                <strong>Next examination advised:</strong>
                <span class="checkbox-option">□ 1</span>
                <span class="checkbox-option">□ 2</span>
                <span class="checkbox-option">□ 3</span>
                <span class="checkbox-option">□ 6 month</span>
                <?php
                $next_exam = $prescription->next_examination ?? '';
                if ($next_exam == '1')
                    echo '<strong style="margin-left: 10px;">[✓ 1 month]</strong>';
                elseif ($next_exam == '2')
                    echo '<strong style="margin-left: 10px;">[✓ 2 months]</strong>';
                elseif ($next_exam == '3')
                    echo '<strong style="margin-left: 10px;">[✓ 3 months]</strong>';
                elseif ($next_exam == '6')
                    echo '<strong style="margin-left: 10px;">[✓ 6 months]</strong>';
                ?>
            </div>

            <div class="divider"></div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-line"></div>
                <div>Doctor Seal & Signature</div>
                <div></div>
            </div>
        </div>
    </div>

    <script>
        // Auto-print when page loads if print parameter is set
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('print')) {
                setTimeout(function () {
                    window.print();
                }, 500);
            }
        };
    </script>
</body>

</html>