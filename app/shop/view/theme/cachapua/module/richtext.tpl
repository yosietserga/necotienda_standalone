<li class="nt-editable box richtextWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) { ?>
        <div class="header" id="<?php echo $widgetName; ?>Header"><h3><?php echo $heading_title; ?></h3></div>
    <?php } ?>
    <div class="widget-content" id="<?php echo $widgetName; ?>Content"><?php echo html_entity_decode($page['description']); ?></div>
</li>