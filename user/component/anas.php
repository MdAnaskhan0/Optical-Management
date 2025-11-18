<?php if (!empty($lenses_by_category)): ?>
    <table class="wardrobe-table compact-row">
        <tr>
            <td width="50%">
                <?php
                // Display first half of categories and lenses
                $half_categories = array_slice($lenses_by_category, 0, ceil(count($lenses_by_category) / 2));
                foreach ($half_categories as $category_name => $category_lenses):
                    if (!empty($category_lenses)):
                        ?>
                        <div class="lens-category"><?php echo htmlspecialchars($category_name); ?></div>
                        <?php foreach ($category_lenses as $lens): ?>
                            <div class="lens-item">
                                <?php echo htmlspecialchars($lens['name']); ?>
                                <?php if (!empty($lens['description'])): ?>
                                    <small>(<?php echo htmlspecialchars($lens['description']); ?>)</small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php
                    endif;
                endforeach;
                ?>
            </td>
            <td width="50%">
                <?php
                // Display second half of categories and lenses
                $half_categories = array_slice($lenses_by_category, ceil(count($lenses_by_category) / 2));
                foreach ($half_categories as $category_name => $category_lenses):
                    if (!empty($category_lenses)):
                        ?>
                        <div class="lens-category"><?php echo htmlspecialchars($category_name); ?></div>
                        <?php foreach ($category_lenses as $lens): ?>
                            <div class="lens-item">
                                <?php echo htmlspecialchars($lens['name']); ?>
                                <?php if (!empty($lens['description'])): ?>
                                    <small>(<?php echo htmlspecialchars($lens['description']); ?>)</small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php
                    endif;
                endforeach;
                ?>
            </td>
        </tr>
    </table>
<?php else: ?>
    <div style="text-align: center; padding: 10px; font-size: 10px; color: #666;">
        No lens categories available
    </div>
<?php endif; ?>