<li class="nt-editable box lightboxWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <span<?php if ($settings['width'] || $settings['height']) { ?> style="<?php echo ($settings['width']) ? "width:".$settings['width'] : ""; ?>;<?php echo ($settings['height']) ? "height:".$settings['height'] : ""; ?>"<?php } ?>>
    
        <?php if ($heading_title) { ?>
        <div class="header" id="<?php echo $widgetName; ?>Header">
            <hgroup>
                <h1><?php echo $heading_title; ?></h1>
            </hgroup>
        </div>
        <?php } ?>
        
        <div class="content" id="<?php echo $widgetName; ?>Content">
            <?php echo html_entity_decode($page['description']); ?>
        </div>
        
    </span>
    
    <div class="close">X</div>
    
</li>
<script>
$(function(){
    $('#<?php echo $widgetName; ?> .close').on('click',function(){
        $('#<?php echo $widgetName; ?>').remove();
    });
    
    $('body').on('click', function(e) {
        var target = $(e.target);
        if(target.is('#<?php echo $widgetName; ?>')) {
           if ( $('#<?php echo $widgetName; ?>').is(':visible') ) $('#<?php echo $widgetName; ?>').remove();
        }
    });
    
    if (getCookie('<?php echo $widgetName; ?>')) {
        $('#<?php echo $widgetName; ?>').remove();
    }
    
    lightBoxWindowResize();
    
    $(window).resize(function() {
        lightBoxWindowResize();
    });
});

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

function lightBoxWindowResize() {
    var width  = (window.innerWidth - $('#<?php echo $widgetName; ?> span').width() - 100) / 2;
    var height = (window.innerHeight - $('#<?php echo $widgetName; ?> span').height() - 100) / 2;
    
    $('#<?php echo $widgetName; ?> span').css({
        'marginTop': height +'px',
        'marginLeft': width +'px'
    });
    
    var closeX = window.innerWidth - width - 100;
    var closeY = height - 10;
    
    $('#<?php echo $widgetName; ?> .close').css({
        'top': closeY +'px',
        'left': closeX +'px'
    });
}
</script>