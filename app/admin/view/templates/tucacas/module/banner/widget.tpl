<form id="<?php echo $name; ?>_form">
    <p style="text-align:center;font-size:10px;">{%<?php echo $name; ?>%}</p>
    <div class="row">
        <label><?php echo $Language->get('entry_title'); ?></label>
        <input name="Widgets[<?php echo $name; ?>][settings][title]" value="<?php echo isset($settings['title']) ? $settings['title'] : $Language->get('heading_title'); ?>" />
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_class'); ?></label>
        <input name="Widgets[<?php echo $name; ?>][settings][class]" value="<?php echo isset($settings['class']) ? $settings['class'] : ''; ?>" />
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_load'); ?></label>
        <input type="checkbox" name="Widgets[<?php echo $name; ?>][settings][autoload]" value="1" checked="checked" />
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('Show On Mobile'); ?></label>
        <input type="checkbox" name="Widgets[<?php echo $name; ?>][settings][showonmobile]" value="1" checked="checked" />
    </div>

    <div class="row">
        <label><?php echo $Language->get('Show On Desktop'); ?></label>
        <input type="checkbox" name="Widgets[<?php echo $name; ?>][settings][showondesktop]" value="1" checked="checked" />
    </div>

    <div class="row">
        <label><?php echo $Language->get('entry_banner'); ?></label>
        <select name="Widgets[<?php echo $name; ?>][settings][banner_id]" id="widget_banners<?php echo $name; ?>" showquick="off">
            <option value=""><?php echo $Language->get('text_select'); ?></option>
        <?php foreach ($banners as $result) { ?>
            <option value="<?php echo $result['banner_id']; ?>"<?php if ($result['banner_id']==$settings['banner_id']) { ?> selected="selected"<?php } ?>><?php echo $result['name']; ?></option>
        <?php } ?>
        </select>
    </div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_landing_page'); ?></label>
        <ul class="scrollbox" data-scrollbox="1">
            <li>
                <input type="checkbox" name="Widgets[<?php echo $name; ?>][landing_page][]" value="all"<?php if (empty($landing_pages)) { ?> checked="checked"<?php } ?> showquick="off" />
                <b>Todo el sitio</b>
            </li>
        <?php foreach ($routes as $text_var => $landing_page) { ?>
            <li>
                <input class="<?php echo $name; ?>_landing_pages" type="checkbox" name="Widgets[<?php echo $name; ?>][landing_page][]" value="<?php echo $landing_page; ?>"<?php if (in_array($landing_page, $landing_pages)) { ?> checked="checked"<?php } elseif (empty($landing_pages)) { ?> checked="checked"<?php } ?> showquick="off" />
                <b><?php echo $Language->get($text_var); ?></b>
            </li>
        <?php } ?>
        </ul>
    </div>
    <input type="hidden" name="Widgets[<?php echo $name; ?>][settings][route]" value="module/banner" />
</form>
<script>
$(function(){
    $('#widget_banners<?php echo $name; ?>').chosen();
    addScrollboxBehavior();
});
</script>