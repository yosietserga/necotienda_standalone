<li id="<?php echo $widgetName; ?>" class="banner camera<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="cameraSlider">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content">
    <div id="<?php echo $widgetName; ?>jssorPlugin" class="jssorContainer">
    
        <div data-u="loading">
            <div></div>
            <div></div>
        </div>
        
        <div data-u="slides">
        <?php foreach ($banner['items'] as $item) { ?>
            <?php if (!empty($item['image'])) { ?>
                <div>
                    <img data-u="image" src="<?php echo HTTP_IMAGE . $item['image']; ?>" />
                    <div data-u="thumb">
                        <img class="i" src="<?php echo $Image->resizeAndSave($item['image'],80,50); ?>" />
                        <?php if (!empty($item['title'])) { ?><div class="t"><?php echo $item['title']; ?></div><?php } ?>
                        <?php if (!empty($item['description'])) { ?><div class="c"><?php echo $item['description']; ?></div><?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        </div>
    
    
        <!-- Thumbnail Navigator -->
        <div data-u="thumbnavigator" class="jssort11" data-autocenter="2">
            <!-- Thumbnail Item Skin Begin -->
            <div data-u="slides">
                <div data-u="prototype" class="p">
                    <div data-u="thumbnailtemplate" class="tp"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        
        
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora02l" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora02r" data-autocenter="2"></span>
    </div>
</div>

<script id="jssorPlugin">
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName; ?>jssorPlugin',
            config:{
                $AutoPlay: true,
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$
                },
                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,
                    $Cols: 4,
                    $SpacingX: 4,
                    $SpacingY: 4,
                    $Orientation: 2,
                    $Align: 0
                }
            },
            plugin:'jssorPlugin'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>
