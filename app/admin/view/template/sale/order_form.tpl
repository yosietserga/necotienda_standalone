<?php echo $header; ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/order.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="window.open('<?php echo $invoice; ?>');" class="button"><span><?php echo $button_invoice; ?></span></a><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%;">
      <div class="vtabs"><a  tab="#tab_order"><?php echo $tab_order; ?></a><a  tab="#tab_product"><?php echo $tab_product; ?></a><a  tab="#tab_shipping"><?php echo $tab_shipping; ?></a><a  tab="#tab_payment"><?php echo $tab_payment; ?></a><a  tab="#tab_history"><?php echo $tab_history; ?></a></div>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab_order" class="vtabs_page">
        <table class="form">
          <tr>
            <td><?php echo $entry_order_id; ?><a title="N&uacute;mero de correlativo del pedido"> (?)</a></td>
            <td>#<?php echo $order_id; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_invoice_id; ?><a title="N&uacute;mero de correlativo de la Factura"> (?)</a></td>
            <td id="invoice"><?php if ($invoice_id) { ?>
              <?php echo $invoice_id; ?>
              <?php } else { ?>
              <a  id="generate_button" class="button"><span><?php echo $button_generate; ?></span></a><a title="Genera Factura. Para poder ver e imprimir la factura, haga clic en el bot&oacute;n Pedido"> (?)</a>
              <?php } ?></td>
          </tr>
          <?php if ($customer) { ?>
          <tr>
            <td><?php echo $entry_name; ?><a title="Nombre de contacto del cliente"> (?)</a></td>
            <td><a  href="<?php echo $customer; ?>"><?php echo $firstname; ?> <?php echo $lastname; ?></a></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><?php echo $entry_name; ?><a title="Nombre de contacto del cliente"> (?)</a></td>
            <td><?php echo $firstname; ?> <?php echo $lastname; ?></td>
          </tr>
          <?php } ?>
          <?php if ($customer) { ?>
          <tr>
            <td><?php echo $entry_customer; ?><a title="Raz&oacute;n social del cliente"> (?)</a></td>
            <td><a  href="<?php echo $customer; ?>"><?php echo $company; ?></a></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><?php echo $entry_customer; ?><a title="Raz&oacute;n social del cliente"> (?)</a></td>
            <td><?php echo $company; ?></td>
          </tr>
          <?php } ?>
          <?php if ($customer_group) { ?>
          <tr>
            <td><?php echo $entry_customer_group; ?><a title="Grupo del cliente"> (?)</a></td>
            <td><?php echo $customer_group; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $entry_email; ?><a title="Email del cliente. Esto solo afecta a la informaci&oacute;n del pedido y no al perfil de usuario del cliente"> (?)</a></td>
            <td><input  type="text" name="email" value="<?php echo $email; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_telephone; ?><a title="Tel&eacute;fono del cliente. Esto solo afecta a la informaci&oacute;n del pedido y no al perfil de usuario del cliente"> (?)</a></td>
            <td><input  type="text" name="telephone" value="<?php echo $telephone; ?>"></td>
          </tr>
          <?php if ($fax) { ?>
          <tr>
            <td><?php echo $entry_fax; ?><a title="Fax del cliente. Esto solo afecta a la informaci&oacute;n del pedido y no al perfil de usuario del cliente"> (?)</a></td>
            <td><input  type="text" name="fax" value="<?php echo $fax; ?>"></td>
          </tr>
          <?php } ?>
		  <tr>
            <td><?php echo $entry_ip; ?><a title="La direcci&oacute;n IP del cliente desde donde hizo el pedido"> (?)</a></td>
            <td><?php echo $ip; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_store_name; ?><a title="La tienda desde donde el cliente hizo el pedido"> (?)</a></td>
            <td><?php echo $store_name; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_store_url; ?><a title="La direcci&oacute;n web de la tienda desde donde el cliente hizo el pedido"> (?)</a></td>
            <td><a  onclick="window.open('<?php echo $store_url; ?>');"><u><?php echo $store_url; ?></u></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_date_added; ?><a title="Fecha cuando se cre&oacute; el pedido"> (?)</a></td>
            <td><?php echo $date_added; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_shipping_method; ?><a title="Forma de env&iacute;o del pedido"> (?)</a></td>
            <td><input  type="text" name="shipping_method" value="<?php echo $shipping_method; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_payment_method; ?><a title="Forma de pago del pedido."> (?)</a></td>
            <td><input  type="text" name="payment_method" value="<?php echo $payment_method; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_total; ?><a title="Total a pagar por el cliente para este pedido"> (?)</a></td>
            <td><?php echo $total; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?><a title="Estado del pedido"> (?)</a></td>
            <td id="order_status"><?php echo $order_status; ?></td>
          </tr>
          <?php if ($comment) { ?>
          <tr>
            <td><?php echo $entry_comment; ?><a title="Observaciones del pedido"> (?)</a></td>
            <td><?php echo $comment; ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
      <div id="tab_product" class="vtabs_page">
        <table id="products" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $column_product; ?></td>
              <td class="right"><?php echo $column_quantity; ?></td>
              <td class="right"><?php echo $column_price; ?></td>
              <td class="right" width="1"><?php echo $column_total; ?></td>
            </tr>
          </thead>
          
          <?php $order_product_row = 0; ?>
          <?php foreach ($order_products as $order_product) { ?>
          <tbody id="product_<?php echo $order_product_row; ?>">
            <tr>
              <td class="left"><span title="Eliminar Producto" class="remove" onclick="$('#product_<?php echo $order_product_row; ?>').remove();">&nbsp;</span>&nbsp;&nbsp;<a title="Ver Producto" href="<?php echo $order_product['href']; ?>"><?php echo $order_product['name']; ?> (<?php echo $order_product['model']; ?>)</a>
                <input  type="hidden" name="product[<?php echo $order_product_row; ?>][product_id]" value="<?php echo $order_product['product_id']; ?>">
                <?php foreach ($order_product['option'] as $option) { ?>
                <br>
                &nbsp;<small> - <?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                <?php } ?></td>
              <td class="right"><input  type="text" name="product[<?php echo $order_product_row; ?>][quantity]" value="<?php echo $order_product['quantity']; ?>" size="4"></td>
              <td class="right"><input  type="text" name="product[<?php echo $order_product_row; ?>][price]" value="<?php echo $order_product['price']; ?>"></td>
              <td class="right"><input  type="text" name="product[<?php echo $order_product_row; ?>][total]" value="<?php echo $order_product['total']; ?>"></td>
            </tr>
          </tbody>
          <?php $order_product_row++ ?>
          <?php } ?>
          
          <tbody id="totals">
          <?php $order_total_row = 0; ?>
          <?php foreach ($totals as $totals) { ?>
            <tr>
              <td colspan="3" class="right"><span style="text-align:right;"><?php echo $totals['title']; ?></span></td>
              <td class="right"><input  type="text" name="totals[<?php echo $totals['order_total_id']; ?>]" value="<?php echo $totals['text']; ?>"></td>
            </tr>
          <?php $order_total_row++ ?>
          <?php } ?>
          </tbody>
        </table>
        <?php if ($downloads) { ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left"><b><?php echo $column_download; ?></b></td>
              <td class="left"><b><?php echo $column_filename; ?></b></td>
              <td class="right"><b><?php echo $column_remaining; ?></b></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($downloads as $download) { ?>
            <tr>
              <td class="left"><?php echo $download['name']; ?></td>
              <td class="left"><?php echo $download['filename']; ?></td>
              <td class="right"><?php echo $download['remaining']; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php } ?>
        <table>
          <tr>
		    <td><?php echo $entry_add_product; ?><br>
		      <table>
			    <tr>
			      <td style="padding: 0;" colspan="3"><select id="category" style="margin-bottom: 5px;" onChange="getProducts();">
			        <?php foreach ($categories as $category) { ?>
			        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
			        <?php } ?>
			        </select></td>
			    </tr>
			    <tr>
			      <td style="padding: 0;">
			        <select multiple="multiple" id="product" size="10" style="width: 350px;">
			        </select>
			      </td>
			      <td style="vertical-align: middle;"><span class="add" onclick="addProduct();">&nbsp;</span></td>
			    </tr>
		    </table>
		  </tr>
		</table>
      </div>
      <div id="tab_shipping" class="vtabs_page">
      <input  type="hidden" name="shipping_firstname" value="<?php echo $shipping_firstname; ?>">
      <input  type="hidden" name="shipping_lastname" value="<?php echo $shipping_lastname; ?>">
      <input  type="hidden" name="shipping_company" value="<?php echo $shipping_company; ?>">
        <table class="form">
          <tr>
            <td><?php echo $entry_address_1; ?><a title="Ingrese la direcci&oacute;n principal de env&iacute;o del cliente"> (?)</a></td>
            <td><input  type="text" name="shipping_address_1" value="<?php echo $shipping_address_1; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_2; ?><a title="Ingrese la direcci&oacute;n alterna de env&iacute;o del cliente"> (?)</a></td>
            <td><input  type="text" name="shipping_address_2" value="<?php echo $shipping_address_2; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_city; ?><a title="Ingrese la ciudad de env&iacute;o del cliente"> (?)</a></td>
            <td><input  type="text" name="shipping_city" value="<?php echo $shipping_city; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_postcode; ?><a title="Ingrese c&oacute;digo postal de env&iacute;o del cliente"> (?)</a></td>
            <td><input  type="text" name="shipping_postcode" value="<?php echo $shipping_postcode; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_country; ?><a title="Seleccione el pa&iacute;s de env&iacute;o del cliente"> (?)</a></td>
            <td><select name="shipping_country_id" id="shipping_country" onChange="$('#shipping_zone').load('index.php?r=sale/order/zone&token=<?php echo $token; ?>&country_id=' + this.value + '&zone_id=<?php echo $shipping_zone_id; ?>&type=shipping_zone');">
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $shipping_country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <input  type="hidden" name="shipping_country" value="<?php echo $shipping_country; ?>">
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?><a title="Seleccione el Estado/Provincia/Departamento de env&iacute;o del cliente"> (?)</a></td>
            <td id="shipping_zone"></td>
          </tr>
        </table>
      </div>
      <div id="tab_payment" class="vtabs_page">
      <input  type="hidden" name="payment_firstname" value="<?php echo $payment_firstname; ?>">
      <input  type="hidden" name="payment_lastname" value="<?php echo $payment_lastname; ?>">
      <input  type="hidden" name="payment_company" value="<?php echo $payment_company; ?>">
        <table class="form">
          <tr>
            <td><?php echo $entry_address_1; ?><a title="Ingrese la direcci&oacute;n principal de pago del cliente"> (?)</a></td>
            <td><input  type="text" name="payment_address_1" value="<?php echo $payment_address_1; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_2; ?><a title="Ingrese la direcci&oacute;n alterna de pago del cliente"> (?)</a></td>
            <td><input  type="text" name="payment_address_2" value="<?php echo $payment_address_2; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_city; ?><a title="Ingrese la ciudad de pago del cliente"> (?)</a></td>
            <td><input  type="text" name="payment_city" value="<?php echo $payment_city; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_postcode; ?><a title="Ingrese c&oacute;digo postal de pago del cliente"> (?)</a></td>
            <td><input  type="text" name="payment_postcode" value="<?php echo $payment_postcode; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_country; ?><a title="Seleccione el pa&iacute;s de pago del cliente"> (?)</a></td>
            <td><select name="payment_country_id" id="payment_country" onChange="$('#payment_zone').load('index.php?r=sale/order/zone&token=<?php echo $token; ?>&country_id=' + this.value + '&zone_id=<?php echo $payment_zone_id; ?>&type=payment_zone');">
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $payment_country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <input  type="hidden" name="payment_country" value="<?php echo $payment_country; ?>">
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?><a title="Seleccione el Estado/Provincia/Departamento de pago del cliente"> (?)</a></td>
            <td id="payment_zone"></td>
          </tr>
        </table>
      </div>
      <div id="tab_history" class="vtabs_page">
        <?php foreach ($histories as $history) { ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left" width="33.3%"><b><?php echo $column_date_added; ?></b></td>
              <td class="left" width="33.3%"><b><?php echo $column_status; ?></b></td>
              <td class="left" width="33.3%"><b><?php echo $column_notify; ?></b></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left"><?php echo $history['date_added']; ?></td>
              <td class="left"><?php echo $history['status']; ?></td>
              <td class="left"><?php echo $history['notify']; ?></td>
            </tr>
          </tbody>
          <?php if ($history['comment']) { ?>
          <thead>
            <tr>
              <td class="left" colspan="3"><b><?php echo $column_comment; ?></b></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left" colspan="3"><?php echo $history['comment']; ?></td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
        <?php } ?>
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?><a title="Cambiar el estado del pedido. Para hacer efectivo el cambio debe hacer clic en el Bot&oacute;n 'A&ntilde;adir Historia'"> (?)</a></td>
            <td><select name="order_status_id">
                <option value="0"><?php echo $text_none; ?></option>
				<?php foreach ($order_statuses as $order_statuses) { ?>
                <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_notify; ?><a title="Notitificar al cliente del cambio del estado del pedido"> (?)</a></td>
            <td><input  type="checkbox" name="notify" value="1"></td>
          </tr>
          <tr>
            <td><?php echo $entry_append; ?><a title="Seleccione si desea anexar a la historia del pedido. Si lo selecciona, todos los cambios realizados se agregar&aacute;n a la historia del pedido sino, simplemente se actualizar&aacute;n los datos"> (?)</a></td>
            <td><input  type="checkbox" name="append" value="1" checked="checked"></td>
          </tr>
          <tr>
            <td><?php echo $entry_comment; ?><a title="Agregue cualquier observaci&oacute;n o comentario sobre el pedido"> (?)</a></td>
            <td><textarea name="comment" cols="40" rows="8" style="width: 99%"></textarea>
              <div style="margin-top: 10px; text-align: right;"><a  onclick="history();" id="history_button" class="button"><span><?php echo $button_add_history; ?></span></a></div></td>
          </tr>
        </table>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var order_product_row = <?php echo $order_product_row; ?>;

function addProduct() {

	$('#product :selected').each(function() {

		html  = '<tbody id="product_' + order_product_row + '">';
		html += '<tr>';
	    html += '<td class="left">';
	    html += '<input  type="hidden" name="product[' + order_product_row + '][product_id]" value="' + $(this).attr('value') + '">';
	    html += '<span onclick="$(\'#product_' + order_product_row + '\').remove();" class="remove">&nbsp;</span>';
	    html += '<a  href="<?php echo HTTP_HOME . "index.php?r=store/product/update&product_id="; ?>' + $(this).attr('value') + '&token=<?php echo $token; ?>">' + $(this).attr('text') + '</a>';
	    html += '</td>';
	    html += '<td class="right"><input  type="text" name="product[' + order_product_row + '][quantity]" value="" size="4"></td>';
	    html += '<td class="right"><input  type="text" name="product[' + order_product_row + '][price]" value=""></td>';
	    html += '<td class="right"><input  type="text" name="product[' + order_product_row + '][total]" value=""></td>';
	    html += '</tr>';
	    html += '</tbody>';
	    
		$('#totals').before(html);
			
		order_product_row++;
	});
}
</script>
<script type="text/javascript">
function getProducts() {
	$('#product option').remove();
	
	$.ajax({
		url: 'index.php?r=sale/order/category&token=<?php echo $token; ?>&category_id=' + $('#category').attr('value'),
		dataType: 'json',
		success: function(data) {
			for (i = 0; i < data.length; i++) {
	 			$('#product').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' (' + data[i]['model'] + ') </option>');
			}
		}
	});
}

getProducts();
</script>
<script type="text/javascript">
$('#payment_zone select').live('change', function() {
	$('#payment_zone_name').remove();
	$('#payment_zone select').after('<input  id="payment_zone_name" name="payment_zone" value="' + $('#payment_zone select :selected').text() + '" type="hidden">');
});
$('#shipping_zone select').live('change', function() {
	$('#shipping_zone_name').remove();
	$('#shipping_zone select').after('<input  id="shipping_zone_name" name="shipping_zone" value="' + $('#shipping_zone select :selected').text() + '" type="hidden">');
});
</script>
<script type="text/javascript">
$('#generate_button').click(function() {
	$.ajax({
		url: 'index.php?r=sale/order/generate&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#generate_button').attr('disabled', 'disabled');
		},		
		complete: function() {
			$('#generate_button').attr('disabled', '');
		},		
		success: function(data) {
			if (data) {
				$('#generate_button').fadeOut('slow');
   	            $('#invoice').html(data);
			}
		}
	});
});


function history() {
	$.ajax({
		type: 'POST',
		url: 'index.php?r=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + encodeURIComponent($('input[name=\'notify\']').attr('checked') ? 1 : 0) + '&append=' + encodeURIComponent($('input[name=\'append\']').attr('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#history_button').attr('disabled', 'disabled');
			$('#tab_history .form').before('<div class="attention"><imgsrc="image/loading_1.gif"> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#history_button').attr('disabled', '');
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#tab_history .form').before('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success && $('input[name=\'append\']').attr('checked')) {
				html  = '<div class="history" style="display: none;">';
				html += '  <table class="list">';
				html += '    <thead>';
				html += '      <tr>';
				html += '        <td class="left" width="33.3%"><b><?php echo $column_date_added; ?></b></td>';
				html += '        <td class="left" width="33.3%"><b><?php echo $column_status; ?></b></td>';
				html += '        <td class="left" width="33.3%"><b><?php echo $column_notify; ?></b></td>';
				html += '      </tr>';
				html += '    </thead>';
				html += '    <tbody>';
				html += '      <tr>';
				html += '        <td class="left">' + data.date_added + '</td>';
				html += '        <td class="left">' + data.order_status + '</td>';
				html += '        <td class="left">' + data.notify + '</td>';
				html += '      </tr>';
				html += '    </tbody>';
				
				if (data.comment) { 
					html += '    <thead>';
					html += '      <tr>';
					html += '        <td class="left" colspan="3"><b><?php echo $column_comment; ?></b></td>';
					html += '      </tr>';
					html += '    </thead>';
					html += '    <tbody>';
					html += '      <tr>';
					html += '        <td class="left" colspan="3">' + data.comment + '</td>';
					html += '      </tr>';
					html += '    </tbody>';	
				}
				
				html += '  </table>';	
				html += '</div>';	
				
				$('#order_status').html(data.status);
				
				$('#tab_history .form').before(html);
				
				$('#tab_history .history').slideDown();
				
				$('#tab_history .form').before('<div class="success">' + data.success + '</div>');

				$('textarea[name=\'comment\']').val('');
			}
		}
	});
}
</script>
<script type="text/javascript">
$(function() {
	$('.date').datepicker({dateFormat: 'dd-mm-yy'});
});
</script>
<script type="text/javascript">
$('#shipping_zone').load('index.php?r=sale/order/zone&token=<?php echo $token; ?>&country_id=<?php echo $shipping_country_id; ?>&zone_id=<?php echo $shipping_zone_id; ?>&type=shipping_zone');
$('#payment_zone').load('index.php?r=sale/order/zone&token=<?php echo $token; ?>&country_id=<?php echo $payment_country_id; ?>&zone_id=<?php echo $payment_zone_id; ?>&type=payment_zone');
</script>
<script type="text/javascript">
$.tabs('.vtabs a'); 
</script>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>