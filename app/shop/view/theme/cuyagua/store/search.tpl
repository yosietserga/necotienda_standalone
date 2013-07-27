<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="nt-editable">
    <section id="content" class="nt-editable">
        <div class="grid_16">
            <ul id="breadcrumbs" class="nt-editable">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
            </ul>
        </div>
        
        <div class="clear"></div><br /><br />
        
        <div class="grid_16">
            <div id="featuredContent" class="nt-editable">
            <?php if($featuredWidgets) { ?><ul class="widgets"><?php foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <aside id="column_left" class="grid_3 nt-editable">
        
            <?php if ($filters) { ?>
            <div class="box nt-editable" id="filters">
                <div class="header"><hgroup><h1>Filtros</h1></hgroup></div>
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
            <div class="box nt-editable" id="filterCategory">
                <div class="header"><hgroup><h1>Categor&iacute;as</h1></hgroup></div>
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
            <div class="box nt-editable" id="filterManufacturer">
                <div class="header"><hgroup><h1>Fabricantes</h1></hgroup></div>
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
            <div class="box nt-editable" id="filterPrices">
                <div class="header"><hgroup><h1>Precios</h1></hgroup></div>
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
            
            <div class="box nt-editable" id="filterColors">
                <div class="header"><hgroup><h1>Colores</h1></hgroup></div>
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
        
        <section id="products" class="grid_13 nt-editable">
            <hgroup><h1><?php echo $heading_title; ?></h1></hgroup>
            
            <div class="content">
                <?php if ($noResults) { ?><div class="message warning">No se encontraron resultados</div><?php } ?>
                <?php if ($sorts) { ?>
                <div id="sort" class="sort nt-editable">
                    <select name="sort" onchange="window.location.href = this.value">
                        <?php foreach ($sorts as $sorted) { ?>
                        <option value="<?php echo $sorted['href']; ?>"<?php if (($sort . '-' . $order) == $sorted['value']) { ?> selected="selected"<?php } ?>><?php echo $sorted['text']; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo $Language->get('text_sort'); ?>
                          
                    <a class="view_style" 
                        <?php if (isset($_GET['v']) && $_GET['v'] == 'list') { ?>
                        title="Ver en Miniaturas" 
                        style="background-position:0 -23px"
                        href="<?php echo str_replace('&', '&amp;', $gridView); ?>"
                        <?php } else { ?>
                        title="Ver en Listado"
                        href="<?php echo str_replace('&', '&amp;', $listView); ?>"<?php } ?>>&nbsp;</a>
                </div> 
                <?php } ?>
                    
                <?php if(isset($_GET['v']) && $_GET['v'] == 'list') { ?>
                <div class="list_view nt-editable" id="product_list">
                    <?php $class = "even"; ?>
                    <?php foreach($products as $product) { ?>
                    <article class="product_preview <?php echo ($class=="even") ? "odd" : "even"; ?>">
                        <div class="grid_4">
                            <a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>" class="thumb"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                            <?php if ($product['rating']) { ?>
                            <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
                            <?php } ?>
                        </div>
                                    
                        <div class="grid_5">
                            <a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>" class="name"><?php echo $product['name']; ?></a>
                            <p class="model"><?php echo $product['model']; ?></p>
                            <p class="overview"><?php echo substr($product['overview'],0,150)." ... "; ?><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a></p>
                        </div>
                                    
                        <div class="class_3" style="float: right;">
                        <?php if ($display_price) { ?>
                            <?php if (!$product['special']) { ?>
                            <p class="price"><?php echo $product['price']; ?></p>
                            <?php } else { ?>
                            <p class="old_price"><?php echo $product['price']; ?></p> 
                            <p class="new_price"><?php echo $product['special']; ?></p>
                            <?php } ?>
                            <?php } ?>
                            <a title="<?php echo $Language->get('button_see_product'); ?>" class="button_see_small" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><?php echo $Language->get('button_see_product'); ?></a>
                            <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="button_add_small" href="<?php echo str_replace('&', '&amp;', $product['add']); ?>"><?php echo $Language->get('button_add_to_cart'); ?></a>
                        </div>
                                    
                    </article>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="grid_view nt-editable" id="product_grid">
                    <ul class="grid-hover">
                        <?php foreach($products as $product) { ?>
                        <li>
                            <a class="thumb" title="<?php echo $product['name']; ?>">
                                <img src="<?php echo HTTP_IMAGE; ?>data/preloader.gif" data-original="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />        
                                <div>
                                    <span>
                                        <?php echo $product['name']; ?>
                                        <p class="model"><?php echo $product['model']; ?></p>
                                        <?php if ($display_price) { ?>
                                        <?php if (!$product['special']) { ?>
                                        <p class="price"><?php echo $product['price']; ?></p>
                                        <?php } else { ?>
                                        <p class="old_price"><?php echo $product['price']; ?></p> 
                                        <p class="special"><?php echo $product['special']; ?></p>
                                        <?php } ?>
                                        <?php } ?>
                                        <b title="<?php echo $Language->get('button_see_product'); ?>" class="button_see_small" onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['href']); ?>'"></b>
                                        <b title="<?php echo $Language->get('button_add_to_cart'); ?>" class="button_add_small" <?php if (!$this->config->get("cart_ajax") && !$product['option']) { ?>onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['add']); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>></b>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                        
                <div class="clear"></div>
                        
                <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
            <?php } ?>
            </div>
    </section>
</section>
<?php echo $footer; ?>