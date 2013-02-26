<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
      
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="password">
    <?php echo isset($fkey)? $fkey : ''; ?>
    
        <div class="property">
            <div class="label"><?php echo $entry_password; ?></div>
            <div class="field">
                <input type="password" name="password" id="passwordi" value="" autocomplete="off" title="Ingrese una contrase&ntilde;a que empiece con letra, tenga una longitud m&iacute;nima de 6 caracteres, contenga al menos 1 may&uacute;scula,  1 min&uacute;scula,  1 n&uacute;mero y 1 caracter especial. Le recomendamos que no utilice fechas personales ni familiares, tampoco utilice iniciales de su nombre o familiares" /><span class="required">*</span><img class="chequea" id="checkpassword" src="image/check.png" />
            </div>
            <div class="msg_error">
              <?php if ($error_password) { ?>
              <span class="error" id="error_password"><?php echo $error_password; ?></span>
              <script>
				  $("#passwordi").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkpassword").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_confirm; ?></div>
            <div class="field">
                <input type="password" name="confirm" id="confirm" value="" autocomplete="off" title="Vuelva a escribir la contrase&ntilde;a" /><span class="required">*</span><img class="chequea" id="checkconfirm" src="image/check.png" />
            </div>
            <div class="msg_error">
              <?php if ($error_confirm) { ?>
              <span class="error" id="error_confirm"><?php echo $error_confirm; ?></span>
              <script>
				  $("#confirm").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkconfirm").attr("src","image/unchecked.png");
                </script>
              <?php } ?>            
            </div>
        </div>
        
        <div class="property">
            <div class="label"><?php echo $entry_captcha; ?></div>
            <div class="field">
                <input type="text" name="captcha" id="captcha" value="" autocomplete="off" title="Por favor ingrese el c&oacute;digo de verificaci&oacute;n" onfocus="$('#error_captcha').remove();" />
              <div class="clear"></div>
              <img src="http://www.necotienda.com/index.php?route=common/captcha" />   
            </div>
            <div class="msg_error">
              <?php if ($error_captcha) { ?>
              <span class="error" id="error_captcha"><?php echo $error_captcha; ?></span>
              <script>
				  $("#captcha").css({"border": "2px inset #F00","background":"#F66"});
                </script>
              <?php } ?>     
            </div>
        </div>
        
        <div class="property">
            <div class="label"></div>
            <div class="field">
                <a title="<?php echo $button_back; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><?php echo $button_back; ?></a>
                <a title="<?php echo $button_continue; ?>" onclick="$('#password').submit();" class="button"><?php echo $button_continue; ?></a> 
            </div>
        </div>
        
    </form>
    <script> 
        $(function() {
        $("#password :input").tooltip({
        	position: "center right",
        	offset: [-2, 10],
        	effect: "fade",
        	opacity: 0.9});
        });
    </script> 
</div>
<?php if ($config_password_security) { ?>
<script type="text/javascript" src="catalog/view/javascript/account_password.js"></script>
<?php } ?>
<?php echo $footer; ?> 