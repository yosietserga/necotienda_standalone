<div class="row">
    <label for="<?php echo $name; ?>SettingsClass"><?php echo $Language->get('entry_class'); ?></label>
    <input id="<?php echo $name; ?>SettingsClass" name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsWidth"><?php echo $Language->get('Item Width'); ?></label>
    <input id="<?php echo $name; ?>SettingsWidth" name="Widgets[<?php echo $name; ?>][settings][width]" value="<?php echo isset($settings['width']) ? $settings['width'] : ''; ?>" />
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsMargin"><?php echo $Language->get('Item Margin'); ?></label>
    <input id="<?php echo $name; ?>SettingsMargin" name="Widgets[<?php echo $name; ?>][settings][margin]" value="<?php echo isset($settings['margin']) ? $settings['margin'] : ''; ?>" />
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsPadding"><?php echo $Language->get('Item Padding'); ?></label>
    <input id="<?php echo $name; ?>SettingsPadding" name="Widgets[<?php echo $name; ?>][settings][padding]" value="<?php echo isset($settings['padding']) ? $settings['padding'] : ''; ?>" />
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsFloat"><?php echo $Language->get('Item Float'); ?></label>
    <div class="checkbox">
        <input id="<?php echo $name; ?>SettingsFloat" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][float]" value="1"<?php if (isset($settings['float']) && !empty($settings['float'])) echo ' checked="checked"'; ?> />
        <span></span>
    </div>
</div>

<div class="row">
    <label for="widget_banners<?php echo $name; ?>"><?php echo $Language->get('entry_banner'); ?></label>
    <select name="Widgets[<?php echo $name; ?>][settings][banner_id]" id="widget_banners<?php echo $name; ?>" showquick="off">
        <option value=""><?php echo $Language->get('text_select'); ?></option>
        <?php foreach ($banners as $result) { ?>
        <option value="<?php echo $result['banner_id']; ?>"<?php if ($result['banner_id']==$settings['banner_id']) { ?> selected="selected"<?php } ?>><?php echo $result['name']; ?></option>
        <?php } ?>
    </select>
</div>
