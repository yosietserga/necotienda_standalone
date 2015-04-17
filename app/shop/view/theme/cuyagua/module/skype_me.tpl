<li class="nt-editable skypeme-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php if ($heading_title) { ?>
        <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetname; ?>header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-skype fa-2x"></i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
    <div class="widget-content" id="<?php echo $widgetName; ?>Content">
        <?php echo $skype_me; ?>
    </div>
</li>
