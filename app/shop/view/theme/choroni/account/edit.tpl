<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
      
  <div class="middle">
    <div class="tabs" style="margin:0 !important;padding:0 !important;">
      <a title="<?php echo $tab_fiscales; ?>" tab="#tab_fiscales"><?php echo $tab_fiscales; ?></a>
      <a title="<?php echo $tab_personales; ?>" tab="#tab_personales"><?php echo $tab_personales; ?></a>
     <a title="<?php echo $tab_social_media; ?>" tab="#tab_social_media"><?php echo $tab_social_media; ?></a>
      <a title="<?php echo $tab_profesionales; ?>" tab="#tab_profesionales"><?php echo $tab_profesionales; ?></a>
    </div>
        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="edit">
        <?php echo isset($fkey)? $fkey : ''; ?>
    <div id="tab_fiscales" class="tab_page">     
    <fieldset>
        <div class="legend"><?php echo $tab_fiscales; ?></div>
    
        <div class="property">
            <div class="label"><?php echo $entry_company; ?></div>
            <div class="field">
                <input type="text" id="company" name="company" value="<?php echo $company; ?>" title="Ingrese su nombre y apellido si es persona natural sino ingrese el nombre de su organizaci&oacute;n" /><span class="required">*</span><img class="chequea" id="checkcompany" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_company) { ?>
                  <span class="error" id="error_company"><?php echo $error_company; ?></span>
                  <script>
    				  $("#company").css({"border": "2px inset #F00","background":"#F66"});
    				  $("#checkcompany").attr("src","image/unchecked.png");
                    </script>
                  <?php } ?>
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_rif; ?></div>
            <div class="field">
                <input type="text" id="rif" name="rif" value="<?php echo $rif; ?>" title="Por favor ingrese su RIF. Si es persona natural y a&uacute;n no posee uno, ingrese su n&uacute;mero de c&eacute;dula con un n&uacute;mero cero al final" /><span class="required">*</span><img class="chequea" id="checkrif" src="image/check.png" />
            </div>
            <div class="msg_error">
                  <?php if ($error_rif) { ?>
                  <span class="error" id="error_rif"><?php echo $error_rif; ?></span>
                  <script>
    				  $("#rif").css({"border": "2px inset #F00","background":"#F66"});
    				  $("#checkrif").attr("src","image/unchecked.png");
                    </script>
                  <?php } ?>
            </div>
        </div>
    </fieldset>
    </div>
    <div id="tab_personales" class="tab_page">
    <fieldset>
        <div class="legend"><?php echo $tab_personales; ?></div>
        
        <div class="property">
            <div class="label"><?php echo $entry_firstname; ?></div>
            <div class="field">
                <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" title="Ingrese su nombre, debe tener al menos 3 caracteres" /><span class="required">*</span><img class="chequea" id="checkfirstname" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_firstname) { ?>
              <span class="error" id="error_firstname"><?php echo $error_firstname; ?></span>
              <script>
				  $("#firstname").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkfirstname").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_lastname; ?></div>
            <div class="field">
                <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" title="Ingrese su apellido, debe tener al menos 3 caracteres" /><span class="required">*</span><img class="chequea" id="checklastname" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_lastname) { ?>
              <span class="error" id="error_lastname"><?php echo $error_lastname; ?></span>
              <script>
				  $("#lastname").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checklastname").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_nacimiento; ?></div>
            <div class="field">
                <input type="text" id="nacimiento" name="nacimiento" value="<?php echo $nacimiento; ?>" title="Ingrese su fecha de nacimiento. Debe utilizar el formato 00/00/0000 y debe ser mayor de edad" onblur="jquery('#nacimiento').trigger('keyup');" /><span class="required">*</span><img class="chequea" id="checknacimiento" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_nacimiento) { ?>
              <span class="error" id="error_nacimiento"><?php echo $error_nacimiento; ?></span>
              <script>
				  $("#nacimiento").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checknacimiento").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_sexo; ?></div>
            <div class="field">
                <select id="sexo" name="sexo" title="Seleccione su sexo" onblur="$('#sexo').trigger('keyup');">
            <?php if (isset($sexo)) ?>
                <?php if (strtolower($sexo) == 'm') { ?>
                    <option value="false">Seleccione su sexo</option>
                    <option value="m" selected="selected">Hombre</option>
                    <option value="f">Mujer</option>
                <?php } elseif (strtolower($sexo) == 'f') { ?>
                    <option value="false">Seleccione su sexo</option>
                    <option value="m">Hombre</option>
                    <option value="f" selected="selected">Mujer</option>
                <?php  } else { ?>                    
                    <option value="false">Seleccione su sexo</option>
                    <option value="m">Hombre</option>
                    <option value="f">Mujer</option>
                <?php } ?>
            </select><span class="required">*</span><img class="chequea" id="checksexo" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_sexo) { ?>
              <span class="error" id="error_sexo"><?php echo $error_sexo; ?></span>
              <script>
				  $("#sexo").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checksexo").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_telephone; ?></div>
            <div class="field">
                <input type="text" name="telephone" id="telephone" value="<?php echo $telephone; ?>" title="Ingrese su tel&eacute;fono con c&oacute;digo internacional, p.ej. +584243580788" /><span class="required">*</span><img class="chequea" id="checktelephone" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_telephone) { ?>
              <span class="error" id="error_telephone"><?php echo $error_telephone; ?></span>
              <script>
				  $("#telephone").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checktelephone").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
        </div>
    </fieldset>
    </div>
    <div id="tab_social_media" class="tab_page"> 
    <fieldset>
        <div class="legend"><?php echo $tab_social_media; ?></div>
        <div class="property">
            <div class="label">Twitter:</div>
            <div class="field">
                <input type="text" name="twitter" id="twitter" title="Coloca tu nombre de twitter" value="<?php echo $twitter; ?>" /><img class="chequea" id="checktwitter" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">Facebook:</div>
            <div class="field">
                <input type="text" name="facebook" id="facebook" title="Coloca tu nombre de facebook o ID del perfil" value="<?php echo $facebook; ?>" /><img class="chequea" id="checkfacebook" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">MySpace:</div>
            <div class="field">
                <input type="email" name="msn" id="msn" title="Coloca tu email de Hotmail o MSN" value="<?php echo $msn; ?>" /><img class="chequea" id="checkmsn" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">Gmail:</div>
            <div class="field">
                <input type="email" name="gmail" id="gmail" title="Coloca tu email de Gmail" value="<?php echo $gmail; ?>" /><img class="chequea" id="checkgmail" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">Yahoo:</div>
            <div class="field">
                <input type="email" name="yahoo" id="yahoo" title="Coloca tu email de Yahoo" value="<?php echo $yahoo; ?>" /><img class="chequea" id="checkyahoo" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">Skype:</div>
            <div class="field">
                <input type="text" name="skype" id="skype" title="Coloca tu usuario de Skype" value="<?php echo $skype; ?>" /><img class="chequea" id="checkskype" src="image/check.png" />
            </div>
        </div>
    </fieldset>
    </div>
    <div id="tab_profesionales" class="tab_page">
    <fieldset>
        <div class="legend"><?php echo $tab_profesionales; ?></div>
    
        <div class="property">
            <div class="label">Website:</div>
            <div class="field">
                <input type="text" name="website" id="website" value="<?php echo $website; ?>" title="Ingresa la direcci&oacute;n de tu website o el website de la empresa. P. ej. http://www.miweb.com/" /><img class="chequea" id="checkwebsite" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">Blog:</div>
            <div class="field">
                <input type="text" name="blog" id="blog" value="<?php echo $blog; ?>" title="Ingresa la direcci&oacute;n de tu blog personal. P. ej. http://www.miblog.com/" /><img class="chequea" id="checkblog" src="image/check.png" />
            </div>
        </div>
        
        <div class="property">
            <div class="label">T&iacute;tulo Acad&eacute;mico:</div>
            <div class="field">
                <select name="titulo" title="Selecciona tu &uacute;tlimo t&iacute;tulo acad&eacute;mico obtenido" style="width:200px !important">
                <?php if (!empty($titulo)) { ?>
                	<option value="<?php echo $titulo; ?>" selected="selected"><?php echo $titulo; ?></option>
                <?php } ?>
                  <option value="">Seleccione su t&iacute;tulo</option>
                  <option value="Bachiller">Bachiller</option>
                  <option value="T&eacute;cnico Medio">T&eacute;cnico Medio</option>
                  <option value="T&eacute;cnico Superior">T&eacute;cnico Superior</option>
                  <option value="Ingeniero">Ingeniero</option>
                  <option value="Licenciado">Licenciado</option>
                  <option value="Postgrado">Postgrado</option>
                  <option value="Especializaci&oacute;n">Especializaci&oacute;n</option>
                  <option value="Maestr&iacute;a">Maestr&iacute;a</option>
                  <option value="Doctorado">Doctorado</option>
                </select>
            </div>
        </div>
        
        <div class="property">
            <div class="label">Profesi&oacute;n:</div>
            <div class="field">
                <select name="profesion" title="Selecciona el &aacute;rea donde te desempe&ntilde;as o laboras" style="width:200px !important">
                    <?php if (!empty($profesion)) { ?>
                    	<option value="<?php echo $profesion; ?>" selected="selected"><?php echo $profesion; ?></option>
                    <?php } ?>
                      <option value="">Seleccione una profesi&oacute;n</option>
                      <option value="Estudiante">Estudiante</option>
                      <option value="Agronom&iacute;a">Agronom&iacute;a</option>
                      <option value="Antropolog&iacute;a">Antropolog&iacute;a</option>
                      <option value="Arqueolog&iacute;a">Arqueolog&iacute;a</option>
                      <option value="Arquitectura">Arquitectura</option>
                      <option value="Artista">Artista</option>
                      <option value="Asesor&iacute;a y Consultor&iacute;a">Asesor&iacute;a y Consultor&iacute;a</option>
                      <option value="Astrolog&iacute;a">Astrolog&iacute;a</option>
                      <option value="Astronom&iacute;a">Astronom&iacute;a</option>
                      <option value="Biolog&iacute;a">Biolog&iacute;a</option>
                      <option value="Cardiolog&iacute;a">Cardiolog&iacute;a</option>
                      <option value="Construcci&oacute;n">Construcci&oacute;n</option>
                      <option value="Contratista">Contratista</option>
                      <option value="Criminalista">Criminalista</option>
                      <option value="Decoraci&oacute;n">Decoraci&oacute;n</option>
                      <option value="Demograf&iacute;a">Demograf&iacute;a</option>
                      <option value="Derechos y Leyes">Derechos y Leyes</option>
                      <option value="Dermatolog&iacute;a">Dermatolog&iacute;a</option>
                      <option value="Dise&ntilde;o de Interiores">Dise&ntilde;o de Interiores</option>
                      <option value="Dise&ntilde;o Gr&aacute;fico">Dise&ntilde;o Gr&aacute;fico</option>
                      <option value="Dise&ntilde;o Web">Dise&ntilde;o Web</option>
                      <option value="Econom&iacute;a">Econom&iacute;a</option>
                      <option value="Educaci&oacute;n">Educaci&oacute;n</option>
                      <option value="Electricidad">Electricidad</option>
                      <option value="Electr&oacute;nica">Electr&oacute;nica</option>
                      <option value="Filosof&iacute;a">Filosof&iacute;a</option>
                      <option value="F&iacute;sica">F&iacute;sica</option>
                      <option value="Fotograf&iacute;a">Fotograf&iacute;a</option>
                      <option value="Geograf&iacute;a">Geograf&iacute;a</option>
                      <option value="Geolog&iacute;a">Geolog&iacute;a</option>
                      <option value="">Historia</option>
                      <option value="Historia">Inform&aacute;tica</option>
                      <option value="Internet">Internet</option>
                      <option value="Invenciones">Invenciones</option>
                      <option value="Inversiones">Inversiones</option>
                      <option value="Jardiner&iacute;a">Jardiner&iacute;a</option>
                      <option value="Matem&aacute;tica">Matem&aacute;tica</option>
                      <option value="Mec&aacute;nica Aeroespacial">Mec&aacute;nica Aeroespacial</option>
                      <option value="Mec&aacute;nica Aeron&aacute;utica">Mec&aacute;nica Aeron&aacute;utica</option>
                      <option value="Mec&aacute;nica Automotriz">Mec&aacute;nica Automotriz</option>
                      <option value="Mec&aacute;nica Industrial">Mec&aacute;nica Industrial</option>
                      <option value="Mec&aacute;nica Naval">Mec&aacute;nica Naval</option>
                      <option value="Medicina">Medicina</option>
                      <option value="Medico">Medico</option>
                      <option value="Metal&uacute;rjica">Metal&uacute;rjica</option>
                      <option value="Meteorolog&iacute;a">Meteorolog&iacute;a</option>
                      <option value="M&uacute;sica">M&uacute;sica</option>
                      <option value="Odontolog&iacute;a">Odontolog&iacute;a</option>
                      <option value="Periodismo">Periodismo</option>
                      <option value="Psicolog&iacute;a">Psicolog&iacute;a</option>
                      <option value="Psicopedagog&iacute;a">Psicopedagog&iacute;a</option>
                      <option value="Psicoterapia">Psicoterapia</option>
                      <option value="Psiquiatr&iacute;a">Psiquiatr&iacute;a</option>
                      <option value="Publicidad">Publicidad</option>
                      <option value="Qu&iacute;mica">Qu&iacute;mica</option>
                      <option value="Quiropr&aacute;ctica">Quiropr&aacute;ctica</option>
                      <option value="Redes y Telecomunicaciones">Redes y Telecomunicaciones</option>
                      <option value="Rob&oacute;tica">Rob&oacute;tica</option>
                      <option value="Seguridad">Seguridad</option>
                      <option value="Sexolog&iacute;a">Sexolog&iacute;a</option>
                      <option value="Sismolog&iacute;a">Sismolog&iacute;a</option>
                      <option value="Sociolog&iacute;a">Sociolog&iacute;a</option>
                      <option value="T&eacute;cnico">T&eacute;cnico</option>
                      <option value="Terapia">Terapia</option>
                      <option value="Veterinaria">Veterinaria</option>
                      <option value="Zoolog&iacute;a">Zoolog&iacute;a</option>
                    </select>
            </div>
        </div>
    </fieldset>
    </div>
    <div class="buttons">
    
        <div class="property">
            <div class="label"><?php echo $entry_captcha; ?></div>
            <div class="field">
                <input type="text" name="captcha" value="" autocomplete="off" title="Por favor ingrese el c&oacute;digo de verificaci&oacute;n" />
                <?php if ($error_captcha) { ?>
              <span class="error"><?php echo $error_captcha; ?></span>
              <?php } ?>
              <br />
              <img src="http://www.necotienda.com/index.php?route=common/captcha" />
            </div>
        </div>
        
        <div class="property">
            <div class="label"></div>
            <div class="field">
                <a title="<?php echo $button_back; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><?php echo $button_back; ?></a>
                <a title="Guardar" onclick="$('#edit').submit();" class="button">Guardar</a>
            </div>
        </div>
        
      </div>
    </form>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    
    <script> 
        $(function() {
        $("#edit :input").tooltip({
        	position: "center right",
        	offset: [-2, 10],
        	effect: "fade",
        	opacity: 0.9});
        });
      </script> 
  </div>
</div>
<script type="text/javascript">
$.tabs('.tabs a'); 
</script>
<?php if ($config_js_security) { ?>
<script type="text/javascript" src="catalog/view/javascript/account_edit.js"></script>
<?php } ?>
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
<?php echo $footer; ?> 