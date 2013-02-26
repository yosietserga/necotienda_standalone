<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
  <div class="middle">
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <h2><?php echo $text_payment_address; ?></h2>
      <?php echo $address; ?><br><br>
       <div style="text-align: center;">
            <a title="<?php echo $button_change_address; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $change_address); ?>'" class="button"><span><?php echo $button_change_address; ?></span></a>
      </div><br>
    <?php if ($coupon_status) { ?>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="coupon">
        <p><?php echo $text_coupon; ?></p>
        <div style="text-align: right;"><?php echo $entry_coupon; ?>&nbsp;
        <input type="text" name="coupon" value="<?php echo $coupon; ?>">
        &nbsp;<a title="<?php echo $button_coupon; ?>" onClick="$('#coupon').submit();" class="button"><span><?php echo $button_coupon; ?></span></a></div>
      </form>
    </div>
    <?php } ?>
	<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="payment">
      <?php if ($payment_methods) { ?>
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_payment_method; ?></b>
      <div class="content">
        <p><?php echo $text_payment_methods; ?></p>
        <table>
          <?php foreach ($payment_methods as $payment_method) { ?>
          <tr>
            <td>
              <?php if ($payment_method['id'] == $payment || !$payment) { ?>
			  <?php $payment = $payment_method['id']; ?>
              <input type="radio" name="payment_method" value="<?php echo $payment_method['id']; ?>" id="<?php echo $payment_method['id']; ?>" checked="checked" style="margin: 0px;" title="Seleccione una forma de pago">
              <?php } else { ?>
              <input type="radio" name="payment_method" value="<?php echo $payment_method['id']; ?>" id="<?php echo $payment_method['id']; ?>" style="margin: 0px;" title="Seleccione una forma de pago">
              <?php } ?></td>
            <td><label for="<?php echo $payment_method['id']; ?>" style="cursor: pointer;"><?php echo $payment_method['title']; ?></label></td>
          </tr>
          <?php } ?>
        </table>
      </div>
      <?php } ?>
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_comments; ?></b>
      <div class="content">
        <textarea name="comment" rows="8" style="width: 99%;" title="Ingrese cualquier observaci&oacute;n o comentario que tenga sobre el pedido. No se permiten caracteres especiales"><?php echo $comment; ?></textarea>
      </div>
      <?php if ($text_agree) { ?>
      <div class="buttons">
      <table>
          <tr  id="agree">
            <td><a title="<?php echo $button_back; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td class="tdAgree"><?php echo $text_agree; ?></td>
            <td class="tdAgree"><?php if ($agree) { ?>
              <input type="checkbox" name="agree"id="agree_field" value="1" checked="checked" title="Al hacer clic aqu&iacute; hago constancia de que he le&iacute;do y estoy completamente de acuerdo con las pol&iacute;ticas y condiciones de uso aplicadas en esta tienda" style="width:20px !important">
              <?php } else { ?>
              <input type="checkbox" name="agree" id="agree_field" value="1" title="Al hacer clic aqu&iacute; hago constancia de que he le&iacute;do y estoy completamente de acuerdo con las pol&iacute;ticas y condiciones de uso aplicadas en esta tienda" style="width:20px !important">
              <?php } ?></td>
              <?php if ($error_warning) { ?>
				<script>
                    $("#agree").css({"border": "2px inset #F00","background":"#F66"});
                </script>
              <?php } ?>
            <td style="text-align:right;width:5px;"><a title="<?php echo $button_continue; ?>" onClick="$('#payment').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } else { ?>
      <div class="buttons">
        <table>
          <tr>
            <td><a title="<?php echo $button_back; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onClick="$('#payment').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
      <?php } ?>
    </form>
  </div>
</div>
<script>
$(document).ready(function() {
	$("#comment").keyup(function(){		
		var string = $("#comment").val();	
			if(noCharsEspeciales(string))	{
				$("#comment").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});
			} else {
				$("#comment").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});
			}
	});		
	$("#agree").change(function(){		
		var string = $("#agree_field").val();		
		if(string != 1)	{
				$("#agree").css({
					"border": "2px inset #F00",
					"background":"#F66"
				});	
			} else {
				$("#agree").css({
					"border": "2px inset #0C0",
					"background":"#A7EBBE"
				});		
		}
	});	
});
function noCharsEspeciales(string) {
 	var pattern = new RegExp(/.[!"#\$%&\/\(\)=\?\|°¿\'\*¨´\+\}\{\^`\\\-_]/i);
 	return pattern.test(string);
}
$(function() {
$("#payment :input").tooltip({
      position: "center right",
      offset: [-2, 10],
      effect: "fade",
      opacity: 0.9});
});
$("#comment").counter({
      type: 'char',
      goal: 140,
      count: 'up'            
});
</script>
<?php echo $footer; ?> 