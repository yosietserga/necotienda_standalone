<li nt-editable="1" class="box lightboxWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php include("lightbox_". $settings['view'] .'.tpl'); ?>
</li>
<script>
    $(function() {
        var style = $('<style>').text(
            '#<?php echo $widgetName; ?>,' +
            '#<?php echo $widgetName; ?>:before ' +
            '{' +
                'background:<?php echo $necoTool->hex2rgba($settings["background"], $settings["opacity"]); ?>; !important' +
            '}'
        ).appendTo('head');
    });
</script>