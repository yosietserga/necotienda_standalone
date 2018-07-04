<li id="<?php echo $widgetName; ?>" class="banner carousel<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable">
<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content"></div>
<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName; ?>Content',
            config:{
                url:'<?php echo Url::createUrl("module/". $settings['module'] ."/carousel"); if ((int)$settings['banner_id']) echo '&banner_id='.(int)$settings['banner_id'] ?>',
                image: {
                  width:<?php echo (int)$settings['width']; ?>,
                  height:<?php echo (int)$settings['height']; ?>
                },
                loading: {
                  image: '<?php echo HTTP_IMAGE; ?>loader.gif'
                }
                <?php if ($settings['scroll']) { ?>,
                options: {
                    scroll: <?php echo (int)$settings['scroll']; ?>
                }
                <?php } else { ?>,
                options: {
                    scroll: 4
                }
                <?php } ?>
            },
            plugin:'ntContentCarousel'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>