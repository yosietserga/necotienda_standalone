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
        <?php if ($category_id) { ?><a href="<?php echo $Url::createUrl("store/category",array('path'=>$category_id),'NONSSL',HTTP_CATALOG); ?>" target="_blank"><?php echo $Language->get('text_see_category_in_storefront'); ?></a><?php } ?>
        <div class="buttons">
            <a id="necoBoy" style="margin: 0px 10px;" title="NecoBoy ay&uacute;dame!"><img src="<?php echo HTTP_IMAGE; ?>necoBoy.png" alt="NecoBoy" /></a>
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_exit'); ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_cancel'); ?></a>
        </div>

        <div class="clear"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

            <div class="row">
                <label><?php echo $Language->get('Module Name'); ?></label>
                <input name="module" value="<?php echo isset($module) ? $module : ''; ?>" required="true" style="width:40%" />
            </div>

        </form>
    </div>
</div>
<?php echo $footer; ?>