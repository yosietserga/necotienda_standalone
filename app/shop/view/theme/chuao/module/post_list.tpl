<li nt-editable="1" class="post_list-widget post_list_<?php echo $settings['view']; ?>-widget <?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php include("post_list_". $settings['view'] .'.tpl'); ?>
</li>