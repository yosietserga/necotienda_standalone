<?php echo $header; ?>
<?php echo $navigation; ?>

<!--contentContainer -->
<div id="contentContainer" nt-editable>

    <!--featuredContentContainer -->
    <div id="featuredContentContainer" nt-editable>
        <?php $position = 'featuredContent'; ?>
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
    <!--/featuredContentContainer -->

    <!--mainContentContainer -->
    <div id="mainContentContainer" nt-editable>
        <div class="row">

            <!-- left-column -->
            <?php if ($column_left) { ?>
            <div class="large-3 columns">
                <div id="columnLeft" nt-editable>
                    <?php $position = 'column_left'; ?>
                    <?php foreach($rows[$position] as $j => $row) { ?>
                    <?php if (!$row['key']) continue; ?>
                    <?php $row_id = $row['key']; ?>
                    <?php $row_settings = unserialize($row['value']); ?>
                    <div class="row" id="<?php echo $position; ?>_<?php echo $row_id; ?>">
                        <?php foreach($row['columns'] as $k => $column) { ?>
                        <?php if (!$column['key']) continue; ?>
                        <?php $column_id = $column['key']; ?>
                        <?php $column_settings = unserialize($column['value']); ?>
                        <div class="large-<?php echo $column_settings['grid_large']; ?> medium-<?php echo $column_settings['grid_medium']; ?> small-<?php echo $column_settings['grid_small']; ?>" id="<?php echo $position; ?>_<?php echo $column_id; ?>">
                            <ul class="widgets">
                                <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget['name']; ?>%} <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <!--/left-column -->

            <!--center-column-->
            <?php if ($column_left && $column_right) { ?>
            <div class="large-6 columns">
            <?php } elseif ($column_left || $column_right) { ?>
            <div class="large-9 columns">
            <?php } else { ?>
            <div class="large-12">
            <?php } ?>
                <div id="columnCenter" nt-editable>
                    <?php $position = 'main'; ?>
                    <?php foreach($rows[$position] as $j => $row) { ?>
                    <?php if (!$row['key']) continue; ?>
                    <?php $row_id = $row['key']; ?>
                    <?php $row_settings = unserialize($row['value']); ?>
                    <div class="row" id="<?php echo $position; ?>_<?php echo $row_id; ?>">
                        <?php foreach($row['columns'] as $k => $column) { ?>
                        <?php if (!$column['key']) continue; ?>
                        <?php $column_id = $column['key']; ?>
                        <?php $column_settings = unserialize($column['value']); ?>
                        <div class="large-<?php echo $column_settings['grid_large']; ?> medium-<?php echo $column_settings['grid_medium']; ?> small-<?php echo $column_settings['grid_small']; ?>" id="<?php echo $position; ?>_<?php echo $column_id; ?>">
                            <ul class="widgets">
                                <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget['name']; ?>%} <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!--/center-column -->

            <!-- right-column -->
            <?php if ($column_right) { ?>
            <div class="large-3 columns">
                <div id="columnRight" nt-editable>
                <?php echo $column_right; ?>
                </div>
            </div>
            <?php } ?>
            <!--/right-column -->

        </div>
    </div>
    <!--/mainContentContainer -->

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

</div>
<!--/contentContainer -->

<?php echo $footer; ?>