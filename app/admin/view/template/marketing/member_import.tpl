<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/customer.png');"><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" name="form" id="form" enctype="multipart/form-data">
        <p style="width: 550px;">Para importar miembros a la tienda, seleccione la estructura del archivo, seleccione el archivo con formato CSV que contiene la informaci&oacute;n correcta y luego haga click en el bot&oacute;n <b>Subir</b></p>
        <select id="format" name="format">
          <option value="false">Seleccione la estructura del archivo</option>
          <option value="necotienda">NecoTienda</option>
          <option value="hotmail">Hotmail</option>
          <option value="gmail">Gmail</option>
          <option value="yahoo">Yahoo</option>
        </select><br><br>
        <input type="file" name="file_import" id="file_import">
        <br><br><br>
        <div class="buttons"><a class="button" onclick="jQuery('#form').submit()"><span>Subir</span></a></div>
    </form>
  </div>
</div>
<?php echo $footer; ?>