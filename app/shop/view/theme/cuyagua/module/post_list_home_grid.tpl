<?php if($posts) { ?>
<!-- post-list -->
<li class="nt-editable widget-post-list-<?php echo $settings['func']; ?> widget-post-list-<?php echo $settings['view']; ?> widget-post-grid-home postListWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/sort.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/pagination.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/blockgrid-start.tpl"); ?>

    <?php foreach($posts as $post) { ?>
<li class="catalog-item">
    <?php if (isset($post['thumb'])) include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/post-picture.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/post-info.tpl"); ?>
</li>
<?php } ?>

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/blockgrid-end.tpl"); ?>
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/pagination.tpl"); ?>
</li>
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/scripts/quickview-deps.tpl"); ?>
<!-- /post-list -->
<?php } ?>