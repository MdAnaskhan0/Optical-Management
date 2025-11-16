<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Report</title>
    <style>
        /* Same CSS as the admin view.php file */
        @media print {
            @page {
                size: A5;
                margin: 0.2cm;
            }

            body * {
                visibility: hidden;
            }

            .prescription-report,
            .prescription-report * {
                visibility: visible;
            }

            .prescription-report {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 10px;
                font-size: 12px;
                transform: scale(0.95);
                transform-origin: top left;
            }

            .no-print {
                display: none !important;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 595px;
            height: 842px;
            margin: 10px auto;
            background: white;
            padding: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .prescription-report {
            width: 100%;
            height: 100%;
            border: 1px solid #000;
            padding: 8px;
            box-sizing: border-box;
            line-height: 1.2;
            font-size: 12px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 8px;
        }

        .header-section h1 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .header-section h2 {
            font-size: 20px;
            margin: 2px 0;
            font-weight: bold;
        }

        .header-section .tagline {
            font-weight: bold;
            margin: 2px 0;
            font-size: 11px;
        }

        .header-section .brand {
            margin: 2px 0;
            font-size: 11px;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .company-info {
            text-align: center;
            margin: 5px 0;
            font-size: 11px;
        }

        .patient-info {
            margin: 8px 0;
        }

        .patient-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-info td {
            padding: 1px 3px;
            font-size: 11px;
        }

        .prescription-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 10px;
        }

        .prescription-table th,
        .prescription-table td {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
            vertical-align: middle;
        }

        .prescription-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
        }

        .near-pd-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 10px;
        }

        .near-pd-table td {
            border: 1px solid #000;
            padding: 4px 2px;
            vertical-align: top;
        }

        .near-pd-table .section-title {
            font-weight: bold;
            background-color: #f0f0f0;
            text-align: center;
            font-size: 9px;
        }

        .remarks {
            margin: 8px 0;
            padding: 3px;
            font-size: 10px;
        }

        .visual-wardrobe {
            margin: 10px 0;
        }

        .wardrobe-section {
            margin: 5px 0;
        }

        .wardrobe-title {
            font-weight: bold;
            margin-bottom: 3px;
            text-align: center;
            font-size: 11px;
        }

        .wardrobe-table {
            width: 100%;
            border-collapse: collapse;
            margin: 3px 0;
            font-size: 9px;
        }

        .wardrobe-table td {
            border: 1px solid #000;
            padding: 3px 2px;
            vertical-align: top;
        }

        .wardrobe-table .category {
            font-weight: bold;
            background-color: #f0f0f0;
            text-align: center;
        }

        .checkbox-option {
            display: inline-block;
            margin-right: 8px;
            font-size: 9px;
        }

        .examination-advised {
            margin: 8px 0;
            text-align: center;
            font-size: 10px;
        }

        .signature-section {
            text-align: center;
            margin-top: 15px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 150px;
            margin: 25px auto 3px;
        }

        .btn-container {
            text-align: center;
            margin: 10px 0;
        }

        .btn {
            padding: 8px 15px;
            margin: 0 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .empty-field {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 100px;
            margin: 0 3px;
        }

        .lens-selection {
            margin: 5px 0;
            padding: 3px;
            font-size: 10px;
        }

        .selected-lens {
            font-weight: bold;
            text-decoration: underline;
            margin: 3px 0;
        }

        .compact-row {
            margin-bottom: 4px;
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
            <div class="header-section compact-row">
                <h1>5.31 inch</h1>
                <h2>50</h2>
                <div class="tagline">Better Vision, Perfect Look.</div>
                <div class="brand">Brandt Seal</div>
            </div>

            <div class="divider"></div>

            <!-- Company Info -->
            <div class="company-info compact-row">
                <strong>FASHION OPTICS LTD*:</strong><br>
                Barack Chart
            </div>

            <div class="divider"></div>

            <!-- RG Number -->
            <div style="text-align: center; margin: 5px 0;" class="compact-row">
                <strong>RG: 0001</strong>
            </div>

            <!-- Patient Information -->
            <div class="patient-info compact-row">
                <table>
                    <tr>
                        <td width="15%"><strong>For :</strong></td>
                        <td><span
                                class="empty-field"><?php echo htmlspecialchars($prescription->patient_name); ?></span>
                        </td>
                        <td width="12%"><strong>Age :</strong></td>
                        <td><span class="empty-field"><?php echo htmlspecialchars($prescription->age); ?></span></td>
                        <td width="15%"><strong>Date :</strong></td>
                        <td><span class="empty-field"><?php echo htmlspecialchars($prescription->date); ?></span></td>
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
                        <td><?php echo htmlspecialchars($prescription->od_sph); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_cyl); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_axis); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_va); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_prism); ?></td>
                        <td><?php echo htmlspecialchars($prescription->od_base); ?></td>
                    </tr>
                    <tr>
                        <td><strong>OS</strong></td>
                        <td><?php echo htmlspecialchars($prescription->os_sph); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_cyl); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_axis); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_va); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_prism); ?></td>
                        <td><?php echo htmlspecialchars($prescription->os_base); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Near ADD and PD Table -->
            <table class="near-pd-table compact-row">
                <tr>
                    <td width="20%" class="section-title">NEAR ADD</td>
                    <td width="30%">
                        <strong>OD</strong> <?php echo htmlspecialchars($prescription->near_add_od); ?>
                    </td>
                    <td width="20%" class="section-title">PD</td>
                    <td width="30%">
                        <strong>OD</strong> <?php echo htmlspecialchars($prescription->pd_od); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <strong>OS</strong> <?php echo htmlspecialchars($prescription->near_add_os); ?>
                    </td>
                    <td></td>
                    <td>
                        <strong>OS</strong> <?php echo htmlspecialchars($prescription->pd_os); ?>
                    </td>
                </tr>
            </table>

            <!-- Remarks -->
            <div class="remarks compact-row">
                <strong>Remarks</strong> <span
                    class="empty-field"><?php echo htmlspecialchars($prescription->remarks); ?></span><br>
                <em>(Please preserve this card for future reference.)</em>
            </div>

            <div class="divider"></div>

            <!-- Visual Wardrobe -->
            <div class="visual-wardrobe">
                <div class="wardrobe-title">Visual Wardrobe</div>

                <!-- Single Vision Row -->
                <table class="wardrobe-table compact-row">
                    <tr>
                        <td width="20%" class="category">Single Vision</td>
                        <td width="20%">Distance</td>
                        <td width="20%">Intermediate</td>
                        <td width="20%">Near</td>
                        <td width="20%"></td>
                    </tr>
                </table>

                <!-- Bifocal Row -->
                <table class="wardrobe-table compact-row">
                    <tr>
                        <td width="20%" class="category">Bifocal</td>
                        <td width="20%">Flat Top</td>
                        <td width="20%">Round Top</td>
                        <td width="20%">Executive</td>
                        <td width="20%"></td>
                    </tr>
                </table>

                <!-- Progressive Row -->
                <table class="wardrobe-table compact-row">
                    <tr>
                        <td width="20%" class="category">Progressive</td>
                        <td width="80%" colspan="4">
                            <strong>Corridor</strong>
                            <span class="checkbox-option">□ Far</span>
                            <span class="checkbox-option">□ Intermediate</span>
                            <span class="checkbox-option">□ Near</span>
                            <span class="checkbox-option">□ Balanced</span>
                        </td>
                    </tr>
                </table>

                <!-- Lens Options Table -->
                <table class="wardrobe-table compact-row">
                    <tr>
                        <td width="50%">
                            Ego (HC/HMC)<br>
                            Ego Free Form (HMC/Photochromic)<br>
                            Ego Free Form (High Index) □ 1.67<br>
                            Mr. Blue □ 1.56 □ 1.67<br>
                            Mr. Blue (UV Cut with Photochromic)<br>
                            Mr. Blue* □ 1.56 □ 1.67<br>
                            Mr. Blue* (UV Cut with Photochromic)<br>
                            Zion □ 1.56 □ 1.67
                        </td>
                        <td width="50%">
                            Zion (Photochromic)<br>
                            Tokai (Japan) USC, MSC, SPS & TBC<br>
                            Rodenstock (Germany)<br>
                            Ego Cataract Lens<br>
                            Myopia Control Lens<br>
                            Ortho K Lens<br>
                            Ego Tinted Lens / Sunglass<br>
                            Ego/Bionix Disposable Contact Lens
                        </td>
                    </tr>
                </table>

                <!-- Selected Lens -->
                <div class="lens-selection compact-row">
                    <div class="selected-lens">Selected Lens: <?php echo htmlspecialchars($prescription->lens_type); ?>
                    </div>
                </div>
            </div>

            <!-- Next Examination -->
            <div class="examination-advised compact-row">
                <strong>Next examination advised:</strong>
                <span class="checkbox-option">□ 1</span>
                <span class="checkbox-option">□ 2</span>
                <span class="checkbox-option">□ 3</span>
                <span class="checkbox-option">□ 6 month</span>
                <?php
                $next_exam = $prescription->next_examination;
                if ($next_exam == '1')
                    echo '<strong style="margin-left: 10px;">[✓ 1]</strong>';
                elseif ($next_exam == '2')
                    echo '<strong style="margin-left: 10px;">[✓ 2]</strong>';
                elseif ($next_exam == '3')
                    echo '<strong style="margin-left: 10px;">[✓ 3]</strong>';
                elseif ($next_exam == '6')
                    echo '<strong style="margin-left: 10px;">[✓ 6 month]</strong>';
                ?>
            </div>

            <div class="divider"></div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-line"></div>
                <div>Doctor Seal</div>
                <div>Signature</div>
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