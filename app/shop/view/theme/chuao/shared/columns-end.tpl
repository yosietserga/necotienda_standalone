    </div>
</aside>
<!--/COLUMN-CENTER-->
<!--COLUMN-RIGHT-->
<?php if ($column_right) { ?>
    <aside id="column_right" class="column-right large-3 column">
        <div class="widgets aside-column">
            <?php echo $column_right; ?>
        </div>
    </aside>
<?php } ?>
</section>

<?php if($featuredFooterWidgets) { ?>

    <!--featuredFooterContainer -->
    <div id="featuredFooterContainer" nt-editable>
    <?php $position = 'featuredFooter'; ?>
    <?php foreach($rows[$position] as $j => $row) { ?>
        <?php if (!$row['key']) continue; ?>
        <?php $row_id = $row['key']; ?>
        <?php $row_settings = unserialize($row['value']); ?>
        <div class="row" id="<?php echo $position; ?>_<?php echo $row_id; ?>" nt-editable>
        <?php foreach($row['columns'] as $k => $column) { ?>
            <?php if (!$column['key']) continue; ?>
            <?php $column_id = $column['key']; ?>
            <?php $column_settings = unserialize($column['value']); ?>
            <div class="large-<?php echo $column_settings['grid_large']; ?> medium-<?php echo $column_settings['grid_medium']; ?> small-<?php echo $column_settings['grid_small']; ?>" id="<?php echo $position; ?>_<?php echo $column_id; ?>" nt-editable>
                <ul class="widgets">
                    <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget['name']; ?>%} <?php } ?>
                </ul>
            </div>
        <?php } ?>
        </div>
    <?php } ?>
    </div>
    <!--/featuredFooterContainer -->

<?php } ?>
<!--/COLUMN-RIGHT-->
