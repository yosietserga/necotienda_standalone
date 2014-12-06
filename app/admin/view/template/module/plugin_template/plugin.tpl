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
    
    <div class="grid_12">
        <div class="box">
            <h1><?php echo $Language->get('heading_title'); ?></h1>

            <div class="buttons">
                <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_exit'); ?></a>
                <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_keep'); ?></a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_cancel'); ?></a>
            </div>

            <div class="clear"></div><br />

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div class="row">
                    <label><?php echo $Language->get('entry_field_1'); ?></label>
                    <input name="campo1" value="<?php echo isset($campo1) ? $campo1 : ''; ?>" />
                </div>

                <div class="row">
                    <label><?php echo $Language->get('entry_status'); ?></label>
                    <select name="status">
                        <option value="1"<?php if ($status) { ?> selected="1"<?php } ?>>Activado</option>
                        <option value="0"<?php if ($status) { ?> selected="1"<?php } ?>>Desactivado</option>
                    </select>
                </div>
            </form>

        </div>
    </div>
</div>
<?php echo $footer; ?>