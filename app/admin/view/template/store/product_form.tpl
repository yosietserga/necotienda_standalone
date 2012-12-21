<?php echo $header; ?>
<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
<div class="box">
    <h1><?php echo $heading_title; ?></h1>
    <div class="buttons">
        <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $button_save_and_exit; ?></a>
        <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $button_save_and_keep; ?></a>
        <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $button_save_and_new; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
    </div>
        
    <div class="clear"></div>
                                
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div class="htabs product_tabs">
            <a data-target="#general" class="htab"><?php echo $tab_general; ?></a>
            <a data-target="#data" class="htab"><?php echo $tab_data; ?></a>
            <a data-target="#links" class="htab"><?php echo $tab_links; ?></a>
            <a data-target="#discount" class="htab"><?php echo $tab_discount; ?></a>
            <a data-target="#special" class="htab"><?php echo $tab_special; ?></a>
            <a data-target="#option" class="htab"><?php echo $tab_option; ?></a>
            <a data-target="#images" class="htab"><?php echo $tab_image; ?></a>
        </div>
        
        <div class="product_tab" id="general"><?php require_once(dirname(__FILE__)."/product_form_general.tpl"); ?></div>
        <div class="product_tab" id="data"><?php require_once(dirname(__FILE__)."/product_form_data.tpl"); ?></div>
        <div class="product_tab" id="links"><?php require_once(dirname(__FILE__)."/product_form_links.tpl"); ?></div>
        <div class="product_tab" id="discount"><?php require_once(dirname(__FILE__)."/product_form_discount.tpl"); ?></div>
        <div class="product_tab" id="special"><?php require_once(dirname(__FILE__)."/product_form_special.tpl"); ?></div>
        <div class="product_tab" id="option"><?php require_once(dirname(__FILE__)."/product_form_option.tpl"); ?></div>
        <div class="product_tab" id="images"><?php require_once(dirname(__FILE__)."/product_form_images.tpl"); ?></div>
        
    </form>
</div>
<script>
$(function(){
    $('.product_tab').hide();
    $('#general').show();
    $('.product_tabs .htab').on('click',function(e){
        $('.product_tab').hide();
        $($(this).attr('data-target')).show();
    });  
});
</script>
<?php echo $footer; ?>