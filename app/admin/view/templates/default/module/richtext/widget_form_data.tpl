<div class="row">
    <label for="<?php echo $name; ?>SettingsClass"><?php echo $Language->get('entry_class'); ?></label>
    <input id="<?php echo $name; ?>SettingsClass" name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
</div>

<div class="row">
    <label><?php echo $Language->get('entry_richtext'); ?></label>
    <select name="Widgets[<?php echo $name; ?>][settings][post_id]" id="widget_richtext<?php echo $name; ?>" showquick="off">
        <option value=""><?php echo $Language->get('text_select'); ?></option>
        <?php foreach ($pages as $result) { ?>
        <option value="<?php echo $result['post_id']; ?>"<?php if ($result['post_id']==$settings['post_id']) { ?> selected="selected"<?php } ?>><?php echo $result['title']; ?></option>
        <?php } ?>
    </select>
</div>
