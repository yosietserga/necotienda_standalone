<div>
    <h2>Tienda</h2>
    <div class="row">
        <label><?php echo $entry_title; ?></label>
        <input type="text" name="config_title" value="<?php echo $config_title; ?>" />
    </div>
                        
    <div class="clear"></div>
        
    <div class="row">
        <label><?php echo $entry_meta_description; ?></label>
        <textarea name="config_meta_description" cols="40" rows="5"><?php echo $config_meta_description; ?></textarea>
    </div>
                        
    <div class="clear"></div>
        
    <div class="row">
        <label><?php echo $entry_template; ?></label>
        <select name="config_template" onchange="$('#template').load('<?php echo $Url::createAdminUrl("setting/setting/template"); ?>&template=' + encodeURIComponent(this.value));">
        <?php foreach ($templates as $template) { ?>
            
            <option value="<?php echo $template; ?>"<?php if ($template == $config_template) { ?> selected="selected"<?php } ?>><?php echo $template; ?></option>
        <?php } ?>
        </select>
        <div class="clear"></div>
        <div style="margin-left: 220px;" id="template"></div>
    </div>
                        
    <div class="clear"></div>
         
    <div id="languages" class="htabs">
    <?php foreach ($languages as $language) { ?>
        <a tab="#language<?php echo $language['language_id']; ?>" class="htab"><img src="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
    <?php } ?>
    </div> 
    
    <?php foreach ($languages as $language) { ?>
    <div id="language<?php echo $language['language_id']; ?>">
                         
        <div class="row">
            <label><?php echo $entry_description; ?></label>
            <div class="clear"></div>
            <textarea name="config_description_<?php echo $language['language_id']; ?>" id="description<?php echo $language['language_id']; ?>"><?php echo ${'config_description_' . $language['language_id']}; ?></textarea>
        </div>
                            
        <div class="clear"></div>
                           
    </div>
    <?php } ?>   
</div>         
