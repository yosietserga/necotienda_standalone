<!-- catalog-latest -->
<?php if($products) { ?>
<li nt-editable="1" class="widget-product-list widget-product-list-<?php echo $settings['view']; ?> widget-product-list-home productListWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>
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
<!-- /catalog -->
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/scripts/quickview-deps.tpl"); ?>
<?php } ?>
