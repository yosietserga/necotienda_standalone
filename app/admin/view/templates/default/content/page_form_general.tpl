<div id="languages" class="htabs2">
    <?php foreach ($languages as $language) { ?>
    <a tab="#language<?php echo $language['language_id']; ?>" class="htab2"><img src="images/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
    <?php } ?>
    <?php foreach ($languages as $language) { ?>
    <div id="language<?php echo $language['language_id']; ?>">

        <div class="row">
            <label><?php echo $Language->get('entry_title'); ?></label>
            <input class="page" id="description_<?php echo $language['language_id']; ?>_title" name="page_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['title'] : ''; ?>" required="true" style="width:40%" />
        </div>

        <div class="clear"></div>

        <div class="row">
            <label><?php echo $Language->get('entry_meta_description'); ?></label>
            <textarea title="<?php echo $Language->get('help_meta_description'); ?>" name="page_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5" style="width:40%"><?php echo isset($page_description[$language[ 'language_id']]) ? $page_description[$language[ 'language_id']][ 'meta_description'] : ''; ?></textarea>
        </div>

        <div class="clear"></div>

            <input type="hidden" id="description_<?php echo $language['language_id']; ?>_keyword" name="page_description[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($page_description[$language[ 'language_id']]) ? $page_description[$language[ 'language_id']][ 'keyword'] : ''; ?>" />

        <div class="row">
            <label><?php echo $Language->get('entry_description'); ?></label>
            <div class="clear"></div>
            <textarea title="<?php echo $Language->get('help_description'); ?>" name="page_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($page_description[$language[ 'language_id']]) ? $page_description[$language[ 'language_id']][ 'description'] : ''; ?></textarea>
        </div>

        <div class="clear"></div>

    </div>
    <?php } ?>
</div>