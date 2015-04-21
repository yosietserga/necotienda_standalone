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
        <h1>Configurar Correo Saliente</h1>
        <div class="buttons">
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_exit'); ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_keep'); ?></a>
            <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_new'); ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_cancel'); ?></a>
        </div>
        
        <div class="clear"></div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <div>
                <table class="form">
                    <tr>
                        <td><?php echo $Language->get('Username'); ?></td>
                        <td><input type="text" name="username" value="<?php echo $server['username']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $Language->get('Password'); ?></td>
                        <td><input type="password" name="password" value="<?php echo $server['password']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $Language->get('Host'); ?></td>
                        <td><input type="text" name="server" value="<?php echo $server['server']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $Language->get('Port'); ?></td>
                        <td><input type="necoNumber" name="port" value="<?php echo $server['port']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $Language->get('Security'); ?></td>
                        <td><select name="security" title="Ingrese el tama&ntilde;o m&aacute;ximo del email en Bytes, esto es utilizado para prevenir que se env&iacute;en emails con contenidos mayores a los permitidos">
                            <option value=""<?php if ($server['security'] == '') { ?> selected="selected"<?php } ?>>No SSL/TLS</option>
                            <option value="ssl"<?php if ($server['security'] == 'ssl') { ?> selected="selected"<?php } ?>>SSL</option>
                            <option value="tls"<?php if ($server['security'] == 'tls') { ?> selected="selected"<?php } ?>>TLS</option>
                          </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a class="button" data-test-connection="1"><?php echo $Language->get('Test Connection'); ?></a></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>

<div class="sidebar" id="feedbackPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Sugerencias</h2>
        <p style="margin: -10px auto 0px auto;">Tu opini&oacute;n es muy importante, dinos que quieres cambiar.</p>
        <form id="feedbackForm">
            <textarea name="feedback" id="feedback" cols="60" rows="10"></textarea>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo C_CODE; ?>" />
            <input type="hidden" name="domain" id="domain" value="<?php echo HTTP_DOMAIN; ?>" />
            <input type="hidden" name="server_ip" id="server_ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <input type="hidden" name="remote_ip" id="remote_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
            <input type="hidden" name="server" id="server" value="<?php echo serialize($_SERVER); ?>" />
            <div class="clear"></div>
            <br />
            <div class="buttons"><a class="button">Enviar Sugerencia</a></div>
        </form>
    </div>
</div>
<div class="sidebar" id="toolPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Herramientas</h2>
        <p>S&aacute;cale provecho a NecoTienda y aumenta tus ventas.</p>
        <ul>
            <li><a onclick="$('#addsWrapper').slideDown();$('html, body').animate({scrollTop:$('#addsWrapper').offset().top}, 'slow');">Agregar Productos</a></li>
            <li><a class="trends" data-fancybox-type="iframe" href="http://www.necotienda.com/index.php?route=api/trends&q=samsung&geo=VE">Evaluar Palabras Claves</a></li>
            <li><a>Eliminar Esta Categor&iacute;a</a></li>
        </ul>
        <div class="toolWrapper"></div>
    </div>
</div>
<div class="sidebar" id="helpPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Ayuda</h2>
        <p>No entres en p&aacute;nico, todo tiene una soluci&oacute;n.</p>
        <ul>
            <li><a>&iquest;C&oacute;mo se come esto?</a></li>
            <li><a>&iquest;C&oacute;mo relleno este formulario?</a></li>
            <li><a>&iquest;Qu&eacute; significan las figuritas al lado de los campos?</a></li>
            <li><a>&iquest;C&oacute;mo me desplazo a trav&eacute;s de las pesta&ntilde;as?</a></li>
            <li><a>&iquest;Pierdo la informaci&oacute;n si me cambio de pesta&ntilde;a?</a></li>
            <li><a>Preguntas Frecuentes</a></li>
            <li><a>Manual de Usuario</a></li>
            <li><a>Videos Tutoriales</a></li>
            <li><a>Auxilio, por favor ay&uacute;denme!</a></li>
        </ul>
    </div>
</div>
<script>
$(function(){
    $('a[data-test-connection]').on('click', function(){
        var that = this;
        if ($(this).attr('data-test-connection') == 1) {
            $(this).text('Loading').attr('data-test-connection',0);
            $.getJSON('<?php echo $Url::createAdminUrl('marketing/mailserver/testConnection'); ?>',{
               server:$('input[name=server]').val(),
               username:$('input[name=username]').val(),
               password:$('input[name=password]').val(),
               port:$('input[name=port]').val(),
               security:$('select[name=security]').val()
            }).done(function(data){
                if (data.error) {
                    $('#msg').html('<div class="message error"><?php echo $Language->get('Cannot connect to the mail server, please check the data and try again'); ?></div>');
                } else {
                    $('#msg').html('<div class="message success"><?php echo $Language->get('Connection Successful'); ?></div>');
                }
                $(that).text('Test Connection').attr('data-test-connection', 1);
            });
        }
    });
});
</script>
<?php echo $footer; ?>