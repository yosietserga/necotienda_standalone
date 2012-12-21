<div>
    <h2>Im&aacute;genes</h2>
    <div class="row">
        <label><?php echo $entry_logo; ?></label>
        <img src="<?php echo $preview_logo; ?>" id="preview_logo" class="image" onclick="image_upload('logo', 'preview_logo');" />
        <br />
        <a onclick="image_upload('logo', 'preview_logo');" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
        <a onclick="image_delete('logo', 'preview_logo');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
        <input type="hidden" showquick="off" id="logo" name="config_logo" value="<?php echo $config_logo; ?>" />
    </div>
                                          
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_icon; ?></label>
        <img src="<?php echo $preview_icon; ?>" id="preview_icon" class="image" onclick="image_upload('icon', 'preview_icon');" />
        <br />
        <a onclick="image_upload('icon', 'preview_icon');" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
        <a onclick="image_delete('icon', 'preview_icon');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
        <input type="hidden" showquick="off" id="icon" name="config_icon" value="<?php echo $config_icon; ?>" />
    </div>
                                          
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_thumb; ?></label>
        <input type="number" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" />
        <input type="number" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_popup; ?></label>
        <input type="number" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" />
        <input type="number" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_category; ?></label>
        <input type="number" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" size="3" />
        <input type="number" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_product; ?></label>
        <input type="number" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" size="3" />
        <input type="number" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_additional; ?></label>
        <input type="number" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" />
        <input type="number" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_related; ?></label>
        <input type="number" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" size="3" />
        <input type="number" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_cart; ?></label>
        <input type="number" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" />
        <input type="number" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $entry_image_additional; ?></label>
        <input type="number" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" size="3" />
        <input type="number" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" size="3" />
    </div>
                                     
    <div class="clear"></div>
    
</div>