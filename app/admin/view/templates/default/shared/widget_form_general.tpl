
<div class="row">
    <label for="<?php echo $name; ?>SettingsTitle"><?php echo $Language->get('entry_title'); ?></label>
    <input name="Widgets[<?php echo $name; ?>][settings][title]" value="<?php echo $settings['title']; ?>" />
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsAutoload"><?php echo $Language->get('entry_load'); ?></label>
    <div class="checkbox">
        <input id="<?php echo $name; ?>SettingsAutoload" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][autoload]" value="1"<?php if (isset($settings['autoload']) && !empty($settings['autoload'])) echo ' checked="checked"'; ?> />
        <span></span>
    </div>
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsShowonmobile"><?php echo $Language->get('Show On Mobile'); ?></label>
    <div class="checkbox">
        <input id="<?php echo $name; ?>SettingsShowonmobile" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][showonmobile]" value="1"<?php if (isset($settings['autoload']) && !empty($settings['autoload'])) echo ' checked="checked"'; ?> />
        <span></span>
    </div>
</div>

<div class="row">
    <label for="<?php echo $name; ?>SettingsShowondesktop"><?php echo $Language->get('Show On Desktop'); ?></label>
    <div class="checkbox">
        <input id="<?php echo $name; ?>SettingsShowondesktop" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][showondesktop]" value="1"<?php if (isset($settings['autoload']) && !empty($settings['autoload'])) echo ' checked="checked"'; ?> />
        <span></span>
    </div>
</div>

<?php if ($views) { ?>
<div class="row">
    <label><?php echo $Language->get('View'); ?></label>
    <select name="Widgets[<?php echo $name; ?>][settings][view]">
        <?php foreach ($views as $view) { ?>

        <option value="<?php echo $view; ?>"<?php if ($view == $settings['view']) { ?> selected="selected"<?php } ?>><?php echo $view; ?></option>
        <?php } ?>
    </select>
</div>
<?php } ?>