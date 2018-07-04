<?php echo $header; ?>

<!--contentContainer -->
<div id="contentContainer" class="tpl-home" nt-editable>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-featured.tpl");?>

    <!--mainContentContainer -->
    <div id="mainContentContainer" nt-editable>
        <div class="row">

            <!-- left-column -->
            <?php if ($column_left) { ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-column-left.tpl");?>
            <?php } ?>
            <!--/left-column -->

            <!--center-column -->
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-column-center.tpl");?>
            <!--/center-column -->

            <!-- right-column -->
            <?php if ($column_right) { ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-column-right.tpl");?>
            <?php } ?>
            <!--/right-column -->

        </div>
    </div>
    <!--/mainContentContainer -->

    <!--featuredFooterContainer -->
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-featured-footer.tpl");?>
    <!--/featuredFooterContainer -->

</div>
<!--/contentContainer -->

<?php echo $footer; ?>