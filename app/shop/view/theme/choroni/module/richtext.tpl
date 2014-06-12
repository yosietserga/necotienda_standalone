<li class="nt-editable box richtextWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
<div class="content" id="<?php echo $widgetName; ?>Content"><?php echo html_entity_decode($page['description']); ?></div>
    <div class="clear"></div><br />
</li>