<div>
    <div class="row">
        <label><?php echo $Language->get('entry_view'); ?></label>
        <select name="view">
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
            
    <div class="clear"></div>
            
    <div class="row">
        <label><?php echo $Language->get('entry_manufacturer'); ?></label>
        <select class="necoManufacturer" title="<?php echo $Language->get('help_manufacturer'); ?>" name="manufacturer_id">
            <option value="0" selected="selected"><?php echo $Language->get('text_none'); ?></option>
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"<?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?> selected="selected"<?php } ?>><?php echo $manufacturer['name']; ?></option>
            <?php } ?>
        </select>
    </div>
                    
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_category'); ?></label>
        <input type="text" placeholder="Filtrar listado" value="" name="q" id="q" />
        <div class="clear"></div>
        <ul id="categoriesWrapper" class="scrollbox necoCategory">
            <?php foreach ($categories as $category) { ?>
            <li class="categories">
                <input id="scrollboxCategories<?php echo (int)$category['category_id']; ?>" title="<?php echo $Language->get('help_category'); ?>" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>"<?php if (in_array($category['category_id'], $product_category)) { ?> checked="checked"<?php } ?> showquick="off" />
                <label for="scrollboxCategories<?php echo (int)$category['category_id']; ?>"><?php echo $category['name']; ?></label>
            </li>
            <?php } ?>
        </ul>
    </div>
    
    <div class="clear"></div>

    <?php if ($customerGroups) { ?>
    <div class="row">
        <label><?php echo $Language->get('entry_customer_group'); ?></label>
        <input type="text" placeholder="Filtrar listado" value="" name="q" id="qCustomerGroups" />
        <div class="clear"></div>
        <ul id="customerGroupsWrapper" class="scrollbox" data-scrollbox="1">
            <li>
                <input id="scrollboxCustomerGroups0" type="checkbox" name="customer_groups[]" value="0"<?php if (in_array(0, $customer_groups) || !$product_id) { ?> checked="checked"<?php } ?> showquick="off" onchange="$('.customerGroups input').prop('checked', this.checked);" />
                <label for="scrollboxCustomerGroups0"><?php echo $Language->get('text_all_public'); ?></label>
            </li>
            <?php foreach ($customerGroups as $group) { ?>
            <li class="customerGroups">
                <input id="scrollboxCustomerGroups<?php echo (int)$group['customer_group_id']; ?>" type="checkbox" name="customer_groups[]" value="<?php echo $group['customer_group_id']; ?>"<?php if (in_array($group['customer_group_id'], $customer_groups) || in_array(0, $customer_groups) || !$product_id) { ?> checked="checked"<?php } ?> showquick="off" />
                <label for="scrollboxCustomerGroups<?php echo (int)$group['customer_group_id']; ?>"><?php echo $group['name']; ?></label>
            </li>
            <?php } ?>
        </ul>
    </div>
    <?php } else { ?>
    <input type="hidden" name="customer_groups[]" value="0" />
    <?php } ?>
    
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
            
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_download'); ?></label>
        <div class="clear"></div>
        <div class="scrollbox necoDownload">
        <?php $class = 'odd'; ?>
        <?php foreach ($downloads as $download) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <div class="<?php echo $class; ?>">
            <?php if (in_array($download['download_id'], $product_download)) { ?>
                <input title="<?php echo $Language->get('help_download'); ?>" type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" checked="checked" showquick="off" /><?php echo $download['name']; ?>
            <?php } else { ?>
                <input title="<?php echo $Language->get('help_download'); ?>" type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" showquick="off" /><?php echo $download['name']; ?>
            <?php } ?>
            </div>
        <?php } ?>
        </div>
    </div>
                    
    <div class="clear"></div>
                    
    <div class="row necoRelated">
        <label><?php echo $Language->get('entry_related'); ?></label>
        <div class="clear"></div><br />
        
        <div id="addsPanel"><b>Agregar / Eliminar Productos Relacionados</b></div>
        <div id="addsWrapper"><div id="gridPreloader"></div></div>
        
        <div class="clear"></div><br />
        
        <div id="product_related">
        <?php foreach ($product_related as $related_id) { ?>
            <input type="hidden" name="product_related[]" value="<?php echo $related_id; ?>" showquick="off" />
        <?php } ?>
        </div>
    </div>
                        
    <div class="clear"></div>
                    
</div>