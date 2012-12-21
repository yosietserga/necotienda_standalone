<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
      
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
  <div class="middle">
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="address">
    <?php echo isset($fkey)? $fkey : ''; ?>
    <input type="hidden" name="company" value="<?php echo $company; ?>">
    <input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
    <input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_edit_address; ?></b>
      <div class="content">
        <table>
          <tr>
            <td style="width:200px !important"><?php echo $entry_address_1; ?></td>
            <td><input class="input" type="text" name="address_1" id="address_1" value="<?php echo $address_1; ?>" title="Ingrese su direcci&oacute;n de habitaci&oacute;n o trabajo"><span class="required">*</span><img class="chequea" id="checkaddress_1" src="image/check.png">
              <?php if ($error_address_1) { ?>
              <span class="error" id="error_address_1"><?php echo $error_address_1; ?></span>
              <script>
				  $("#address_1").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkaddress_1").attr("src","image/unchecked.png");
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_2; ?></td>
            <td><input class="input" type="text" name="address_2" value="<?php echo $address_2; ?>" title="Ingrese una direcci&oacute;n alterna">&nbsp;&nbsp;<img class="chequea" id="checkfirstname" src="image/check.png"></td>
          </tr>
          <tr>
            <td><?php echo $entry_city; ?></td>
            <td><input class="input" type="text" id="city" name="city" value="<?php echo $city; ?>" title="Ingrese la ciudad donde reside"><span class="required">*</span><img class="chequea" id="checkcity" src="image/check.png">
              <?php if ($error_city) { ?>
              <span class="error" id="error_city"><?php echo $error_city; ?></span>
              <script>
				  $("#city").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkcity").attr("src","image/unchecked.png");
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_postcode; ?></td>
            <td><input class="input" type="text" name="postcode" value="<?php echo $postcode; ?>" title="Ingrese el c&oacute;digo postal de la ciudad donde reside">&nbsp;&nbsp;<img class="chequea" id="checkfirstname" src="image/check.png"></td>
          </tr>
          <tr>
            <td><?php echo $entry_country; ?></td>
            <td><select class="input" name="country_id" id="country_id" onchange="$('select[name=\'zone_id\']').load('index.php?route=account/create/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');" title="Seleccione el pa&iacute;s donde reside">
                <option value="false"><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select><span class="required">*</span><img class="chequea" id="checkcountry_id" src="image/check.png">
              <?php if ($error_country) { ?>
              <span class="error" id="error_country"><?php echo $error_country; ?></span>
              <script>
				  $("#country_id").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkcountry_id").attr("src","image/unchecked.png");
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?></td>
            <td><select class="input" name="zone_id" id="zone_id" title="Seleccione el estado/provincia/departamento donde reside"> 
              </select><span class="required">*</span><img class="chequea" id="checkzone_id" src="image/check.png">
              <?php if ($error_zone) { ?>
              <span class="error" id="error_zone"><?php echo $error_zone; ?></span>
              <script>
				  $("#zone_id").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkzone_id").attr("src","image/unchecked.png");
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_default; ?></td>
            <td><?php if ($default) { ?>
              <input type="radio" name="default" value="1" checked="checked">
              <?php echo $text_yes; ?>
              <input type="radio" name="default" value="0" title="&iquest;Desea colocar esta direcci&oacute; como predeterminada?">
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="default" value="1">
              <?php echo $text_yes; ?>
              <input type="radio" name="default" value="0" checked="checked" title="&iquest;Desea colocar esta direcci&oacute; como predeterminada?">
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
         <tr>
            <td><br>
            <?php echo $entry_captcha; ?></td>
            <td><br>
              <input class="input" type="text" name="captcha" id="captcha" value="" autocomplete="off" title="Por favor ingrese el c&oacute;digo de verificaci&oacute;n" onFocus="$('#error_captcha').remove();">
              <?php if ($error_captcha) { ?>
              <span class="error" id="error_captcha"><?php echo $error_captcha; ?></span>
              <script>
				  $("#captcha").css({"border": "2px inset #F00","background":"#F66"});
                </script>
              <?php } ?>
              <br>
              <img src="http://www.necotienda.com/index.php?route=common/captcha" /></td>
          </tr>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td><a title="<?php echo $button_back; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onclick="$('#address').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
    <script>
        $(function() {
        $("#address :input").tooltip({
        	position: "center right",
        	offset: [-2, 10],
        	effect: "fade",
        	opacity: 0.9});
        });
		
    </script> 
  </div>
</div>
<script type="text/javascript">
$('select[name=\'zone_id\']').load('index.php?r=account/address/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
</script>
<?php if ($config_js_security) { ?>
<script type="text/javascript" src="catalog/view/javascript/account_address.js"></script>
<?php } ?>
<?php echo $footer; ?> 