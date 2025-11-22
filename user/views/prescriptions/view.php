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
$tests = $tests ?? [];
$medicines = $medicines ?? [];

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
    <style>
        .medical-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .medical-row {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }

        .medical-column {
            border: 1px solid #000;
            padding: 10px;
            background: #f9f9f9;
        }

        .medical-column h4 {
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #313131ff;
            text-align: center;
            color: #000;
        }

        .test-item,
        .medicine-item {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #000000ff;
        }

        .medical-column:first-child {
            flex: 1;
        }

        .medical-column:last-child {
            flex: 2;
        }

        .test-item:last-child,
        .medicine-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .test-name,
        .medicine-name {
            font-weight: bold;
            color: #0f151bff;
        }

        .test-notes,
        .medicine-details {
            font-size: 0.9em;
            color: #555;
            margin-top: 3px;
            line-height: 1.4;
        }

        .medicine-property {
            display: block;
            margin-top: 2px;
            padding-left: 10px;
        }

        .medicine-property strong {
            color: #0f151bff;
        }

        .no-items {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
            padding: 10px 0;
        }

        .medicine-line {
            font-size: 0.95em;
            color: #333;
            line-height: 1.5;
            margin-bottom: 5px;
        }

        .medicine-item {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #eee;
        }

        .medicine-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        @media print {
            .medical-column {
                border: 1px solid #999;
                background: white;
            }
        }
    </style>
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
                    <tr style="display: flex; gap: 2%;">
                        <th colspan="5" width="49%">Right Eye</th>
                        <th colspan="5" width="49%">Left Eye</th>
                    </tr>

                    <tr style="display: flex; gap: 2%;">
                        <th width="13%"></th>
                        <th width="9%">SPH</th>
                        <th width="9%">CLY</th>
                        <th width="9%">AXIX</th>
                        <th width="9%">V/A</th>
                        <th width="13%"></th>
                        <th width="9%">SPH</th>
                        <th width="9%">CLY</th>
                        <th width="9%">AXIX</th>
                        <th width="9%">V/A</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Distance Row -->
                    <tr style="display: flex; gap: 2%;">
                        <td width="13%"><strong>Distance</strong></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_sph ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_cyl ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_axis ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_va ?? ''); ?></td>
                        <td width="13%"><strong>Distance</strong></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_sph ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_cyl ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_axis ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_va ?? ''); ?></td>
                    </tr>

                    <!-- Reading Row -->
                    <tr style="display: flex; gap: 2%;">
                        <td width="13%"><strong>Reading</strong></td>
                        <td width="9%">
                            <?php
                            // Calculate reading value: Addition + Sph value
                            $od_reading = '';
                            if (!empty($prescription->near_add_od) && !empty($prescription->od_sph)) {
                                $od_reading = floatval($prescription->near_add_od) + floatval($prescription->od_sph);
                            }
                            echo htmlspecialchars($od_reading);
                            ?>
                        </td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_cyl ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_axis ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->od_va ?? ''); ?></td>
                        <td width="13%"><strong>Reading</strong></td>
                        <td width="9%">
                            <?php
                            // Calculate reading value: Addition + Sph value
                            $os_reading = '';
                            if (!empty($prescription->near_add_os) && !empty($prescription->os_sph)) {
                                $os_reading = floatval($prescription->near_add_os) + floatval($prescription->os_sph);
                            }
                            echo htmlspecialchars($os_reading);
                            ?>
                        </td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_cyl ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_axis ?? ''); ?></td>
                        <td width="9%"><?php echo htmlspecialchars($prescription->os_va ?? ''); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Near ADD and PD Table -->
            <table class="near-pd-table compact-row">
                <thead>
                    <tr style="display: flex; gap: 2%;">
                        <th colspan="3" width="49%">Right Eye</th>
                        <th colspan="3" width="49%">Left Eye</th>
                    </tr>

                    <tr style="display: flex; gap: 2%;">
                        <th width="16.33%">ADD</th>
                        <th width="16.33%">PD</th>
                        <th width="16.33%">PRIS</th>
                        <th width="16.33%">ADD</th>
                        <th width="16.33%">PD</th>
                        <th width="16.33%">PRIS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="display: flex; gap: 2%;">
                        <td width="16.33%"><?php echo htmlspecialchars($prescription->near_add_od ?? ''); ?></td>
                        <td width="16.33%"><?php echo htmlspecialchars($prescription->pd_od ?? ''); ?></td>
                        <td width="16.33%"><?php echo htmlspecialchars($prescription->od_prism ?? ''); ?></td>
                        <td width="16.33%"><?php echo htmlspecialchars($prescription->near_add_os ?? ''); ?></td>
                        <td width="16.33%"><?php echo htmlspecialchars($prescription->pd_os ?? ''); ?></td>
                        <td width="16.33%"><?php echo htmlspecialchars($prescription->os_prism ?? ''); ?></td>
                    </tr>
                </tbody>
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

            <!-- Tests and Medicines Section -->
            <div class="medical-section">
                <div class="medical-row">
                    <!-- Tests Column -->
                    <div class="medical-column">
                        <h4>RECOMMENDED TESTS</h4>
                        <?php if (!empty($prescription->tests)): ?>
                            <?php foreach ($prescription->tests as $test): ?>
                                <div class="test-item">
                                    <div class="test-name"><?php echo htmlspecialchars($test['test_name'] ?? $test['name']); ?>
                                    </div>
                                    <?php if (!empty($test['notes'])): ?>
                                        <div class="test-notes">
                                            <strong>Notes:</strong> <?php echo htmlspecialchars($test['notes']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-items">No tests recommended</div>
                        <?php endif; ?>
                    </div>

                    <!-- Medicines Column -->
                    <div class="medical-column">
                        <h4>PRESCRIBED MEDICINES</h4>
                        <?php if (!empty($prescription->medicines)): ?>
                            <?php
                            $counter = 1;
                            foreach ($prescription->medicines as $medicine):
                                ?>
                                <div class="medicine-item">
                                    <div class="medicine-line">
                                        <?php
                                        $medicine_line = $counter . '. <span class="medicine-name">' . htmlspecialchars($medicine['medicine_name'] ?? $medicine['name']) . '</span>';

                                        // Add strength in parentheses if available
                                        if (!empty($medicine['strength'])) {
                                            $medicine_line = $counter . '. <span class="medicine-name">' . htmlspecialchars($medicine['medicine_name'] ?? $medicine['name']) . '(' . htmlspecialchars($medicine['strength']) . ')</span>';
                                        }

                                        // Add dosage with spaces around +
                                        if (!empty($medicine['dosage'])) {
                                            $medicine_line .= ' : ';
                                        }

                                        // Add frequency in 1+1+1 format
                                        if (!empty($medicine['frequency'])) {
                                            $frequency_display = $medicine['frequency'];
                                            // Convert to 1+1+1 format
                                            if ($medicine['frequency'] === 'Once daily') {
                                                $frequency_display = '1+0+0';
                                            } elseif ($medicine['frequency'] === 'Twice daily') {
                                                $frequency_display = '1+1+0';
                                            } elseif ($medicine['frequency'] === 'Three times daily') {
                                                $frequency_display = '1+1+1';
                                            } elseif ($medicine['frequency'] === 'Four times daily') {
                                                $frequency_display = '1+1+1+1';
                                            } elseif ($medicine['frequency'] === 'As needed') {
                                                $frequency_display = 'As needed';
                                            } elseif ($medicine['frequency'] === 'At bedtime') {
                                                $frequency_display = 'At bedtime';
                                            }
                                            $medicine_line .= ' ' . $frequency_display;
                                        }

                                        // Add duration with -->
                                        if (!empty($medicine['duration'])) {
                                            $medicine_line .= ' --> ' . htmlspecialchars($medicine['duration']) . ' days';
                                        }

                                        // Add instructions in parentheses
                                        if (!empty($medicine['instructions'])) {
                                            $medicine_line .= ' (' . htmlspecialchars($medicine['instructions']) . ')';
                                        }

                                        echo $medicine_line;
                                        ?>
                                    </div>
                                </div>
                                <?php $counter++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-items">No medicines prescribed</div>
                        <?php endif; ?>
                    </div>
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
                <!-- Visual wardrobe content here -->
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