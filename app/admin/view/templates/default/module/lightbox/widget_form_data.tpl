<div class="row">
    <label for="<?php echo $name; ?>SettingsClass"><?php echo $Language->get('entry_class'); ?></label>
    <input id="<?php echo $name; ?>SettingsClass" name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
</div>

<div class="row">
    <label><?php echo $Language->get('entry_page'); ?></label>
    <select name="Widgets[<?php echo $name; ?>][settings][page_id]" id="widget_pages<?php echo $name; ?>" showquick="off">
        <option value=""><?php echo $Language->get('text_select'); ?></option>
        <?php foreach ($pages as $result) { ?>
        <option value="<?php echo $result['post_id']; ?>"<?php if ($result['post_id']==$settings['page_id']) { ?> selected="selected"<?php } ?>><?php echo $result['title']; ?></option>
        <?php } ?>
    </select>
</div>

<div class="row">
    <label><?php echo $Language->get('Background Color'); ?></label>
    <input type="color" name="Widgets[<?php echo $name; ?>][settings][background]" value="<?php echo isset($settings['background']) ? $settings['background'] : '#ffffff'; ?>" />
</div>

<div class="row">
    <label><?php echo $Language->get('Background Opacity'); ?></label>
    <input type="number" max="1" min="0" step="0.1" name="Widgets[<?php echo $name; ?>][settings][opacity]" value="<?php echo isset($settings['opacity']) ? $settings['opacity'] : '0.5'; ?>" />
</div>

<div class="row">
    <label><?php echo $Language->get('entry_width'); ?></label>
    <input type="text" name="Widgets[<?php echo $name; ?>][settings][width]" value="<?php echo isset($settings['width']) ? $settings['width'] : '500px'; ?>" />
</div>

<div class="row">
    <label><?php echo $Language->get('entry_height'); ?></label>
    <input type="text" name="Widgets[<?php echo $name; ?>][settings][height]" value="<?php echo isset($settings['height']) ? $settings['height'] : '300px'; ?>" />
</div>
