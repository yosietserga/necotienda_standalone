<!--footerContainer -->
<div id="footerContainer" nt-editable>

    <!--footer -->
    <div id="footer" nt-editable>
        <?php $position = 'footer'; ?>
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
    <!--/footer -->

    <!-- terms -->
    <div id="copyright" nt-editable>
        <div class="row">
            <div class="medium-7 column">
                <?php echo $text_powered_by; ?>
            </div>
        </div>
    </div>
    <!-- /terms -->

<!--/footerContainer -->
</div>

<?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/fragment/footer-start.tpl"); ?>

<!--/mainContainer -->
</div><!--closing tag for <div id="mainContainer"> in header.tpl-->
</body>
</html>