<div id="adminTopNav">
    <a id="simple-menu" href="#sidr" style="margin:5px 10px;float:left;"><i class="fa fa-bars fa-2x" style="color:#fff"></i></a>
    <a>
        Menu
        <ul>
            <li>
                <a href="<?php echo $Url::createAdminUrl('store/product/insert', [], 'NONSSL', HTTP_ADMIN); ?>"></a>
                <a href="<?php echo $Url::createAdminUrl('content/page/insert', [], 'NONSSL', HTTP_ADMIN); ?>"></a>
                <a href="<?php echo $Url::createAdminUrl('content/post/insert', [], 'NONSSL', HTTP_ADMIN); ?>"></a>
                <a href="<?php echo $Url::createAdminUrl('store/manufacturer/insert', [], 'NONSSL', HTTP_ADMIN); ?>"></a>
                <a href="<?php echo $Url::createAdminUrl('store/category/insert', [], 'NONSSL', HTTP_ADMIN); ?>"></a>
                <a href="<?php echo $Url::createAdminUrl('content/post_category/insert', [], 'NONSSL', HTTP_ADMIN); ?>"></a>
            </li>
        </ul>
    </a>
</div>

<div id="simpleMenu" class="sidr left" style="display: none;">
    <a class="closeSidePanel"><i class="fa fa-times"></i>Cerrar</a>
    <form id="cssDataWrapper"></form>

    <div class="panel-lateral" id="style">
        <div class="panel-lateral-tabs">
            <?php if ($_GET['theme_editor']) { ?><span data-tab="tabThemeConfigurator">Editor CSS</span><?php } ?>
            <span data-tab="tabWidgetConfigurator">Widgets</span>
        </div>
        <div class="clear"></div><hr />

        <?php if ($_GET['theme_editor']) { ?>
        <div class="panel-lateral-tab" id="tabThemeConfigurator">
        <?php require_once('admin-theme-configurator.tpl'); ?>
        </div>
        <?php } ?>
        
        <div class="panel-lateral-tab" id="tabWidgetConfigurator">
        <?php require_once('admin-widget-configurator.tpl'); ?>
        </div>
    </div>
</div>
<div id="jsWrapper"></div>
<script>
$(function() {
    if (!$.fn.sidr) {
        $(document.createElement('script')).attr({
            src:'/assets/js/vendor/jquery.sidr.min.js',
            type:'text/javascript'
        }).appendTo('#jsWrapper');
    }
    if ($('link[href="/assets/css/jquery.sidr.css"]').length === 0) {
        $(document.createElement('link')).attr({
            href:'/assets/css/jquery.sidr.css',
            rel:'stylesheet'
        }).appendTo('head');
    }
    
    $('#simple-menu').sidr({
        name:'simpleMenu'
    });
    
    $('.closeSidePanel').on('click', function(){
        $.sidr('close', 'simpleMenu');
    });
    
    if (Modernizr.touch) {
        if (!$.fn.touchwipe) {
            $(document.createElement('script')).attr({
                src:'/assets/js/vendor/jquery.touchwipe.min.js',
                type:'text/javascript'
            }).appendTo('#jsWrapper');
        }
        $(window).touchwipe({
            wipeLeft: function() {
              $.sidr('close', 'simple-menu');
            },
            wipeRight: function() {
              $.sidr('open', 'simple-menu');
            },
            preventDefaultEvents: false
        });
    }
});
</script>
<script>    
function image_upload() {
    var height = $(window).height() * 0.8;
    var width = $(window).width() * 0.8;
                
    $('#dialog').remove();
    $('#mainbody').append('<div id="dialog" style="padding: 3px 0px 0px 0px;z-index:10000;"><iframe src="<?php echo $Url::createAdminUrl('common/filemanager',array('theme_editor'=>1,'field'=>'backgroundImage'),'NONSSL',HTTP_ADMIN); ?>&field=backgroundImage" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;z-index:10000" frameborder="no" scrolling="auto"></iframe></div>');

    $('#dialog').dialog({
        title: '<?php echo $Language->get('text_image_manager'); ?>',
        close: function (event, ui) {
            if ($('#backgroundImage').val()) {
                $('#backgroundImage').val('<?php echo HTTP_IMAGE; ?>'+ $('#backgroundImage').val());
                setStyle();
            }
        },	
        bgiframe: false,
        width: width,
        height: height,
        resizable: false,
        modal: false
    });
}
</script>