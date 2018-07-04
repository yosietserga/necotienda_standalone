<div class="row">
    <label><?php echo $Language->get('entry_image'); ?></label>
    <a class="filemanager" data-fancybox-type="iframe" href="<?php echo $Url::createAdminUrl("common/filemanager"); ?>&amp;field=image&amp;preview=preview">
    <img src="<?php echo $preview; ?>" id="preview" class="image necoImage" width="100" />
    </a>
    <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" onchange="$('#preview').attr('src', this.value);" />
    <br />
    <a class="filemanager" data-fancybox-type="iframe" href="<?php echo $Url::createAdminUrl("common/filemanager"); ?>&amp;field=image&amp;preview=preview" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
    <a onclick="image_delete('image', 'preview');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
</div>

<div class="clear"></div>

<div class="row">
    <label><?php echo $Language->get('entry_view'); ?></label>
    <select name="view" class="necoTemplate">
        <option value=""<?php if (empty($layout)) { echo ' selected="selected"'; } ?>><?php echo $Language->get('text_default'); ?></option>
        <?php foreach ($views as $key => $value) { ?>
        <optgroup label="<?php echo $value['folder']; ?>">
            <?php foreach ($value['files'] as $k => $v) { ?>
            <option value="<?php echo basename($value['folder']) ."/". basename($v); ?>"<?php if ($layout==basename($value['folder']) ."/". basename($v)) { echo ' selected="selected"'; } ?>><?php echo basename($v); ?></option>
            <?php } ?>
        </optgroup>
        <?php } ?>
    </select>
</div>
    
<?php if ($stores) { ?>
<div class="clear"></div>
<div class="row">
    <label><?php echo $Language->get('entry_store'); ?></label><br />
    <input type="text" title="Filtrar listado de tiendas y sucursales" value="" name="q" id="q" placeholder="Filtrar Tiendas" />
    <div class="clear"></div>
    <a onclick="$('#storesWrapper input[type=checkbox]').attr('checked','checked');">Seleccionar Todos</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a onclick="$('#storesWrapper input[type=checkbox]').removeAttr('checked');">Seleccionar Ninguno</a>
    <div class="clear"></div>
    <ul id="storesWrapper" class="scrollbox necoStore">
        <li class="stores">
            <input id="scrollboxStores0" type="checkbox" name="stores[]" value="0"<?php if (in_array(0, $_stores)) { ?> checked="checked"<?php } ?> showquick="off" />
            <label for="scrollboxStores0"><?php echo $Language->get('text_default'); ?></label>
            <div class="clear"></div>
        </li>
    <?php foreach ($stores as $store) { ?>
        <li class="stores">
            <input id="scrollboxStores<?php echo (int)$store['store_id']; ?>" type="checkbox" name="stores[]" value="<?php echo (int)$store['store_id']; ?>"<?php if (in_array($store['store_id'], $_stores)) { ?> checked="checked"<?php } ?> showquick="off" />
            <label for="scrollboxStores<?php echo (int)$store['store_id']; ?>"><?php echo $store['name']; ?></label>
            <div class="clear"></div>
        </li>
    <?php } ?>
    </ul>
</div> 
<?php } else { ?>
    <input type="hidden" name="stores[]" value="0" />
<?php } ?>

<div class="clear"></div><br />

<div id="addsPanel" class="necoPanel"><b>Agregar / Eliminar Productos</b></div>
<div id="addsWrapper"><div id="gridPreloader"></div></div>
