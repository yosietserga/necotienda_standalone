<div class="row">
    <label for="<?php echo $name; ?>SettingsClass"><?php echo $Language->get('entry_class'); ?></label>
    <input id="<?php echo $name; ?>SettingsClass" name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
</div>

<div class="row">
    <label><?php echo $Language->get('Position'); ?></label>
    <select name="Widgets[<?php echo $name; ?>][settings][position]" id="widget_pages<?php echo $name; ?>" showquick="off">
        <option value="left"<?php if ($settings['position']==='left') echo ' selected="1"'; ?>><?php echo $Language->get('Left'); ?></option>
        <option value="center"<?php if ($settings['position']==='center') echo ' selected="1"'; ?>><?php echo $Language->get('Center'); ?></option>
        <option value="right"<?php if ($settings['position']==='right') echo ' selected="1"'; ?>><?php echo $Language->get('Right'); ?></option>
    </select>
</div>
