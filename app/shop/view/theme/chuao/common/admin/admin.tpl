<div id="adminTools">
    <div id="adminTopNav">
            <ul>
                <?php if ($is_admin && $_GET['theme_editor']) { ?>
                <li>
                    <a id="showAdminPanel" href="#sidr" onclick="if (!$.fn.sidr) return false;"><img src="<?php echo HTTP_IMAGE; ?>icons/color/palette.png" /></a>
                </li>
                <?php } ?>
                <li class="dd">
                    <span><?php echo $Language->get('text_create'); ?> &darr;</span>
                    <ul class="menu_body">
                        <li><a href="<?php echo $create_product; ?>" title="<?php echo $Language->get('text_create_product'); ?>"><?php echo $Language->get('text_create_product'); ?></a></li>
                        <li><a href="<?php echo $create_page; ?>" title="<?php echo $Language->get('text_create_page'); ?>"><?php echo $Language->get('text_create_page'); ?></a></li>
                        <li><a href="<?php echo $create_post; ?>" title="<?php echo $Language->get('text_create_post'); ?>"><?php echo $Language->get('text_create_post'); ?></a></li>
                        <li><a href="<?php echo $create_manufacturer; ?>" title="<?php echo $Language->get('text_create_manufacturer'); ?>"><?php echo $Language->get('text_create_manufacturer'); ?></a></li>
                        <li><a href="<?php echo $create_product_category; ?>" title="<?php echo $Language->get('text_create_category'); ?>"><?php echo $Language->get('text_create_category'); ?></a></li>
                        <li><a href="<?php echo $create_post_category; ?>" title="<?php echo $Language->get('text_create_post_category'); ?>"><?php echo $Language->get('text_create_post_category'); ?></a></li>
                    </ul>
                </li>
            </ul>
    </div>
    
    <form id="cssDataWrapper"></form>
    
    <?php if ($is_admin) { ?>
    
    <div class="panel-lateral" id="sidr" style="display: block; left: 0px;">
        <div class="panel-lateral-tabs">
            <?php if ($_GET['theme_editor']) { ?><span data-tab="tabThemeConfigurator">Editor CSS</span><?php } ?>
            <span>Configurar</span>
            <span>Widgets</span>
        </div>
        
        <?php if ($_GET['theme_editor']) { ?>
        <div class="panel-lateral-tab" id="tabThemeConfigurator"></div>
        <?php require_once('admin-theme-configurator.tpl'); ?>
        <?php } ?>
        
    </div>
</div>
<script>
function image_upload() {
    var height = $(window).height() * 0.8;
    var width = $(window).width() * 0.8;
                
    $('#dialog').remove();
    $('#mainbody').append('<div id="dialog" style="padding: 3px 0px 0px 0px;z-index:10000;"><iframe src="<?php echo $Url::createAdminUrl('common/filemanager',array(),'NONSSL',HTTP_ADMIN); ?>&field=backgroundImage" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;z-index:10000" frameborder="no" scrolling="auto"></iframe></div>');

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
    <?php } ?>