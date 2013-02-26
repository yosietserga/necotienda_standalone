<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
  <h1><?php echo $heading_title; ?></h1>
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
  <div class="middle">
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="contact">
    <?php echo isset($fkey)? $fkey : ''; ?>
      <div class="content">
        <div style="display: inline-block; width: 100%;">
            <h1><?php echo $store; ?></h1><br>
            <b><?php echo $text_address; ?></b><br>            
            <?php echo $address; ?></div><br> <br> 
            <?php if ($telephone) { ?>
            <b><?php echo $text_telephone; ?></b><br>
            <?php echo $telephone; ?><br>
            <br>
            <?php } ?>
            <?php if ($fax) { ?>
            <b><?php echo $text_fax; ?></b><br>
            <?php echo $fax; ?>
            <?php } ?>
      </div>
      <div class="content">
        <table>
          <tr>
            <td><?php echo $entry_name; ?><br>
              <input type="text" name="name" id="name" value="<?php echo $name; ?>" title="Por favor ingrese su nombre completo. No se permiten n&uacute;meros ni caracteres especiales"><span class="required">*</span><img class="chequea" id="checkname" src="image/check.png">
              <?php if ($error_name) { ?>
              <span class="error" id="error_name"><?php echo $error_name; ?></span>
              <script>
				  $("#name").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkname").attr("src","image/unchecked.png");
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?><br>
              <input type="text" name="email" id="email" value="<?php echo $email; ?>" title="Ingrese su email, &eacute;ste ser&aacute; verificado contra su servidor para validarlo"><span class="required">*</span><img class="chequea" id="checkemail" src="image/check.png">
              <?php if ($error_email) { ?>
              <span class="error" id="error_email"><?php echo $error_email; ?></span>
              <script>
				  $("#email").css({"border": "2px inset #F00","background":"#F66"});
				  $("#checkemail").attr("src","image/unchecked.png");
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_enquiry; ?><br>
              <textarea name="enquiry" id="enquiry" style="width: 99%;" rows="10" title="Por favor ingrese su mensaje, debe tener al menos 25 caracteres, no se permiten caracteres especiales y solo se aceptan un m&aacute;ximo de 255 caracteres"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <span class="error" id="error_enquiry"><?php echo $error_enquiry; ?></span>
              <script>
				  $("#enquiry").css({"border": "2px inset #F00","background":"#F66"});
                </script>
              <?php } ?></td>
          </tr>
          <tr>
            <td><br><?php echo $entry_captcha; ?><br>
              <input type="text" name="captcha" id="captcha" value="<?php echo $captcha; ?>" autocomplete="off" title="Por favor ingrese el c&oacute;digo de verificaci&oacute;n">
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
            <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onClick="$('#contact').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>
<script> 
$(document).ready(function() {
	$("#captcha").focus(function(){
		$("#captcha").css({"border": "2px inset #AAA","background":"#FFF"});
		$("#error_captcha").remove();
	});
	$("#create input").css({"width": "200px"});
	$("#email").keyup(function(){		
		var string = $("#email").val();		
		if(string != 0)	{
			if(esEmail(string))	{
				$("#email").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkemail").attr("src","image/checked.png");
				$("#error_email").remove();
			} else {
				$("#email").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkemail").attr("src","image/unchecked.png");				
			}
		}
	});	
	$("#enquiry").keyup(function(){		
		var string = $("#enquiry").val();		
		if(string.length > 25)	{
			if(noCharsEspeciales(string))	{
				$("#enquiry").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkenquiry").attr("src","image/unchecked.png");
			} else {
				$("#enquiry").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkcity").attr("src","image/checked.png");	
				$("#error_enquiry").remove();
			}			
		} else {
			$("#enquiry").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkenquiry").attr("src","image/unchecked.png");
		}
	});
	$("#name").keyup(function(){		
		var string = $("#name").val();		
		if(string.length > 3)	{
			if(noCharsEspeciales(string))	{
				$("#name").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkname").attr("src","image/unchecked.png");
			} else {
				$("#name").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkname").attr("src","image/checked.png");
				$("#error_name").remove();
			}
			if(isOnlyChar(string))	{
				$("#name").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
				$("#checkname").attr("src","image/checked.png");
				$("#error_name").remove();
			} else {
				$("#name").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkname").attr("src","image/unchecked.png");
			}
		}  else {
			$("#name").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
				$("#checkfname").attr("src","image/unchecked.png");
		}
	});	
});
function esEmail(string) {
 	var pattern = new RegExp(/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,3})|(aero|coop|info|museum|name))$/i);
 	return pattern.test(string);
}
function isOnlyChar(string) {
 	var pattern = new RegExp(/^\D+$/i);
 	return pattern.test(string);
}
function noCharsEspeciales(string) {
 	var pattern = new RegExp(/.[!"#\$%&\/\(\)=\?\|°¿\'\*¨´\+\}\{\^`\\\-_]/i);
 	return pattern.test(string);
}
$(function() {
$("#contact :input").tooltip({
      position: "center right",
      offset: [-2, 10],
      effect: "fade",
      opacity: 0.9});
});
        
$("#enquiry").counter({
      type: 'char',
      goal: 255,
      count: 'up'            
});
$('#name').capitalize();
</script> 
<?php echo $footer; ?> 