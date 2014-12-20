<div>
    <div class="row">
        <label><?php echo $Language->get('entry_model'); ?></label>
        <input class="necoModel" title="<?php echo $Language->get('help_model'); ?>" id="model" name="model" value="<?php echo $model; ?>" required="true" />
    </div>
                                          
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_price'); ?></label>
        <input class="necoPrice" type="text" title="<?php echo $Language->get('help_price'); ?>" name="price" value="<?php echo str_replace('.',',',$price); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_tax_class'); ?></label>
        <select class="necoTaxClass" name="tax_class_id" title="<?php echo $Language->get('help_tax_class'); ?>">
            <option value="0"><?php echo $Language->get('text_none'); ?></option>
            <?php foreach ($tax_classes as $tax_class) { ?>
            <option value="<?php echo $tax_class['tax_class_id']; ?>"<?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?> selected="selected"<?php } ?>><?php echo $tax_class['title']; ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_quantity'); ?></label>
        <input class="necoQuantity" type="necoNumber" title="<?php echo $Language->get('help_quantity'); ?>" name="quantity" value="<?php echo $quantity; ?>" />
    </div>
                                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_minimum'); ?></label>
        <input class="necoMinimun" type="necoNumber" title="<?php echo $Language->get('help_minimum'); ?>" name="minimum" value="<?php echo $minimum; ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_image'); ?></label>
        <a class="filemanager" data-fancybox-type="iframe" href="<?php echo $Url::createAdminUrl("common/filemanager"); ?>&amp;field=image&amp;preview=preview">
        <img src="<?php echo $preview; ?>" id="preview" class="image necoImage" width="100" />
        </a>
        <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" onchange="$('#preview').attr('src', this.value);" />
        <br />
        <a class="filemanager" data-fancybox-type="iframe" href="<?php echo $Url::createAdminUrl("common/filemanager"); ?>&amp;field=image&amp;preview=preview" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
        <a onclick="image_delete('image', 'preview');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
    </div>
                            
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_date_available'); ?></label>
        <input class="necoDateAvailable" type="necoDate" title="<?php echo $Language->get('help_date_available'); ?>" name="date_available" value="<?php echo $date_available; ?>" />
    </div>
                    
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_stock_status'); ?></label>
        <select class="necoStockStatus" title="<?php echo $Language->get('help_stock_status'); ?>" name="stock_status_id">
        <?php foreach ($stock_statuses as $stock_status) { ?>
            
            <option value="<?php echo $stock_status['stock_status_id']; ?>"<?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?> selected="selected"<?php } ?>><?php echo $stock_status['name']; ?></option>
        <?php } ?>
        </select>
    </div>
                
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_status'); ?></label>
        <select class="necoStatus" title="<?php echo $Language->get('help_status'); ?>" name="status">
            <option value="1"<?php if ($status) { ?> selected="selected"<?php } ?>><?php echo $Language->get('text_enabled'); ?></option>
            <option value="0"<?php if (!$status) { ?> selected="selected"<?php } ?>><?php echo $Language->get('text_disabled'); ?></option>
        </select>
    </div>
                              
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_subtract'); ?></label>
        <select class="necoSubtract" title="<?php echo $Language->get('help_subtract'); ?>" name="subtract">
            <?php if ($subtract) { ?>
            <option value="1" selected="selected"><?php echo $Language->get('text_yes'); ?></option>
            <option value="0"><?php echo $Language->get('text_no'); ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $Language->get('text_yes'); ?></option>
            <option value="0" selected="selected"><?php echo $Language->get('text_no'); ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_shipping'); ?></label>
        <select class="necoShipping" name="shipping_id" title="<?php echo $Language->get('help_shipping'); ?>">
            <option value="0"<?php if (!$shipping) { ?> selected="selected"<?php } ?>><?php echo $Language->get('text_no'); ?></option>
            <option value="1"<?php if ($shipping) { ?> selected="selected"<?php } ?>><?php echo $Language->get('text_yes'); ?></option>
        </select>
    </div>
    
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_weight'); ?></label>
        <input class="necoWeight" type="necoNumber" title="<?php echo $Language->get('help_weight'); ?>" name="weight" value="<?php echo $weight; ?>" />
    </div>
                            
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_weight_class'); ?></label>
        <select class="necoWeightClass" title="<?php echo $Language->get('help_weight_class'); ?>" name="weight_class_id">
        <?php foreach ($weight_classes as $weight_class) { ?>
            <option value="<?php echo $weight_class['weight_class_id']; ?>" <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?> selected="selected"<?php } ?>><?php echo $weight_class['title']; ?></option>
        <?php } ?>
        </select>
    </div>
</div>
<script>
$(function(){
    $('#model').on('change',function(e){
        $('.message').remove();
        $.getJSON('<?php echo $Url::createAdminUrl('store/product/checkmodel'); ?>',
        {
            product_id:<?php echo (int)$product_id; ?>,
            model:$(this).val(),
        },
        function(data){
            if (typeof data.error != 'undefined') {
                $('#form').prepend('<div class="message warning">Este modelo de producto ya est&aacute; registrado, por favor ingrese otro modelo.</div>');
            }
        });
    });
});
</script>