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
        <label><?php echo $Language->get('entry_module'); ?></label>
        <select name="Widgets[<?php echo $name; ?>][settings][module]">
            <option value="latest"<?php if ($settings['module'] == 'latest') echo ' selected="selected"'; ?>>Productos Recientes</option>
            <option value="featured"<?php if ($settings['module'] == 'featured') echo ' selected="selected"'; ?>>Productos Populares</option>
            <option value="special"<?php if ($settings['module'] == 'special') echo ' selected="selected"'; ?>>Productos En Ofertas</option>
            <option value="bestseller"<?php if ($settings['module'] == 'bestseller') echo ' selected="selected"'; ?>>Productos M&aacute;s Vendidos</option>
            <option value="recommended"<?php if ($settings['module'] == 'recommended') echo ' selected="selected"'; ?>>Productos Recomendados</option>
            <option value="random"<?php if ($settings['module'] == 'random') echo ' selected="selected"'; ?>>Productos Aleatorios</option>
        </select>
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_width'); ?></label>
        <input name="Widgets[<?php echo $name; ?>][settings][width]" value="<?php echo isset($settings['width']) ? (int)$settings['width'] : 150; ?>" />
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_height'); ?></label>
        <input name="Widgets[<?php echo $name; ?>][settings][height]" value="<?php echo isset($settings['height']) ? (int)$settings['height'] : 150; ?>" />
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_scroll'); ?></label>
        <input name="Widgets[<?php echo $name; ?>][settings][scroll][items]" value="<?php echo isset($settings['scroll'][items]) ? (int)$settings['scroll'][items] : 1; ?>" />
    </div>
    
    <div class="row">
        <label>Pausa Al Poner el Cursor Arriba: </label>
        <input type="checkbox" name="Widgets[<?php echo $name; ?>][settings][scroll][pauseOnHover]" value="<?php echo isset($settings['scroll'][pauseOnHover]) ? (int)$settings['scroll'][pauseOnHover] : true; ?>" />
    </div>
    
    <div class="row">
        <label for="<?php echo $name; ?>SettingsLimit"><?php echo $Language->get('entry_limit'); ?></label>
        <input id="<?php echo $name; ?>SettingsLimit" name="Widgets[<?php echo $name; ?>][settings][limit]" value="<?php echo isset($settings['limit']) ? (int)$settings['limit'] : 4; ?>" />
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
    <input type="hidden" name="Widgets[<?php echo $name; ?>][settings][route]" value="module/carousel" />
</form>
<script>
$(function(){

});
</script>