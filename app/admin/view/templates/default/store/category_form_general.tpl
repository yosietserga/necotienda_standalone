<div id="languages" class="htabs2">
    <?php foreach ($languages as $language) { ?>
        <a tab="#language<?php echo $language['language_id']; ?>" class="htab2"><img src="images/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
    <?php } ?>
    <?php foreach ($languages as $language) { ?>
        <div id="language<?php echo $language['language_id']; ?>">
            <div class="row">
                <label><?php echo $Language->get('entry_name'); ?></label>
                <input class="category necoName" id="description_<?php echo $language['language_id']; ?>_title" name="category_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['title'] : ''; ?>" required="true" style="width:40%" />
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label><?php echo $Language->get('entry_meta_description'); ?></label>
                <textarea title="<?php echo $Language->get('help_meta_description'); ?>" name="category_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5" style="width:40%" class="necoMetaDescription"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language[ 'language_id']][ 'meta_description'] : ''; ?></textarea>
            </div>

                <input type="hidden" id="description_<?php echo $language['language_id']; ?>_keyword" name="category_description[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($category_description[$language[ 'language_id']]) ? $category_description[$language[ 'language_id']][ 'keyword'] : ''; ?>"  />

            <div class="clear"></div>

            <div class="row necoDescription">
                <label><?php echo $Language->get('entry_description'); ?></label>
                <div class="clear"></div>
                <textarea class="description" title="<?php echo $Language->get('help_description'); ?>" name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language[ 'language_id']]) ? $category_description[$language[ 'language_id']][ 'description'] : ''; ?></textarea>
            </div>
            
            <div class="clear"></div>
                        
        </div>
<?php } ?>
</div>