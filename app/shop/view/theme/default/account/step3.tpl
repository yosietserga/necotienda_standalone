
    <ul class="panel">
      <li class="done"><a onclick="$('#formWrapper').load('<?php echo $personal; ?>')" title=""><b>Datos Personales</b><p>Queremos saber m&aacute;s de ti</p></a></li>
      <li class="done"><a onclick="$('#formWrapper').load('<?php echo $social; ?>')" title=""><b>Socializaci&oacute;n</b><p>Queremos socializar contigo</p></a></li>
      <li class="current"><b>Compartir</b><p>Com&eacute;ntale a tus amigos sobre nosotros</p></li>
      <li><b>&iexcl;Gracias!</b><p>Gracias por registrarte con nosotros!</p></li>
    </ul>
    
<?php if (isset($mostrarError)) echo $mostrarError; ?>
            <div class="clear"></div>

            <h2>Comparte Con Tus Amigos</h2>
            
            <div class="grid_10">
                <?php echo $share; ?>
                <div id="contacts"></div>
            </div>
            <div class="grid_5">
                <h1>Comparte con tus amigos!</h1>

                <p>Cu&eacute;ntale a todos sobre nuestros excelentes productos y ofertas.</p>

            </div>
            
        <?php if ($prev) {  ?>
        <a title="Atr&aacute;s" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $prev; ?>')">Atr&aacute;s</a>
        <?php } ?>
        <?php if ($next) {  ?>
        <a title="Omitir" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $next; ?>')">Omitir Este Paso</a>
        <?php } ?>
        <a class='button' onclick='sendInvitations()'>Enviar Invitaciones</a>
<script>
function shareContainer(e,h,t) {
    var htmlOutput = "";
    htmlOutput += "<div style='position:absolute;top:0px;left:0px;width:1800px;height:1200px;display:block;z-index:899;background:#000;opacity:0.5' id='shareOverlay'></div>"
    htmlOutput += "<div style='border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;box-shadow: 0px 0px 10px #333;-moz-box-shadow: 0px 0px 10px #333;-webkit-box-shadow: 0px 0px 10px #333;padding:50px;position:absolute;top:100px;left:180px;width:500px;height:300px;display:block;z-index:999;background:#FFF' id='shareContainer'>"
    
    htmlOutput += "<h1>Importar Contactos</h1>";
    htmlOutput += "<form action='<?php echo HTTP_HOME; ?>index.php?account/complete_activation/share' method='post' id='shareForm'>"
    
    htmlOutput += "<div class='property'>"
    htmlOutput += "<div class='label'>Email:</div>"
    htmlOutput += "<div class='field'>"
    htmlOutput += "<input type='text' name='email_box' value='' />"
    htmlOutput += "</div>"
    htmlOutput += "</div>"
    
    htmlOutput += "<div class='property'>"
    htmlOutput += "<div class='label'>Contrase&ntilde;a:</div>"
    htmlOutput += "<div class='field'>"
    htmlOutput += "<input type='password' name='password_box' autocomplete='off' value='' />"
    htmlOutput += "</div>"
    htmlOutput += "</div>"
    
    htmlOutput += "<div class='property'>";
    htmlOutput += "<div class='label'>&nbsp;</div>";
    htmlOutput += "<div class='field'>";
    htmlOutput += "<a class='button' onclick='sendInvites()'>Importar Contactos</a>";
    htmlOutput += "<a class='button'  onclick='$(\"#shareOverlay, #shareContainer\").remove();'>Cancelar</a>";
    htmlOutput += "</div>";
    htmlOutput += "</div>";
    
    
    htmlOutput += "<input type='hidden' name='network' value='" + e + "' />";
    htmlOutput += "<input type='hidden' name='h' value='" + h + "' />";
    htmlOutput += "<input type='hidden' name='t' value='" + t + "' />";
    
    htmlOutput += "</form>"
    
    htmlOutput += "<div class='clear'></div>";
    htmlOutput += "<p>Ingresa tu direcci&oacute;n de correo y la contrase&ntilde;a asociada a tu cuenta del servicio seleccionado para importar todos tus contactos y amigos.</p>";
    htmlOutput += "<p>Tus datos no ser&aacute;n almacenados ni compartidos, solo ser&aacute;n utilizados para obtener la lista de contactos que posees en tu cuenta y poder enviar invitaciones a todos tus amigos para que ingresen en NecoTienda.com</p>";
    htmlOutput += "<p>Al terminar este paso, todos tus datos asociados a tu cuenta ser&aacute;n eliminados.</p>";
    
    htmlOutput += "</div>"
    
    $("body").append(htmlOutput);
}
function sendInvites() {
    var strEmail = $("input[name='email_box']").val();
    var strPwd = $("input[name='password_box']").val();
    var msg = "";
    $(".error").remove();
    if (strEmail.length <= 0 || strPwd.length <= 0) {
        msg = "<div class='error'>Debe ingresar su email y su contrase&ntilde;a para poder continuar</div>";
        $("#shareContainer").append(msg); 
    } else {
        $.ajax({
            'type': 'post',
            'dataType': 'html',
            'url': 'index.php?r=account/complete_activation/getcontacts',
            'data': $("#shareForm").serialize(),
            'beforeSend': function() {
                
            },
            'success': function(data) {
                if (data.length > 0) {
                    $("#shareOverlay, #shareContainer").remove();
                    $("#contacts").html(data);
                }
            }
        });
    }
}
</script>
