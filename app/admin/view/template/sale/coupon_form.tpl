<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="htabs">
        <?php foreach ($languages as $language) { ?>
        <a  tab="#language<?php echo $language['language_id']; ?>"><imgsrc="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"> <?php echo $language['name']; ?></a>
        <?php } ?>
      </div>
      <?php foreach ($languages as $language) { ?>
      <div id="language<?php echo $language['language_id']; ?>">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?><a title="<?php echo $help_name; ?>"> (?)</a></td>
            <td><input title="<?php echo $help_name; ?>" name="coupon_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($coupon_description[$language['language_id']]) ? $coupon_description[$language['language_id']]['name'] : ''; ?>">
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_description; ?><a title="<?php echo $help_description; ?>"> (?)</a></td>
            <td><textarea title="<?php echo $help_description; ?>" name="coupon_description[<?php echo $language['language_id']; ?>][description]" cols="40" rows="5"><?php echo isset($coupon_description[$language['language_id']]) ? $coupon_description[$language['language_id']]['description'] : ''; ?></textarea>
              <?php if (isset($error_description[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
        </table>
      </div>
      <?php } ?>
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_code; ?><a title="<?php echo $help_code; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_code; ?>" name="code" value="<?php echo $code; ?>">
            <?php if ($error_code) { ?>
            <span class="error"><?php echo $error_code; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_type; ?><a title="<?php echo $help_type; ?>"> (?)</a></td>
          <td><select title="<?php echo $help_type; ?>" name="type">
              <?php if ($type == 'P') { ?>
              <option value="P" selected="selected"><?php echo $text_percent; ?></option>
              <?php } else { ?>
              <option value="P"><?php echo $text_percent; ?></option>
              <?php } ?>
              <?php if ($type == 'F') { ?>
              <option value="F" selected="selected"><?php echo $text_amount; ?></option>
              <?php } else { ?>
              <option value="F"><?php echo $text_amount; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_discount; ?><a title="<?php echo $help_discount; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_discount; ?>" name="discount" value="<?php echo $discount; ?>"></td>
        </tr>
        <input  type="hidden" name="total" value="0">
        <!-- 
        <tr>
          <td><?php echo $entry_total; ?><a title="Total"> (?)</a></td>
          <td><input  type="text" name="total" value="<?php echo $total; ?>"></td>
        </tr>
        
        <tr>
          <td><?php echo $entry_logged; ?><a title="<?php echo $help_logged; ?>"> (?)</a><br><span class="help"><?php echo $help_logged; ?></span></td>
          <td><?php if ($logged) { ?>
            <input  type="radio" name="logged" value="1" checked="checked">
            <?php echo $text_yes; ?>
            <input  type="radio" name="logged" value="0">
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input  type="radio" name="logged" value="1">
            <?php echo $text_yes; ?>
            <input  type="radio" name="logged" value="0" checked="checked">
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_shipping; ?><a title="<?php echo $help_shipping; ?>"> (?)</a></td>
          <td><?php if ($shipping) { ?>
            <input  type="radio" name="shipping" value="1" checked="checked">
            <?php echo $text_yes; ?>
            <input  type="radio" name="shipping" value="0">
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input  type="radio" name="shipping" value="1">
            <?php echo $text_yes; ?>
            <input  type="radio" name="shipping" value="0" checked="checked">
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_product; ?><a title="<?php echo $help_product; ?>"> (?)</a></td>
          <td><table>
              <tr>
                <td style="padding: 0;" colspan="3"><select id="category" style="margin-bottom: 5px;" onChange="getProducts();">
                    <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
              <tr id="product_form">
                <td style="padding: 0;"><select multiple="multiple" id="product" size="10" style="width: 200px;">
                  </select></td>
                <td style="vertical-align: middle;"><input  type="button" value="--&gt;" onclick="addProduct();">
                  <br>
                  <input  type="button" value="&lt;--" onclick="removeProduct();"></td>
                <td style="padding: 0;"><select multiple="multiple" id="coupon" size="10" style="width: 200px;">
                  </select></td>
              </tr>
            </table>
            <div id="coupon_product">
              <?php foreach ($coupon_product as $product_id) { ?>
              <input  type="hidden" name="coupon_product[]" value="<?php echo $product_id; ?>">
              <?php } ?>
            </div></td>
        </tr>
        <tr>
          <td><?php echo $entry_date_start; ?><a title="<?php echo $help_date_start; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_date_start; ?>" type="date" name="date_start" value="<?php echo $date_start; ?>" size="12" id="date_start"></td>
        </tr>
        <tr>
          <td><?php echo $entry_date_end; ?><a title="<?php echo $help_date_end; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_date_end; ?>" type="date" name="date_end" value="<?php echo $date_end; ?>" size="12" id="date_end"></td>
        </tr>
        <tr>
          <td><?php echo $entry_uses_total; ?><a title="<?php echo $help_uses_total; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_uses_total; ?>" type="number" name="uses_total" value="<?php echo $uses_total; ?>"></td>
        </tr>
        <tr>
          <td><?php echo $entry_uses_customer; ?><a title="<?php echo $help_uses_customer; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_uses_customer; ?>" type="number" name="uses_customer" value="<?php echo $uses_customer; ?>"></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="<?php echo $help_status; ?>"> (?)</a></td>
          <td><select title="<?php echo $help_status; ?>" name="status">
              <?php if ($status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript">
function addProduct() {
	$('#product :selected').each(function() {
		$(this).remove();
		
		$('#coupon option[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#coupon').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');
		
		$('#coupon_product input[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#coupon_product').append('<input  type="hidden" name="coupon_product[]" value="' + $(this).attr('value') + '">');
	});
}

function removeProduct() {
	$('#coupon :selected').each(function() {
		$(this).remove();
		
		$('#coupon_product input[value=\'' + $(this).attr('value') + '\']').remove();
	});
}

function getProducts() {
	$('#product option').remove();
	
	$.ajax({
		url: 'index.php?r=sale/coupon/category&token=<?php echo $token; ?>&category_id=' + $('#category').attr('value'),
		dataType: 'html',
		type: 'get',
        beforeSend: function() {
            $('#add_product').remove();
        },
		success: function(data) {
		  data = data.substr(2);
		  data = $.trim(data);      
            if (data == 1) {                
                $('#category').after('<p id="add_product">No hay productos en esta categor&iacute;a. <a href="<?php echo HTTP_HOME; ?>index.php?r=store/product&token=<?php echo $_GET['token']; ?>">&iquest;Desea agregar alguno ahora?</a></p>');
                $('#product_form').fadeOut();
            } else {
                $('#product').append(data);
                $('#product_form').fadeIn();
            }
		}
	});
}

function getProduct() {
	$('#coupon option').remove();
	
	$.ajax({
		url: 'index.php?r=sale/coupon/product&token=<?php echo $token; ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#coupon_product input'),
		success: function(data) {
			$('#coupon_product input').remove();
			
			for (i = 0; i < data.length; i++) {
	 			$('#coupon').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + '</option>');
				
				$('#coupon_product').append('<input  type="hidden" name="coupon_product[]" value="' + data[i]['product_id'] + '">');
			} 
		}
	});
}

getProducts();
getProduct();
</script>
<script type="text/javascript">
$(function() {
	$('#date_start').datepicker({dateFormat: 'dd-mm-yy'});
	$('#date_end').datepicker({dateFormat: 'dd-mm-yy'});
	jQuery('input[type=text]').css({'width':'250px'});
	jQuery('select').css({'width':'250px'});
});
</script>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<script type="text/javascript">
$.tabs('.htabs a'); 
</script>
<?php echo $footer; ?>