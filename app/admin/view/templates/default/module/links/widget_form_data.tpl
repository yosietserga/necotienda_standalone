<div class="row">
    <label for="<?php echo $name; ?>SettingsClass"><?php echo $Language->get('entry_class'); ?></label>
    <input id="<?php echo $name; ?>SettingsClass" name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
</div>

<div class="row">
    <label for="<?php echo $name; ?>Settingsis_main_menu"><?php echo $Language->get('Main Menu'); ?></label>

    <div class="checkbox">
        <input id="<?php echo $name; ?>Settingsis_main_menu" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][is_main_menu]" value="1"<?php if (isset($settings['is_main_menu'])) { ?>  checked="checked"<?php } ?> />
        <span></span>
    </div>
</div>

<div class="row">
    <label><?php echo $Language->get('entry_menu'); ?></label>
    <select name="Widgets[<?php echo $name; ?>][settings][menu_id]" showquick="off">
        <option value=""><?php echo $Language->get('text_select'); ?></option>
        <?php foreach ($menus as $result) { ?>
        <option value="<?php echo $result['menu_id']; ?>"<?php if ($result['menu_id']==$settings['menu_id']) { ?> selected="selected"<?php } ?>><?php echo $result['name']; ?></option>
        <?php } ?>
    </select>
</div>
