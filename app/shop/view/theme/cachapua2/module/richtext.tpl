<li data-widget="rich-text" class="nt-editable richtextWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) { ?>
        <div class="heading" id="<?php echo $widgetName; ?>Header">
            <div class="heading-icon">
                <i class="fa fa-bookmark fa-2x"></i>
            </div>
            <div class="heading-title">
                <h3>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
    <div class="widget-content" id="<?php echo $widgetName; ?>Content"><?php echo html_entity_decode($page['description']); ?></div>
</li>