<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="grid_16" id="content">
    <h1><?php echo $heading_title; ?></h1>
<?php if (isset($mostrarError)) echo $mostrarError; ?>
<div id="wizardwrapper">
    
    <div class="clear"></div>
    <div id="formWrapper"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="Cargando..." /></div>
</div>
<?php  echo $footer; ?> 