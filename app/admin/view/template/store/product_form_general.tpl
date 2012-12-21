<div id="languages" class="htabs">
<?php foreach ($languages as $language) { ?>
    <a tab="#language<?php echo $language['language_id']; ?>" class="htab"><img src="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
<?php } ?>
</div> 
<?php foreach ($languages as $language) { ?>
<div id="language<?php echo $language['language_id']; ?>">
                
    <div class="row">
        <label><?php echo $entry_name; ?></label>
        <input id="product_description<?php echo $language['language_id']; ?>_name" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" required="true" title="<?php echo $help_name; ?>" />
    </div>
                        
    <div class="clear"></div>
                        
    <div class="row">
        <label><?php echo $entry_meta_keywords; ?></label>
        <textarea title="<?php echo $help_meta_keywords; ?>" name="product_description[<?php echo $language['language_id']; ?>][meta_keywords]" cols="40" rows="5"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keywords'] : ''; ?></textarea>
    </div>
                        
    <div class="clear"></div>
                        
    <div class="row">
        <label><?php echo $entry_meta_description; ?></label>
        <textarea title="<?php echo $help_meta_description; ?>" name="product_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
    </div>
                        
    <div class="clear"></div>
                        
    <div class="row">
        <label><?php echo $entry_description; ?></label>
        <div class="clear"></div>
        <textarea title="<?php echo $help_description; ?>" name="product_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
    </div>
                        
    <div class="clear"></div>
                       
    <div class="row">
        <label><?php echo $entry_tags; ?></label>
        <input title="<?php echo $help_tags; ?>" name="product_tags[<?php echo $language['language_id']; ?>]" value="<?php echo isset($product_tags[$language['language_id']]) ? $product_tags[$language['language_id']] : ''; ?>" />
    </div>
                        
    <div class="clear"></div>
    
</div>
<?php } ?>            