<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent">
    <section id="content">
        <aside id="column_left" class="aside">
        
            <?php if ($filters) { ?>
            <div class="box">
                <div class="header"><hgroup><h1>Filtros Seleccionados</h1></hgroup></div>
                <div class="content filter">
                    <ul id="filter-selected">
                        <?php foreach ($filters as $key => $value) { ?>
                        <li><a href="<?php echo $Url::createUrl("store/search") . $$value['param']; ?>"><?php echo $value['text'];?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($filterCategories) { ?>
            <div class="box">
                <div class="header"><hgroup><h1>Filtrar Por Categor&iacute;as</h1></hgroup></div>
                <div class="content filter">
                    <ul id="filter-cateogies">
                        <?php foreach ($filterCategories as $key => $value) { ?>
                        <li><a href="<?php echo $Url::createUrl("store/search",array('c'=>$value['name'])) . $urlCategories; ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($filterManufacturers) { ?>
            <div class="box">
                <div class="header"><hgroup><h1>Filtar Por Fabricantes</h1></hgroup></div>
                <div class="content filter">
                    <ul id="filter-manufacturers">
                        <?php foreach ($filterManufacturers as $key => $value) { ?>
                        <li><a href="<?php echo $Url::createUrl("store/search",array('m'=>$value)) . $urlManufacturers; ?>"><?php echo $value;?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($filterPrices) { ?>
            <div class="box">
                <div class="header"><hgroup><h1>Filtar Por Precios</h1></hgroup></div>
                <div class="content filter">
                    <ul id="filter-price">
                        <li>
                            <input type="text" name="bottomPrice" id="bottomPrice" onclick="searchByPrices(this)" placeholder="Precio Min" style="padding:0px 4px;width:35%;height:30px;border:solid 1px #999;" />
                            <span style="margin:5px 10px;padding:0px;width:10px;float:left">&nbsp;-&nbsp;</span>
                            <input type="text" name="topPrice" id="topPrice" onclick="searchByPrices(this)" placeholder="Precio Max" style="padding:0px 4px;width:35%;height:30px;border:solid 1px #999" />
                            <div class="clear"></div><br />
                        </li>
                        <?php foreach ($filterPrices as $key => $value) { ?>
                        <li><a href="<?php echo $Url::createUrl("store/search",array('ps'=>$value['bottomValue'],'pe'=>$value['topValue'])) . $urlPrices; ?>"><?php echo $value['bottomText'] .' - '. $value['topText']; ?></a><div class="clear"></div><br /></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            
            <div class="box">
                <div class="header"><hgroup><h1>Filtar Por Colores</h1></hgroup></div>
                <div class="content filter">
                    <ul id="filter-color">
                        <li>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Rojo')) . $urlPrices; ?>" class="filterColor" title="Rojo" style="background: red;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Azul')) . $urlPrices; ?>" class="filterColor" title="Azul" style="background: blue;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Amarillo')) . $urlPrices; ?>" class="filterColor" title="Amarillo" style="background: yellow;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Negro')) . $urlPrices; ?>" class="filterColor" title="Negro" style="background: #000;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Blanco')) . $urlPrices; ?>" class="filterColor" title="Blanco" style="background: #fff;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Verde')) . $urlPrices; ?>" class="filterColor" title="Verde" style="background: green;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Rojo Oscuro')) . $urlPrices; ?>" class="filterColor" title="Rojo Oscuro" style="background: #900;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Naranja')) . $urlPrices; ?>" class="filterColor" title="Naranja" style="background: #ce6b00;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Marron')) . $urlPrices; ?>" class="filterColor" title="Marr&oacute;n" style="background: #631201;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Gris')) . $urlPrices; ?>" class="filterColor" title="Gris y Plateado" style="background: #5a5856;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Azul Oscuro')) . $urlPrices; ?>" class="filterColor" title="Azul Oscuro" style="background: #002858;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Azul Claro')) . $urlPrices; ?>" class="filterColor" title="Azul Claro" style="background: #009bdb;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Morado')) . $urlPrices; ?>" class="filterColor" title="Morado" style="background: #630047;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Dorado')) . $urlPrices; ?>" class="filterColor" title="Dorado" style="background: #83600c;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Verde Claro')) . $urlPrices; ?>" class="filterColor" title="Verde Claro" style="background: #99bd73;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Amarillo Claro')) . $urlPrices; ?>" class="filterColor" title="Amarillo Claro" style="background: #fef271;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Carne')) . $urlPrices; ?>" class="filterColor" title="Carne" style="background: #e4b386;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Fucsia')) . $urlPrices; ?>" class="filterColor" title="Fucsia" style="background: #ba007c;"></a>
                            <a href="<?php echo $Url::createUrl("store/search",array('co'=>'Rosado')) . $urlPrices; ?>" class="filterColor" title="Rosado" style="background: #db9da1;"></a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <?php echo $column_left; ?>

        </aside>
        
        <section id="products" class="grid_13">
            <hgroup><h1><?php echo $heading_title; ?></h1></hgroup>
            
            <div class="content">
                <?php if ($noResults) { ?><div class="message warning">No se encontraron resultados</div><?php } ?>
                
                <?php if ($sort) { ?>
                <div class="sort">
                    <select name="sort" <?php echo (array_key_exists('ajax',$sorts[0])) ? "onchange='sort(this,this.value)' " : "onchange='window.location = this.value'"; ?>>
                      <?php foreach ($sorts as $sorted) { ?>
                          <?php if (($sort . '-' . $order) == $sorted['value']) { ?>
                            <option value="<?php echo $sorted['href']; ?>" selected="selected"><?php echo $sorted['text']; ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $sorted['href']; ?>"><?php echo $sorted['text']; ?></option>
                          <?php } ?>
                      <?php } ?>
                    </select>
                  <?php echo $text_sort; ?>
                  
                      <?php if (isset($_GET['v']) && $_GET['v']=='list') { ?>
                      <a class="view_style" onclick="$('#products').html('<img src=\'<?php echo HTTP_IMAGE; ?>loader.gif\' alt=\'Cargando...\' />');$('#products').load('<?php echo str_replace('&', '&amp;', $gridView); ?>')" title="Ver en Miniaturas"  style="background-position:0 -23px">&nbsp;</a>    
                      <?php } else { ?>
                      <a class="view_style" onclick="$('#products').html('<img src=\'<?php echo HTTP_IMAGE; ?>loader.gif\' alt=\'Cargando...\' />');$('#products').load('<?php echo str_replace('&', '&amp;', $listView); ?>')" title="Ver en Listado">&nbsp;</a>    
                      <?php } ?>
                </div> 
                <?php } ?>
            
                <div class="clear"></div>
                <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
                <div class="clear"></div>
                
                <div class="list_view" id="productsWrapper">
                    <ul>
                    <?php foreach($products as $product) { ?>
                        <li>
                            <a class="thumb" title="<?php echo $product['name']; ?>">
                                <img src="<?php echo HTTP_IMAGE; ?>data/preloader.gif" data-original="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="nt-lazyload" />
                            </a>
                            <div class="product_info nt-hoverdir">
                                <?php echo $product['sticker']; ?>
                                
                                <a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>" class="name"><?php echo $product['name']; ?></a>
                                
                                <?php if ($product['rating']) { ?><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" /><?php } ?>
                                
                                <p class="model"><?php echo $product['model']; ?></p>
                                
                                <p class="overview"><?php echo substr($product['overview'],0,150)." ... "; ?><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a></p>
                                
                                <div class="description"><?php echo $product['description']; ?></div>
                                
                                <?php if ($display_price) { ?>
                                <?php if (!$product['special']) { ?>
                                <p class="price"><?php echo $product['price']; ?></p>
                                <?php } else { ?>
                                <p class="old_price"><?php echo $product['price']; ?></p> 
                                <p class="special"><?php echo $product['special']; ?></p>
                                <?php } ?>
                                <?php } ?>
                                
                                <a title="<?php echo $button_quick_view; ?>" class="button_quick_view" onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['href']); ?>'"><?php echo $Language->get('button_quick_view'); ?></a>
                                <a title="<?php echo $button_see_product; ?>" class="button_see_small" onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['href']); ?>'"><?php echo $Language->get('button_see_product'); ?></a>
                                <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="button_add_small" <?php if (!$this->config->get("cart_ajax") && !$product['option']) { ?>onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['add']); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
                            </div>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="clear"></div>
                        
                <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
            </div>
    </section>
</section>
<?php echo $footer; ?>