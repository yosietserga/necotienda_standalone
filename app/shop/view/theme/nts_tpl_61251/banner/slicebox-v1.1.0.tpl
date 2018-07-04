<li id="<?php echo $widgetName; ?>" class="banner slicebox<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="sliceBox">

<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content">
    <ul id="<?php echo $widgetName; ?>slicebox" class="sb-slider">
    <?php foreach ($banner['items'] as $item) { ?>
        <?php if (empty($item['image'])) continue; ?>
        <li>
            <?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php } ?>
            <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" />
            <?php if (!empty($item['link'])) { ?></a><?php } ?>
            <?php if (!empty($item['title']) || !empty($item['description'])) { ?>
            <div class="sb-description">
                <?php if (!empty($item['title'])) { echo '<h3>'. $item['title'] .'</h3>'; } ?>
                <?php if (!empty($item['description'])) { echo '<em>'. htmlentities($item['description']) .'</em>'; } ?>"
            </div>
            <?php } ?>
        </li>
    <?php } ?>
    </ul>

    <div id="<?php echo $widgetName; ?>nav-arrows" class="nav-arrows">
        <a href="#">Next</a>
		<a href="#">Previous</a>
    </div>

    <div id="<?php echo $widgetName; ?>nav-dots" class="nav-dots">
        <?php foreach ($banner['items'] as $item) { ?>
        <span></span>
        <?php } ?>
    </div>

</div>
<div class="clear"></div><br />
<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];
        
        ntPlugins.push({
            id:"#<?php echo $widgetName; ?>slicebox",
            config:{
                onReady: function(){
                    $('#<?php echo $widgetName; ?>nav-arrows').show();
                    $('#<?php echo $widgetName; ?>nav-dots').show();
                    $('#<?php echo $widgetName; ?>nav-options').show();
                },
                onBeforeChange: function(pos){
                    $('#<?php echo $widgetName; ?>nav-options').children('span').removeClass('nav-dot-current');
                    $('#<?php echo $widgetName; ?>nav-options').children('span').eq(pos).addClass('nav-dot-current');
                },
                orientation: 'r',
                cuboidsRandom: true
            },
            plugin:'slicebox',
            fn: function(slider, el){
                
                $('#<?php echo $widgetName; ?>nav-arrows').children(':first').on('click', function(){
                    slider.next();
                    return false;
                });
                
                $('#<?php echo $widgetName; ?>nav-arrows').children(':last').on('click', function(){
                    slider.previous();
                    return false;
                });
                
                $('#<?php echo $widgetName; ?>nav-options').children('span').each(function(i){
                    $(this).on('click', function (event) {
                        var $dot = $(this);
                        if (!slider.isActive()) {
                            $('#<?php echo $widgetName; ?>nav-options').children('span').removeClass('nav-dot-current');
                            $dot.addClass('nav-dot-current');
                        }
                        slider.jump(i + 1);
                        return false;
                    });
                });
                
                $('#<?php echo $widgetName; ?>navPlay').on('click', function () {
                    slider.play();
                    return false;
                });
                
                $('#<?php echo $widgetName; ?>navPause').on('click', function () {
                    slider.pause();
                    return false;
                });
                
                slider.play();
            }
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>