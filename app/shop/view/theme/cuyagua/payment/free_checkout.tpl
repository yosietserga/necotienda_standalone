<div class="heading widget-heading featured-heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div onclick="$('#freeCheckoutGuide').slideToggle();" class="heading-title">
        <h3>
            <i class="heading-icon icon icon-gift">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/gift.tpl"); ?>
            </i>
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="guide break" id="freeCheckoutGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
</div>

<script type="text/javascript">
$(function(){
    if (!jQuery().ntForm) {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>necojs/neco.form.js',
            'type':'text/javascript'
        }).appendTo('body');
    }
    if (typeof jQuery.ui == 'undefined') {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>vendor/jquery-ui.min.js',
            'type':'text/javascript'
        }).appendTo('body');
    }
});
</script>
