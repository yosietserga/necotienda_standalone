                <div>
                
                    <div class="row">
                        <label><?php echo $entry_manufacturer; ?></label>
                        <select title="<?php echo $help_manufacturer; ?>" name="manufacturer_id">
                            <option value="0" selected="selected"><?php echo $text_none; ?></option>
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
                        <label><?php echo $entry_category; ?></label>
                        <input type="text" title="Filtrar listado de categor&iacute;as" value="" name="q" id="q" />
                        <div class="clear"></div>
                        <ul id="categoriesWrapper" class="scrollbox">
                            <?php foreach ($categories as $category) { ?>
                                <li class="categories">
                                    <input title="<?php echo $help_category; ?>" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>"<?php if (in_array($category['category_id'], $product_category)) { ?> checked="checked"<?php } ?> showquick="off" />
                                    <b><?php echo $category['name']; ?></b>
                                
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="row">
                        <label><?php echo $entry_download; ?></label>
                        <div class="clear"></div>
                        <div class="scrollbox">
                        <?php $class = 'odd'; ?>
                        <?php foreach ($downloads as $download) { ?>
                            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                            <div class="<?php echo $class; ?>">
                            <?php if (in_array($download['download_id'], $product_download)) { ?>
                                <input title="<?php echo $help_download; ?>" type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" checked="checked" showquick="off" /><?php echo $download['name']; ?>
                          <?php } else { ?>
                                <input title="<?php echo $help_download; ?>" type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" showquick="off" /><?php echo $download['name']; ?>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="row">
                        <label><?php echo $entry_related; ?></label>
                        <table>
                            <tr>
                                <td style="padding: 0;" colspan="3">
                                    <select id="category" style="margin-bottom: 5px;" onchange="getProducts();">
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td id="relatedSourge">
                                    <ul id="product" style="width: 350px;height:200px"></ul>
                                </td>
                              <td id="relatedTarget">
                                    <select multiple="multiple" id="related" size="10" style="width: 350px;;height:200px"></select>
                              </td>
                              <td id="relatedTrash">
                                    <img src="image/trash_empty.png" alt="Papelera" />
                              </td>
                            </tr>
                        </table>
                        <div id="product_related">
                        <?php foreach ($product_related as $related_id) { ?>
                            <input type="hidden" name="product_related[]" value="<?php echo $related_id; ?>" showquick="off" />
                        <?php } ?>
                        </div>
                    </div>
                    
                    <div class="clear"></div>
                    
                </div>
        