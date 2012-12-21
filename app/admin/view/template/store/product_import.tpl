<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="grid_24 warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="grid_24 success"><?php echo $success; ?></div>
<?php } ?>

<div class="grid_24" id="msg"></div>
<div class="clear"></div>
<div id="wizardWrapper" class="box"><img src="image/nt_loader.gif" alt="Cargando..." /></div>
<?php echo $footer; ?>