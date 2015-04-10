<li class="nt-editable bannerWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?>
    <div class="header" id="<?php echo $widgetName; ?>Header">
        <h1><?php echo $heading_title; ?></h1>
    </div>
<?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="widget-content" id="<?php echo $widgetName; ?>Content">
    <div class="camera_wrap camera" id="<?php echo $widgetName; ?>camera">
    <?php foreach ($banner['items'] as $item) { ?>

        <?php if (empty($item['image'])) continue; ?>

        <div data-thumb="<?php echo $Image->resizeAndSave($item['image'],50,50); ?>" data-src="<?php echo HTTP_IMAGE . $item['image']; ?>">
            <div class="camera_caption fadeIn">
                <strong class="camera_caption_text break"><?php echo $item['description']; ?></strong>
                <?php if (!empty($item['link'])) { ?>
                    <div class="action-button">
                        <a class="camera_caption_link" href="<?php echo $item['link']; ?>">Leer más</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
</li>
<script>
if (!$.fx.camera) {
    $(document.createElement('link')).attr({
        'href':'<?php echo HTTP_CSS; ?>sliders/camera-v1.3.4/slider.css',
        'rel':'stylesheet',
        'media':'screen'
    }).appendTo('head');
    $(document.createElement('script')).attr({
        'src':'<?php echo HTTP_JS; ?>sliders/camera-v1.3.4/jquery.mobile.customized.min.js',
        'type':'text/javascript',
    }).appendTo('head');
    $(document.createElement('script')).attr({
        'src':'<?php echo HTTP_JS; ?>sliders/camera-v1.3.4/slider.js',
        'type':'text/javascript',
    }).appendTo('head');
}

$(function(){
    $('#<?php echo $widgetName; ?>camera').camera({
        thumbnails: true,
        fx: 'simpleFade',
        loader: 'none',
        autoAdvance: false,
        barPosition: 'left',
        height: '867px',
        navigation: false,
    });
});
</script>
<?php } ?>
