
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

            <div class="clear"></div><br />

            <div class="row">
                <label><?php echo $Language->get('Allow Comments'); ?></label>
                <input name="allow_reviews" value="1" type="checkbox"<?php if (!empty($allow_reviews) || !isset($allow_reviews)) { echo ' checked="checked"'; } ?> />
            </div>

            <div class="clear"></div>

            <div class="row">
                <label><?php echo $Language->get('Publicado'); ?></label>
                <input name="publish" value="1" type="checkbox"<?php if (!empty($publish) || !isset($publish)) { echo ' checked="checked"'; } ?> />
            </div>

            <div class="clear"></div>

            <div class="row">
                <label><?php echo $Language->get('entry_date_start'); ?></label>
                <input type="necoDate" name="date_publish_start" id="date_publish_start" value="<?php echo isset($date_publish_start) ? $date_publish_start : ''; ?>" style="width:40%" />
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label><?php echo $Language->get('entry_date_end'); ?></label>
                <input type="necoDate" name="date_publish_end" id="date_publish_end" value="<?php echo isset($date_publish_end) ? $date_publish_end : ''; ?>" style="width:40%" />
            </div>

            <div class="clear"></div>

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
                <label><?php echo $Language->get('entry_category'); ?></label>
                <input type="text" placeholder="Filtrar listado" value="" name="q" id="q" />
                <div class="clear"></div>
                <ul id="categoriesWrapper" class="scrollbox necoCategory">
                    <?php foreach ($categories as $category) { ?>
                    <li class="categories">
                        <input id="scrollboxCategories<?php echo (int)$category['post_category_id']; ?>" title="<?php echo $Language->get('help_category'); ?>" type="checkbox" name="post_category[]" value="<?php echo $category['post_category_id']; ?>"<?php if (in_array($category['post_category_id'], $post_category)) { ?> checked="checked"<?php } ?> showquick="off" />
                        <label for="scrollboxCategories<?php echo (int)$category['post_category_id']; ?>"><?php echo $category['title']; ?></label>
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
                        <input id="scrollboxCustomerGroups0" type="checkbox" name="customer_groups[]" value="0"<?php if (in_array(0, $customer_groups) || !$post_id) { ?> checked="checked"<?php } ?> showquick="off" onchange="$('.customerGroups input').prop('checked', this.checked);" />
                        <label for="scrollboxCustomerGroups0"><?php echo $Language->get('text_all_public'); ?></label>
                    </li>
                    <?php foreach ($customerGroups as $group) { ?>
                    <li class="customerGroups">
                        <input id="scrollboxCustomerGroups<?php echo (int)$group['customer_group_id']; ?>" type="checkbox" name="customer_groups[]" value="<?php echo $group['customer_group_id']; ?>"<?php if (in_array($group['customer_group_id'], $customer_groups) || in_array(0, $customer_groups) || !$post_id) { ?> checked="checked"<?php } ?> showquick="off" />
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
                <ul id="storesWrapper" class="scrollbox" data-scrollbox="1">
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
            