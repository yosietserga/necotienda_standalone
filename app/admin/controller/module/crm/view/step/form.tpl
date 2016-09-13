<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    
    <?php if ($breadcrumbs) { ?>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
    
    <?php if ($success) { ?><div class="grid_12"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
    <?php if ($msg || $error_warning) { ?><div class="grid_12"><div class="message warning"><?php echo ($msg) ? $msg : $error_warning; ?></div></div><?php } ?>
    <?php if ($error) { ?><div class="grid_12"><div class="message error"><?php echo $error; ?></div></div><?php } ?>
    <div class="grid_12" id="msg"></div>
    
    <div class="box">
        <h1><?php echo $Language->get('heading_title'); ?></h1>
        <?php if ($manufacturer_id) { ?><a href="<?php echo $Url::createUrl("store/manufacturer",array('manufacturer_id'=>$manufacturer_id),'NONSSL',HTTP_CATALOG); ?>" target="_blank"><?php echo $Language->get('text_see_manufacturer_in_storefront'); ?></a><?php } ?>
        <div class="buttons">
            <a id="necoBoy" style="margin: 0px 10px;" title="NecoBoy ay&uacute;dame!"><img src="<?php echo HTTP_IMAGE; ?>necoBoy.png" alt="NecoBoy" /></a>
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_exit'); ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_keep'); ?></a>
            <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_new'); ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_cancel'); ?></a>
        </div>
        
        <div class="clear"></div>
                       
        <ol id="stepsForm" class="joyRideTipContent" style="display:none">
            <li data-button="<?php echo $Language->get('button_next'); ?>">
                <h2><?php echo $Language->get('heading_joyride_begin'); ?></h2>
                <p><?php echo $Language->get('help_joyride_begin'); ?></p>
            </li>
            <li data-class="necoTemplate" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_01'); ?></h2>
                <p><?php echo $Language->get('help_joyride_01'); ?></p>
            </li>
            <li data-class="necoName" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_02'); ?></h2>
                <p><?php echo $Language->get('help_joyride_02'); ?></p>
            </li>
            <li data-class="necoSeoUrl" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_03'); ?></h2>
                <p><?php echo $Language->get('help_joyride_03'); ?></p>
            </li>
            <li data-class="necoImage" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_04'); ?></h2>
                <p><?php echo $Language->get('help_joyride_04'); ?></p>
            </li>
            <li data-class="necoStore" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_05'); ?></h2>
                <p><?php echo $Language->get('help_joyride_05'); ?></p>
            </li>
            <li data-class="necoPanel" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_06'); ?></h2>
                <p><?php echo $Language->get('help_joyride_06'); ?></p>
            </li>
            <li data-button="<?php echo $Language->get('button_close'); ?>">
                <h2><?php echo $Language->get('heading_joyride_final'); ?></h2>
                <p><?php echo $Language->get('help_joyride_final'); ?></p>
            </li>
        </ol>
        <script type="text/javascript" src="<?php echo HTTP_ADMIN_JS; ?>vendor/joyride/jquery.joyride-2.1.js"></script>
        <script>
            $(window).load(function() {
                $(document.createElement('link')).attr({
                    'href':'<?php echo HTTP_ADMIN_CSS; ?>joyride.css',
                    'rel':'stylesheet',
                    'media':'screen'
                }).appendTo('head');
            });
            $(function(){
                $('#necoBoy').on('click', function(e){
                    $('#stepsForm').joyride({
                        autoStart : true,
                        modal:false,
                        expose:true
                    });
                });
            });
        </script>
                 
        <div class="clear"></div>
                     
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

            <div class="row">
                <label><?php echo $Language->get('Step Name'); ?></label>
                <input class="necoName" id="name" name="name" value="<?php echo $name; ?>" required="true" style="width:40%" placeholder="First Contact" />
            </div>
                
            <div class="clear"></div>
            
            <div class="row">
                <label><?php echo $Language->get('Sort Order'); ?></label>
                <input class="number" name="properties[sort_order]" value="<?php echo $properties[sort_order]; ?>" required="true" style="width:40%" placeholder="1" />
            </div>
                
            <div class="clear"></div>
            
        </form>
    </div>
</div>
<?php echo $footer; ?>