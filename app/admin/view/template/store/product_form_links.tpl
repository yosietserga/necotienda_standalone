                <div>
                
                    <div class="row">
                        <label><?php echo $Language->get('entry_manufacturer'); ?></label>
                        <select title="<?php echo $Language->get('help_manufacturer'); ?>" name="manufacturer_id">
                            <option value="0" selected="selected"><?php echo $Language->get('text_none'); ?></option>
                            <?php foreach ($manufacturers as $manufacturer) { ?>
                            <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                      </select>
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="row">
                        <label><?php echo $Language->get('entry_category'); ?></label>
                        <input type="text" title="Filtrar listado de categor&iacute;as" value="" name="q" id="q" />
                        <div class="clear"></div>
                        <ul id="categoriesWrapper" class="scrollbox">
                            <?php foreach ($categories as $category) { ?>
                                <li class="categories">
                                    <input title="<?php echo $Language->get('help_category'); ?>" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>"<?php if (in_array($category['category_id'], $product_category)) { ?> checked="checked"<?php } ?> showquick="off" />
                                    <b><?php echo $category['name']; ?></b>
                                
                                </li>
                            <?php } ?>
                        </ul>
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
                <ul id="storesWrapper" class="scrollbox">
                    <li class="stores">
                        <input type="checkbox" name="stores[]" value="0"<?php if (in_array(0, $_stores)) { ?> checked="checked"<?php } ?> showquick="off" />
                        <b><?php echo $Language->get('text_default'); ?></b>
                        <div class="clear"></div>
                    </li>
                <?php foreach ($stores as $store) { ?>
                    <li class="stores">
                        <input type="checkbox" name="stores[]" value="<?php echo (int)$store['store_id']; ?>"<?php if (in_array($store['store_id'], $_stores)) { ?> checked="checked"<?php } ?> showquick="off" />
                        <b><?php echo $store['name']; ?></b>
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
                        <div class="scrollbox">
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
                    
                    <div class="row">
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
        