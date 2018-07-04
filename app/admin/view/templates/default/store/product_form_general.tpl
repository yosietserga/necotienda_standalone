<div id="languages" class="htabs2">
<?php foreach ($languages as $language) { ?>
    <a tab="#language<?php echo $language['language_id']; ?>" class="htab2"><img src="images/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
<?php } ?>
</div> 
<?php foreach ($languages as $language) { ?>
<div id="language<?php echo $language['language_id']; ?>">
                
    <div class="row">
        <label><?php echo $Language->get('entry_name'); ?></label>
        <input class="necoName" id="description_<?php echo $language['language_id']; ?>_title" name="product_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['title'] : ''; ?>" required="true" title="<?php echo $Language->get('help_name'); ?>" style="width: 40%;" />
    </div>
                        
    <div class="clear"></div>

    <div class="row">
        <label><?php echo $Language->get('entry_meta_description'); ?></label>
        <textarea class="necoMetaDescription" title="<?php echo $Language->get('help_meta_description'); ?>" name="product_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5" style="width: 40%;"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
    </div>
                        
    <div class="clear"></div>
                        
    <div class="row necoDescription">
        <label><?php echo $Language->get('entry_description'); ?></label>
        <div class="clear"></div>
        <textarea class="description" title="<?php echo $Language->get('help_description'); ?>" name="product_description[<?php echo $language['language_id']; ?>][description]" id="description_<?php echo $language['language_id']; ?>_description"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
    </div>
    
    <div class="clear"></div>

        <input type="hidden" id="description_<?php echo $language['language_id']; ?>_keyword" name="product_description[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['keyword'] : ''; ?>" />

</div>
<?php } ?>      