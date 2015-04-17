<?php if($products) { ?>
<li class="nt-editable featuredhome-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

<!-- featuredhome-title -->
    <?php if ($heading_title) { ?>
        <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="heading-icon icon icon-star">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/star-full.tpl"); ?>
                    </i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
<!-- /featuredhome-title -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/sort.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/pagination.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/blockgrid-start.tpl"); ?>

    <?php foreach($products as $product) { ?>
        <li>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-picture.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-info.tpl"); ?>
        </li>
    <?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/blockgrid-end.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/pagination.tpl"); ?>
</li>
<script>
$(function() {
    $("#<?php echo $widgetName; ?>List img").lazyload();
});
</script>
<?php } ?>