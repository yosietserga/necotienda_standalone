<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <!-- column-left -->
        <?php if ($column_left) { ?>
            <aside id="column_left" class="column-left large-3 medium-12 small-12 columns">
                <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
                    <div class="heading-title">
                    <h3>
                        <i class="icon heading-icon fa fa-filter fa-2x"></i>
                            Filtros
                        </h3>
                    </div>
                </div>

                <div class="widget-content sidebar-list" id="filtersWidget">
                    <ul class="filters-list">
                        <?php if ($filters) { ?>
                            <li class="filter-selected">
                                <a class="filter-heading" href="javascript:void(0)"><span>Filtros Selecionados</span></a>
                                <div class="filter-options">
                                    <ul id="filter-selected" class="filter-list">
                                        <?php foreach ($filters as $key => $value) { ?>
                                        <li><a href="<?php echo $value['href']; ?>"><?php echo $value['name'];?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterCategories) && !isset($filters['category'])) { ?>
                            <li class="filter-categories">
                                <a class="filter-heading" href="javascript:void(0)"><span>Filtrar Por Categor&iacute;a</span></a>
                                <div class="filter-options">
                                    <ul id="filter-categories" class="filter-list">
                                        <?php foreach ($filterCategories as $key => $value) { ?>
                                            <li><a href="<?php echo rtrim($urlCriterias['forCategories'] .'_Cat_'. str_replace(' ','-',strtolower($value['name'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterManufacturers) && !isset($filters['manufacturer'])) { ?>
                            <li class="filter-manufacturers">
                                <a href="javascript:void(0)" class="filter-heading"><span>Filtrar Por Fabricanter</span></a>
                                <div class="filter-options">
                                    <ul id="filter-manufacturers" class="filter-list">
                                        <?php foreach ($filterManufacturers as $key => $value) { ?>
                                        <li><a href="<?php echo rtrim($urlCriterias['forManufacturers'] .'_Marca_'. str_replace(' ','-',strtolower($value['name'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterZones) && !isset($filters['zone'])) { ?>
                            <li class="filter-zones">
                                <a href="javascript:void(0)" class="filter-heading"><span>Filtrar Por Estado</span></a>
                                <div class="filter-options">
                                    <ul id="filter-zones" class="filter-list">
                                        <?php foreach ($filterZones as $key => $value) { ?>
                                        <li><a href="<?php echo rtrim($urlCriterias['forZones'] .'_Estado_'. str_replace(' ','-',strtolower($value['name'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterStores) && !isset($filters['stores'])) { ?>
                            <li class="filter-stores">
                                <a class="filter-heading" href="javascript:void(0)"><span>Filtrar Por Tiendas</span></a>
                                <div class="filter-options">
                                    <ul id="filter-stores" class="filter-list">
                                        <?php foreach ($filterStores as $key => $value) { ?>
                                        <li><a href="<?php echo rtrim($urlCriterias['forStores'] .'_Tienda_'. str_replace(' ','-',strtolower($value['name'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterSellers) && !isset($filters['seller'])) { ?>
                            <li class="filter-sellers">
                                <a class="filter-heading" href="javascript:void(0)"><span>Filtrar Por Vendedor</span></a>
                                <div class="filter-options">
                                    <ul id="filter-sellers" class="filter-list">
                                        <?php foreach ($filterSellers as $key => $value) { ?>
                                        <li><a href="<?php echo rtrim($urlCriterias['forSellers'] .'_Vendedor_'. str_replace(' ','-',strtolower($value['company'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['company'];?> (<?php echo $value['total']; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterPrices) && !isset($filters['price'])) { ?>
                            <li class="filter-price">
                                <a class="filter-heading" href="javascript:void(0)"><span>Filtrar Por Precios</span></a>
                                <div id="filter-price" class="filter-options">
                                    <div class="price-controls row">
                                        <div class="large-6 medium-6 small-5 columns">
                                            <input type="text" name="bottomPrice" id="bottomPrice" placeholder="Precio Min"/>
                                        </div>
                                        <div class="large-6 medium-6 small-5 columns">
                                            <input type="text" name="topPrice" id="topPrice" placeholder="Precio Max" />
                                        </div>
                                    </div>
                                    <ul>
                                        <?php foreach ($filterPrices as $key => $value) { ?>
                                            <li><a href="<?php echo rtrim($urlCriterias['forPrices'] .'_Precio_'. $value['bottomValue'] .'-'. $value['topValue'] .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['bottomText'] .' - '. $value['topText']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if ($filterColors) { ?>
                            <li class="filter-list color-filter">
                                <a class="filter-heading" href="javascript:void(0)"><span>Filtrar Por Colores</span></a>
                                <ul id="filter-color" class="filter-list">
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
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php echo $column_left; ?>
        </aside>
    <?php } ?>
    <!-- /column-left -->

    <!--column-center -->
    <?php if ($column_left && $column_right) { ?>
        <div class="column-center large-6 medium-12 small-12 columns">
    <?php } elseif ($column_left || $column_right) { ?>
        <div class="column-center large-9 medium-12 small-12 columns">
    <?php } else { ?>
        <div class="column-center large-12 medium-12 small-12 columns">
    <?php } ?>

        <h1>Resultados de Busqueda</h1>
        <?php if ($noResults) { ?><div class="message warning">No se encontraron resultados</div><?php } ?>
        <?php if ($sorts) { ?>
            <div class="sort filter-sort">
                <select name="sort" onchange="window.location.href = this.value">
                    <?php foreach ($sorts as $sorted) { ?>
                    <option value="<?php echo $sorted['href']; ?>"<?php if (($sort . '-' . $order) == $sorted['value']) { ?> selected="selected"<?php } ?>><?php echo $sorted['text']; ?></option>
                    <?php } ?>
                </select>
                <a class="view_style" onclick="if ($('#productsWrapper').hasClass('catalog-list')) { $('#productsWrapper').removeClass('catalog-list').addClass('catalog-grid'); $(this).find('i').removeClass('fa-th-list').addClass('fa-th-large'); } else { $('#productsWrapper').removeClass('catalog-grid').addClass('catalog-list'); $(this).find('i').removeClass('fa-th-large').addClass('fa-th-list'); }">
                    <i class="fa fa-th-list fa-2x"></i>
                </a>
            </div>
        <?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-list.tpl"); ?>
    <!-- column-center -->

    <!-- column-right -->
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    <!-- column-right -->

</section>
<?php echo $footer; ?>