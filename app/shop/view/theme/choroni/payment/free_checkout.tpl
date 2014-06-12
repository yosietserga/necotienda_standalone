<div class="grid_2" onclick="$('#freeCheckoutGuide').slideToggle();">
    <?php if ($Config->get('free_checkout_image')) { ?><img src="<?php echo $Image::resizeAndSave($Config->get('free_checkout_image'),90,90); ?>" alt="Gratis" /><?php } ?>
</div>

<div class="grid_6">
    <h3 onclick="$('#freeCheckoutGuide').slideToggle();"><?php echo $Language->get('text_title'); ?></h3>
</div>

<div class="grid_2">
    <a onclick="$('#freeCheckoutGuide').slideToggle();" title="<?php echo $Language->get('button_pay'); ?>" id="freeCheckoutCheckout" class="button"><?php echo $Language->get('button_pay'); ?></a>
</div>

<div class="clear"></div>

<div class="guide" id="freeCheckoutGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
</div>
    
<div class="clear"></div>

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
