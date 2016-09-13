<div class="heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div onclick="$('#freeCheckoutGuide').slideToggle();" class="heading-title">
        <h3> 
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="guide break" id="freeCheckoutGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
</div>

