<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
  <div class="middle">
    <?php if ($addresses) { ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="address_1">
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_entries; ?></b>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table width="536">
          <?php foreach ($addresses as $address) { ?>
          <?php if ($address['address_id'] == $default) { ?>
          <tr>
            <td><input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" id="address_id[<?php echo $address['address_id']; ?>]" checked="checked" style="margin: 0px;"></td>
            <td><label for="address_id[<?php echo $address['address_id']; ?>]" style="cursor: pointer;"><?php echo $address['address']; ?></label></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" id="address_id[<?php echo $address['address_id']; ?>]" style="margin: 0px;"></td>
            <td><label for="address_id[<?php echo $address['address_id']; ?>]" style="cursor: pointer;"><?php echo $address['address']; ?></label></td>
          </tr>
          <?php } ?>
          <?php } ?>
        </table>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onClick="$('#address_1').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="address_2">
    <input type="hidden" name="company" value="<?php echo $company; ?>">
    <input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
    <input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_new_address; ?></b>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table>
          <tr>
            <td style="width:200px !important"><?php echo $entry_address_1; ?></td>
            <td><input class="input" type="text" name="address_1" id="address_11" value="<?php echo $address_1; ?>" title="Ingrese su direcci&oacute;n de habitaci&oacute;n o trabajo"><span class="required">*</span><img class="chequea" id="checkaddress_1" src="image/check.png">
              <?php if ($error_address_1) { ?>
              <span class="error" id="error_address_1"><?php echo $error_address_1; ?></span>
              <script>
				  $("#address_11").css({"border": "2px inset #F00","background":"#F66"});
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
            <td><select class="input" name="country_id" id="country_id" onchange="$('select[name=\'zone_id\']').load('index.php?r=account/create/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');" title="Seleccione el pa&iacute;s donde reside">
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
            <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onClick="$('#address_2').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>
 <script>
        $(function() {
        $("input").tooltip({
        	position: "center right",
        	offset: [-2, 10],
        	effect: "fade",
        	opacity: 0.9});
        });
		
    </script> 
<script type="text/javascript">
$('select[name=\'zone_id\']').load('index.php?r=checkout/address/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
</script>
<script>
$(document).ready(function() { 
	$("#captcha").focus(function(){
		$("#captcha").css({"border": "2px inset #AAA","background":"#FFF"});
	});
	$(".input input").css({"width": "200px"});
	$("#country_id").change(function(){		
		var string = $("#country_id").val();		
		if(string == 'false')	{
				$("#country_id").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkcountry_id").attr("src","image/unchecked.png");
				$("#zone_id").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkzone_id").attr("src","image/unchecked.png");
		} else {
				$("#country_id").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkcountry_id").attr("src","image/checked.png");	
				$("#error_country").remove();	
		}
	});	
	$("#zone_id").change(function(){		
		var string = $("#zone_id").val();		
		if(string == 'false')	{
				$("#zone_id").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkzone_id").attr("src","image/unchecked.png");
			} else {
				$("#zone_id").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkzone_id").attr("src","image/checked.png");	
				$("#error_zone").remove();	
		}
	});	
	$("#address_11").keyup(function(){		
		var string = $("#address_11").val();		
		if(string.length > 10)	{
			if(noCharsEspeciales(string))	{
				$("#address_11").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkaddress_1").attr("src","image/unchecked.png");	
			} else {
				$("#address_11").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkaddress_1").attr("src","image/checked.png");
				$("#error_address_1").remove();
			}			
		} else {
			$("#address_11").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkaddress_1").attr("src","image/unchecked.png");
		}
	});	
	$("#city").keyup(function(){		
		var string = $("#city").val();		
		if(string.length > 3)	{
			if(noCharsEspeciales(string))	{
				$("#city").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkcity").attr("src","image/unchecked.png");
			} else {
				$("#city").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkcity").attr("src","image/checked.png");	
				$("#error_city").remove();
			}			
		} else {
			$("#city").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkcity").attr("src","image/unchecked.png");
		}
	});	
});
function noCharsEspeciales(string) {
 	var pattern = new RegExp(/.[!"#\$%&\/\(\)=\?\|°¿\'\*¨´\+\}\{\^`\\\-_]/i);
 	return pattern.test(string);
}
$('#city').capitalize();
</script>
<?php echo $footer; ?> 