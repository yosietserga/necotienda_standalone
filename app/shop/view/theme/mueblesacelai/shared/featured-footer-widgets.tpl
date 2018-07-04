<!--featuredFooterContainer -->
<div id="featuredFooterContainer" nt-editable>
    <?php $position = 'featuredFooter'; ?>
    <?php foreach($rows[$position] as $j => $row) { ?>
    <div class="row" id="<?php echo $position; ?>_container_<?php echo $j; ?>" nt-editable>
        <?php foreach($row['columns'] as $k => $column) { ?>
        <div class="medium-<?php echo $column['column']; ?>" id="<?php echo $position; ?>_column_<?php echo $j ."_". $k; ?>" nt-editable>
        <ul class="widgets">
            <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget; ?>%} <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div>
<?php } ?>
</div>
<!--/featuredFooterContainer -->
