<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
    <h1><?php echo $heading_title; ?></h1>
    
    <?php if (isset($mostrarError)) echo $mostrarError; ?>
  
    <?php if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="create">
    <?php echo isset($fkey)? $fkey : ''; ?>
      <p><?php echo $text_account_already; ?></p>
      <fieldset>
        <div class="legend"><?php echo $text_your_details; ?></div>
      
          <div class="property">
            <div class="label"><?php echo $entry_company; ?></div>
            <div class="field">
                <input type="text" id="company" name="company" value="<?php echo $company; ?>" title="Ingrese su nombre y apellido si es persona natural sino ingrese el nombre de su organizaci&oacute;n" />
                <span class="required">*</span>
                <img class="chequea" id="checkcompany" src="<?php echo HTTP_IMAGE; ?>check.png" />
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
                <select name="riftype" title="Selecciona el tipo de documentaci&oacute;n">
                    <option value="V">V</option>
                    <option value="J">J</option>
                    <option value="E">E</option>
                    <option value="G">G</option>
                </select>
                <input type="text" id="rif" name="rif" value="<?php echo $rif; ?>" title="Por favor ingrese su RIF. Si es persona natural y a&uacute;n no posee uno, ingrese su n&uacute;mero de c&eacute;dula con un n&uacute;mero cero al final" />
                <span class="required">*</span>
                <img class="chequea" id="checkrif" src="image/check.png" />
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
              
          <div class="property">
            <div class="label"><?php echo $entry_email; ?></div>
            <div class="field">
                <input type="text" name="email" id="email" value="<?php echo $email; ?>" title="Ingrese su email, &eacute;ste ser&aacute; verificado contra su servidor para validarlo" />
                <span class="required">*</span>
                <img class="chequea" id="checkemail" src="<?php echo HTTP_IMAGE; ?>check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_email) { ?>
              <span class="error" id="error_email"><?php echo $error_email; ?></span>
              <script>
				  $("#email").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkemail").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
          </div>
          
          <div class="property">
            <div class="label"><?php echo $entry_password; ?></div>
            <div class="field">
                <input type="password" name="password" id="password" value="" autocomplete="off" title="Ingrese una contrase&ntilde;a que empiece con letra, tenga una longitud m&iacute;nima de 6 caracteres, contenga al menos 1 may&uacute;scula,  1 min&uacute;scula,  1 n&uacute;mero y 1 caracter especial. Le recomendamos que no utilice fechas personales ni familiares, tampoco utilice iniciales de su nombre o familiares" />
                <span class="required">*</span>
                <img class="chequea" id="checkpassword" src="image/check.png" />
            </div>
            <div class="msg_error">
                <?php if ($error_password) { ?>
              <span class="error" id="error_password"><?php echo $error_password; ?></span>
              <script>
				  $("#password").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkpassword").attr("src","image/unchecked.png");
                </script>
              <?php } ?>
            </div>
          </div>
          
          <div class="property">
            <div class="label"><?php echo $entry_confirm; ?></div>
            <div class="field">
                <input type="password" name="confirm" id="confirm" value="" autocomplete="off" title="Vuelva a escribir la contrase&ntilde;a" />
                <span class="required">*</span>
                <img class="chequea" id="checkconfirm" src="image/check.png" />
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
          
      </fieldset>
      
      <fieldset>
            <div class="legend">Condiciones de Uso</div>
            
            <?php if (isset($recaptcha)) { ?>
            <div class="property">
                <div class="label">&nbsp;</div>
                <div class="field">
                    <?php echo $recaptcha; ?>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($text_agree) { ?>
            <div class="property">
                <div class="label"><?php echo $text_agree; ?></div>
                <div class="field">
                    <input type="checkbox" name="agree" id="agree_field" value="1" title="Al hacer clic aqu&iacute; hago constancia de que he le&iacute;do y estoy completamente de acuerdo con las pol&iacute;ticas y condiciones de uso aplicadas en esta tienda" />
                </div>
                <div class="msg_error">
                    <?php if ($error_warning) { ?>
    				<script>
                        $("#agree").css({"border": "2px inset #F00","background":"#F66"});
                    </script>
                  <?php } ?>
                </div>
            </div>
            <?php } ?>
      </fieldset>
            <div class="property">
                <div class="field"><a title="<?php echo $button_continue; ?>" onclick="$('#create').submit();" class="button"><?php echo $button_continue; ?></a></div>
            </div>
            
      <input type="hidden" name="codigo" value="<?php echo $email; ?>">
    </form>
    <script> 
        $(function() {
        $("#create :input").tooltip({
        	position: "center right",
        	offset: [-2, 10],
        	effect: "fade",
        	opacity: 0.9});
        });
    </script> 
  </div>
</div>
<?php echo $footer; ?> 