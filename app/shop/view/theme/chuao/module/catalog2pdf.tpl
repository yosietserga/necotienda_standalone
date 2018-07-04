<li nt-editable="1" class="catalogtopdf-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

<!-- cart-widget-content -->
    <div class="widget-content catalogtopdf-widget-content" id="<?php echo $widgetName; ?>Content">
        <a href="<?php echo str_replace("&","&amp;",$href); ?>" title="<?php echo $Language->get('text_download_pdf'); ?>" class="button"><?php echo $Language->get('text_download_pdf'); ?></a>
    </div>
<!-- /cart-widget-content -->
</li>
