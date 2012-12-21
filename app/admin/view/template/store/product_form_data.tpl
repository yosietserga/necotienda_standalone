<div>
    <div class="row">
        <label><?php echo $entry_model; ?></label>
        <input title="<?php echo $help_model; ?>" name="model" value="<?php echo $model; ?>" required="true" />
    </div>
                                          
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_price; ?></label>
        <input type="money" title="<?php echo $help_price; ?>" name="price" value="<?php echo $price; ?>" />
    </div>
                                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_tax_class; ?></label>
        <select name="tax_class_id" title="<?php echo $help_tax_class; ?>">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($tax_classes as $tax_class) { ?>
            <option value="<?php echo $tax_class['tax_class_id']; ?>"<?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?> selected="selected"<?php } ?>><?php echo $tax_class['title']; ?></option>
            <?php } ?>
        </select>
    </div>
                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_quantity; ?></label>
        <input type="number" title="<?php echo $help_quantity; ?>" name="quantity" value="<?php echo $quantity; ?>" />
    </div>
                                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_minimum; ?></label>
        <input type="number" title="<?php echo $help_minimum; ?>" name="minimum" value="<?php echo $minimum; ?>" />
    </div>
                                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_image; ?></label>
        <img src="<?php echo $preview; ?>" id="preview" class="image" onclick="image_upload('image', 'preview');" />
        <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
        <br />
        <a onclick="image_upload('image', 'preview');" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
        <a onclick="image_delete('image', 'preview');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
    </div>
                            
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_date_available; ?></label>
        <input type="date" title="<?php echo $help_date_available; ?>" name="date_available" value="<?php echo $date_available; ?>" />
    </div>
                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_stock_status; ?></label>
        <select title="<?php echo $help_stock_status; ?>" name="stock_status_id">
        <?php foreach ($stock_statuses as $stock_status) { ?>
            
            <option value="<?php echo $stock_status['stock_status_id']; ?>"<?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?> selected="selected"<?php } ?>><?php echo $stock_status['name']; ?></option>
        <?php } ?>
        </select>
    </div>
    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_keyword; ?>(<b style="font:normal 10px verdana;color:#999;"><?php echo HTTP_CATALOG; ?>/</b>)</label>
        <input type="text" title="<?php echo $help_keyword; ?>" name="keyword" id="slug" value="<?php echo $keyword; ?>" />
    </div>
                            
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_status; ?></label>
        <select title="<?php echo $help_status; ?>" name="status">
            <?php if ($status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
        </select>
    </div>
                              
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_subtract; ?></label>
        <select title="<?php echo $help_subtract; ?>" name="subtract">
            <?php if ($subtract) { ?>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <option value="0"><?php echo $text_no; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_yes; ?></option>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <?php } ?>
        </select>
    </div>
                             
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_weight; ?></label>
        <input type="date" title="<?php echo $help_weight; ?>" name="date_available" value="<?php echo $weight; ?>" />
    </div>
                            
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $entry_weight_class; ?></label>
        <select title="<?php echo $help_weight_class; ?>" name="weight_class_id">
        <?php foreach ($weight_classes as $weight_class) { ?>
            <option value="<?php echo $weight_class['weight_class_id']; ?>" <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?> selected="selected"<?php } ?>><?php echo $weight_class['title']; ?></option>
        <?php } ?>
        </select>
    </div>
</div>

<script type="text/javascript">
function addRelated() {
	$('#product :selected').each(function() {
		$(this).remove();
		$('#related option[value=\'' + $(this).attr('value') + '\']').remove();
		$('#related').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');
		$('#product_related input[value=\'' + $(this).attr('value') + '\']').remove();
		$('#product_related').append('<input  type="hidden" name="product_related[]" value="' + $(this).attr('value') + '">');
	});
}

function removeRelated() {
	$('#related :selected').each(function() {
		$(this).remove();
		$('#product_related input[value=\'' + $(this).attr('value') + '\']').remove();
	});
}

function getProducts() {
	$('#product option').remove();
	
	$.ajax({
		url: '<?php echo $Url::createAdminUrl("store/product/category"); ?>&category_id=' + $('#category').attr('value'),
		dataType: 'json',
		success: function(data) {
			for (i = 0; i < data.length; i++) {
	 			/* $('#product').append('<li><img src="" alt="" />' + data[i]['name'] + ' (' + data[i]['model'] + ')<input type="hidden" name="" value="' + data[i]['product_id'] + '"></li>'); */
	 			$('#product').append('<li>' + data[i]['name'] + ' (' + data[i]['model'] + ')<input type="hidden" name="" value="' + data[i]['product_id'] + '"></li>');
			}
		}
	});
}

function getRelated() {
	$('#related option').remove();
	
	$.ajax({
		url: '<?php echo $Url::createAdminUrl("store/product/related"); ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#product_related input'),
		success: function(data) {
			$('#product_related input').remove();
			
			for (i = 0; i < data.length; i++) {
	 			$('#related').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' (' + data[i]['model'] + ') </option>');
				
				$('#product_related').append('<input  type="hidden" name="product_related[]" value="' + data[i]['product_id'] + '">');
			} 
		}
	});
}

getProducts();
getRelated();
</script>