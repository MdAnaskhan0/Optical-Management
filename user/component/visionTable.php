<table class="prescription-table">
    <thead>
        <tr>
            <th colspan="5">RIGHT EYE</th>
            <th colspan="5">LEFT EYE</th>
        </tr>
        <tr>
            <th width="10%"></th>
            <th width="9%">SPH</th>
            <th width="9%">CYL</th>
            <th width="9%">AXIS</th>
            <th width="9%">V/A</th>
            <th width="10%"></th>
            <th width="9%">SPH</th>
            <th width="9%">CYL</th>
            <th width="9%">AXIS</th>
            <th width="9%">V/A</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="table-section-title">Distance</td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_sph ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_cyl ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_axis ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_va ?? '-'); ?></td>
            <td class="table-section-title">Distance</td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_sph ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_cyl ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_axis ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_va ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="table-section-title">Reading</td>
            <td class="value-cell">
                <?php
                $od_reading = '';
                if (!empty($prescription->near_add_od) && !empty($prescription->od_sph)) {

                    $od_reading = floatval($prescription->near_add_od) + floatval($prescription->od_sph);

                    // Format with two decimals
                    $formatted = number_format($od_reading, 2);

                    // Add + sign for positive values
                    if ($od_reading > 0) {
                        $formatted = '+' . $formatted;
                    }

                    echo htmlspecialchars($formatted);
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_cyl ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_axis ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->od_va ?? '-'); ?></td>
            <td class="table-section-title">Reading</td>
            <td class="value-cell">
                <?php
                $os_reading = '';
                if (!empty($prescription->near_add_os) && !empty($prescription->os_sph)) {

                    $os_reading = floatval($prescription->near_add_os) + floatval($prescription->os_sph);

                    // Format with two decimals
                    $formatted = number_format($os_reading, 2);

                    // Add + sign for positive values
                    if ($os_reading > 0) {
                        $formatted = '+' . $formatted;
                    }

                    echo htmlspecialchars($formatted);
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_cyl ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_axis ?? '-'); ?></td>
            <td class="value-cell"><?php echo htmlspecialchars($prescription->os_va ?? '-'); ?></td>
        </tr>
    </tbody>
</table>