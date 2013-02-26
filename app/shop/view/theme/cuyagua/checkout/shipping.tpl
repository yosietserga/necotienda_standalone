<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
  <?php if (isset($mostrarError)) echo $mostrarError; ?>
  <div class="middle">
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="shipping">
      <h2><?php echo $text_shipping_address; ?></h2>
        <?php echo $address; ?><br><br>
        <div style="text-align: center;">
         <a title="<?php echo $button_change_address; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $change_address); ?>'" class="button"><span><?php echo $button_change_address; ?></span>
         </a>
         </div>
      <?php if ($shipping_methods) { ?>
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_shipping_method; ?></b>
      <div class="content">
        <p><?php echo $text_shipping_methods; ?></p>
        <table>
          <?php foreach ($shipping_methods as $shipping_method) { ?>
          <tr>
            <td colspan="3"><b><?php echo $shipping_method['title']; ?></b></td>
          </tr>
          <?php if (!$shipping_method['error']) { ?>
          <?php foreach ($shipping_method['quote'] as $quote) { ?>
          <tr>
            <td><label for="<?php echo $quote['id']; ?>">
                <?php if ($quote['id'] == $shipping || !$shipping) { ?>
				<?php $shipping = $quote['id']; ?>
                <input type="radio" name="shipping_method" value="<?php echo $quote['id']; ?>" id="<?php echo $quote['id']; ?>" checked="checked" style="margin: 0px;" title="Seleccione una forma de env&iacute;o">
                <?php } else { ?>
                <input type="radio" name="shipping_method" value="<?php echo $quote['id']; ?>" id="<?php echo $quote['id']; ?>" style="margin: 0px;" title="Seleccione una forma de env&iacute;o">
                <?php } ?>
              </label></td>
            <td width="534"><label for="<?php echo $quote['id']; ?>" style="cursor: pointer;"><?php echo $quote['title']; ?></label></td>
            <td class"tdtopright"><label for="<?php echo $quote['id']; ?>" style="cursor: pointer;"><?php echo $quote['text']; ?></label></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
          </tr>
          <?php } ?>
          <?php } ?>
        </table>
      </div>
      <?php } ?>
      <b style="margin-bottom: 2px; display: block;"><?php echo $text_comments; ?></b>
      <div class="content">
        <textarea name="comment" id="comment" rows="8" style="width: 99%;" title="Ingrese cualquier observaci&oacute;n o comentario que tenga sobre el pedido. No se permiten caracteres especiales"><?php echo $comment; ?></textarea>
      </div>
      <div class="buttons">
        <table>
          <tr>
            <td><a title="<?php echo $button_back; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
            <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onClick="$('#shipping').submit();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
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
});
function noCharsEspeciales(string) {
 	var pattern = new RegExp(/.[!"#\$%&\/\(\)=\?\|°¿\'\*¨´\+\}\{\^`\\\-_]/i);
 	return pattern.test(string);
}
$(function() {
$("#shipping :input").tooltip({
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