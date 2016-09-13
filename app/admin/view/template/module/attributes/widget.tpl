<form id="<?php echo $name; ?>_form">
    <p style="text-align:center;font-size:10px;">{%<?php echo $name; ?>%}</p>
    <div class="row">
        <label for="<?php echo $name; ?>SettingsTitle"><?php echo $Language->get('entry_title'); ?></label>
        <input id="<?php echo $name; ?>SettingsTitle" name="Widgets[<?php echo $name; ?>][settings][title]" value="<?php echo isset($settings['title']) ? $settings['title'] : $Language->get('heading_title'); ?>" />
    </div>
    
    <div class="row">
        <label for="<?php echo $name; ?>SettingsClass"><?php echo $Language->get('entry_class'); ?></label>
        <input id="<?php echo $name; ?>SettingsClass" name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
    </div>
    
    <div class="row">
        <label for="<?php echo $name; ?>SettingsAutoload"><?php echo $Language->get('entry_load'); ?></label>
        <input id="<?php echo $name; ?>SettingsAutoload" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][autoload]" value="1" checked="checked" />
    </div>
    
    <div class="row">
        <label for="<?php echo $name; ?>SettingsShowonmobile"><?php echo $Language->get('Show On Mobile'); ?></label>
        <input id="<?php echo $name; ?>SettingsShowonmobile" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][showonmobile]" value="1" checked="checked" />
    </div>

    <div class="row">
        <label for="<?php echo $name; ?>SettingsShowondesktop"><?php echo $Language->get('Show On Desktop'); ?></label>
        <input id="<?php echo $name; ?>SettingsShowondesktop" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][showondesktop]" value="1" checked="checked" />
    </div>

    <div class="row">
        <label for="widget_attributess<?php echo $name; ?>"><?php echo $Language->get('entry_attributes'); ?></label>
        <select name="Widgets[<?php echo $name; ?>][settings][product_attribute_group_id]" id="widget_attributess<?php echo $name; ?>" showquick="off">
            <option value=""><?php echo $Language->get('text_select'); ?></option>
        <?php foreach ($attributess as $result) { ?>
            <option value="<?php echo $result['product_attribute_group_id']; ?>"<?php if ($result['product_attribute_group_id']==$settings['product_attribute_group_id']) { ?> selected="selected"<?php } ?>><?php echo $result['name']; ?></option>
        <?php } ?>
        </select>
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_landing_page'); ?></label>
        <ul class="scrollbox" data-scrollbox="1">
            <li>
                <input id="<?php echo $name; ?>Settingslanding_pageall" type="checkbox" name="Widgets[<?php echo $name; ?>][landing_page][]" value="all"<?php if (empty($landing_pages)) { ?> checked="checked"<?php } ?> showquick="off" onchange="$('input.<?php echo $name; ?>_landing_pages').prop({ 'checked':this.checked, 'disabled':this.checked })" />
                <label for="<?php echo $name; ?>Settingslanding_pageall">Todo el sitio</label>
            </li>
        <?php foreach ($routes as $text_var => $landing_page) { ?>
            <li>
                <input id="<?php echo $name; ?>Settingslanding_page<?php echo $landing_page; ?>" class="<?php echo $name; ?>_landing_pages" type="checkbox" name="Widgets[<?php echo $name; ?>][landing_page][]" value="<?php echo $landing_page; ?>"<?php if (in_array($landing_page, $landing_pages)) { ?> checked="checked"<?php } elseif (empty($landing_pages)) { ?> checked="checked"<?php } ?> showquick="off" />
                <label for="<?php echo $name; ?>Settingslanding_page<?php echo $landing_page; ?>"><?php echo $Language->get($text_var); ?></label>
            </li>
        <?php } ?>
        </ul>
    </div>
    <input type="hidden" name="Widgets[<?php echo $name; ?>][settings][route]" value="module/attributes" />
</form>
<script>
$(function(){
    $('#widget_attributess<?php echo $name; ?>').chosen();

});
</script>