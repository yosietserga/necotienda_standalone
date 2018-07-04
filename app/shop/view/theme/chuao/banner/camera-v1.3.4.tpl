
<li id="<?php echo $widgetName; ?>" class="banner camera<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="cameraSlider">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content">
    <div class="camera_wrap camera_ash_skin" id="<?php echo $widgetName; ?>camera">
    <?php foreach ($banner['items'] as $item) { ?>
        <?php if (!empty($item['image'])) { ?>
            <div data-thumb="<?php echo $Image->resizeAndSave($item['image'],285,115); ?>" data-src="<?php echo HTTP_IMAGE . $item['image']; ?>">
                <?php if (!empty($item['description'])) { ?>
                    <div class="camera_caption fadeIn">
                        <h1><a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></h1>
                        <p><?php echo $item['description']; ?></p>
                        <?php if (!empty($item['link'])) { ?>
                            <a class="read-more" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">Más detalles</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?> 
    <?php } ?>
    </div>
</div>

<script id="cameraPlugin">
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName; ?>camera',
            config:{
                navigation: false,
                navigationHover: false,
                playPause: false,
                pagination: true
            },
            plugin:'camera'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>
