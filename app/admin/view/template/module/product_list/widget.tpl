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
            <option value="random"<?php if ($settings['module'] == 'random') echo ' selected="selected"'; ?>>Productos Aleatorios</option>
            <option value="latest"<?php if ($settings['module'] == 'latest') echo ' selected="selected"'; ?>>Productos Recientes</option>
            <option value="featured"<?php if ($settings['module'] == 'featured') echo ' selected="selected"'; ?>>Productos Populares</option>
            <option value="special"<?php if ($settings['module'] == 'special') echo ' selected="selected"'; ?>>Productos En Ofertas</option>
            <option value="bestseller"<?php if ($settings['module'] == 'bestseller') echo ' selected="selected"'; ?>>Productos M&aacute;s Vendidos</option>
            <option value="recommended"<?php if ($settings['module'] == 'recommended') echo ' selected="selected"'; ?>>Productos Recomendados</option>
            <option value="related"<?php if ($settings['module'] == 'related') echo ' selected="selected"'; ?>>Productos Relacionados</option>
        </select>
    </div>

    <div class="row">
        <label><?php echo $Language->get('View'); ?></label>
        <select name="Widgets[<?php echo $name; ?>][settings][module]">
            <option value="list"<?php if ($settings['view'] == 'list') echo ' selected="selected"'; ?>>List</option>
            <option value="grid"<?php if ($settings['view'] == 'grid') echo ' selected="selected"'; ?>>Grid</option>
            <option value="carousel"<?php if ($settings['view'] == 'carousel') echo ' selected="selected"'; ?>>Carousel</option>
            <option value="slider"<?php if ($settings['view'] == 'slider') echo ' selected="selected"'; ?>>Slider</option>
        </select>
    </div>

    <div class="row">
        <label for="<?php echo $name; ?>SettingsLimit"><?php echo $Language->get('entry_limit'); ?></label>
        <input id="<?php echo $name; ?>SettingsLimit" name="Widgets[<?php echo $name; ?>][settings][limit]" value="<?php echo isset($settings['limit']) ? (int)$settings['limit'] : 4; ?>" />
    </div>

    <div class="row">
        <label for="<?php echo $name; ?>SettingsShowPagination"><?php echo $Language->get('Show Pagination'); ?></label>
        <input id="<?php echo $name; ?>SettingsShowPagination" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][show_pagination]" value="1" />
    </div>

    <div class="row">
        <label for="<?php echo $name; ?>SettingsEndlessScroll"><?php echo $Language->get('Endless Scroll'); ?></label>
        <input id="<?php echo $name; ?>SettingsEndlessScroll" type="checkbox" name="Widgets[<?php echo $name; ?>][settings][endless_scroll]" value="1" />
    </div>

    <?php if ($categories) { ?>
    <div class="row">
        <label><?php echo $Language->get('Select Categories'); ?></label>
        <ul class="scrollbox" data-scrollbox="1">
            <?php echo $categories; ?>
        </ul>
    </div>
    <?php } ?>

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
    <input type="hidden" name="Widgets[<?php echo $name; ?>][settings][route]" value="module/product_list" />
</form>
<script>
$(function(){

});
</script>