
    <ul class="panel">
      <li class="done"><a onclick="$('#formWrapper').load('<?php echo $personal; ?>')" title=""><b>Datos Personales</b><p>Queremos saber m&aacute;s de ti</p></a></li>
      <li class="done"><a onclick="$('#formWrapper').load('<?php echo $social; ?>')" title=""><b>Socializaci&oacute;n</b><p>Queremos socializar contigo</p></li>
      <li class="done"><a onclick="$('#formWrapper').load('<?php echo $share; ?>')" title=""><b>Compartir</b><p>Com&eacute;ntale a tus amigos sobre nosotros</p></a></li>
      <li class="current"><b>&iexcl;Gracias!</b><p>Gracias por registrarte con nosotros!</p></li>
    </ul>
    
<?php if (isset($mostrarError)) echo $mostrarError; ?>
            <div class="clear"></div>

            <h2>Felicitaciones!</h2>
            
            <div class="grid_10">
                <h1>Felicitaciones!</h1>
                <p>Has logrado completar tu perfil con &eacute;xito. Ahora podr&aacute;s disfrutar de todos nuestros productos y servicios.</p>
                <p>Comienza navegando a trav&eacute;s de nuestras categor&iacute;as y del&eacute;itate con nuestra insuperable gama de productos, consigue lo que tanto andas buscando al mejor precio del mercado.</p>
            </div>
            <div class="grid_5">
                <h1>Comienza a Navagar</h1>

                <ul>
                    <li><a href="<?php echo HTTP_HOME; ?>" title="Inicio">Inicio</a></li>
                    <li><a href="<?php echo HTTP_HOME; ?>index.php?r=account/account" title="Cuenta">Cuenta</a></li>
                    <li><a href="<?php echo HTTP_HOME; ?>index.php?r=information/contact" title="Contacto">Contacto</a></li>
                </ul>

            </div>
            
        <?php if ($prev) {  ?>
        <a title="Atr&aacute;s" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $prev; ?>')">Atr&aacute;s</a>
        <?php } ?>
        <?php if ($next) {  ?>
        <a title="Omitir" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $next; ?>')">Omitir Este Paso</a>
        <?php } ?>
