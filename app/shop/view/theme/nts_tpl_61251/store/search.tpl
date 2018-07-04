<?php echo $header; ?>

<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>

    <?php if ($column_right) { ?>
        <section id="content" class="home-grid-small">
    <?php } else { ?>
        <section id="content" class="home-grid-medium">
    <?php } ?>

    <!-- column-left -->
        <aside id="columnLeft" class="column-left large-3 medium-12 small-12 columns">
            <div class="widgets aside-column">
                <div class="heading widget-heading" id="<?php echo $widgetName; ?>Header">
                    <div class="heading-title">
                    <h3>
                        <?php echo $Language->get('text_filter'); ?>
                    </h3>
                    </div>
                </div>

                <div class="widget-content sidebar-list break" id="filtersWidget">
                    <ul class="filters-list">
                        <?php if ($filters) { ?>
                            <li class="filter-selected">
                                <a class="filter-heading" href="javascript:void(0)" style="background-image: none;">
                                    <strong><?php echo $Language->get('Filters'); ?></strong>
                                </a>
                                <div class="filter-options" style="display: block; max-height: 25rem; overflow-y: auto">
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
                                <a class="filter-heading" href="javascript:void(0)" style="background-image: none;">
                                    <strong><?php echo $Language->get('By Category'); ?></strong>
                                </a>
                                <div class="filter-options" style="display: block; max-height: 25rem; overflow-y: auto">
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
                                <a href="javascript:void(0)" class="filter-heading" style="background-image: none;">
                                    <strong><?php echo $Language->get('By Manufacturer'); ?></strong>
                                </a>
                                <div class="filter-options" style="display: block; max-height: 25rem; overflow-y: auto">
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
                                <a href="javascript:void(0)" class="filter-heading" style="background-image: none;">
                                    <strong><?php echo $Language->get('By Zone'); ?></strong>
                                </a>
                                <div class="filter-options" style="display: block; max-height: 25rem; overflow-y: auto">
                                    <ul id="filter-zones" class="filter-list">
                                        <?php foreach ($filterZones as $key => $value) { ?>
                                        <li>
                                            <a href="<?php echo rtrim($urlCriterias['forZones'] .'_Estado_'. str_replace(' ','-',strtolower($value['name'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterStores) && !isset($filters['stores'])) { ?>
                            <li class="filter-stores">
                                <a class="filter-heading" href="javascript:void(0)" style="background-image: none;">
                                    <strong><?php echo $Language->get('By Store'); ?></strong>
                                </a>
                                <div class="filter-options" style="display: block; max-height: 25rem; overflow-y: auto">
                                    <ul id="filter-stores" class="filter-list">
                                        <?php foreach ($filterStores as $key => $value) { ?>
                                        <li>
                                            <a href="<?php echo rtrim($urlCriterias['forStores'] .'_Tienda_'. str_replace(' ','-',strtolower($value['name'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['name'];?> (<?php echo $value['total']; ?>)</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterSellers) && !isset($filters['seller'])) { ?>
                            <li class="filter-sellers">
                                <a class="filter-heading" href="javascript:void(0)" style="background-image: none;">
                                    <strong><?php echo $Language->get('By Seller'); ?></strong>
                                </a>
                                <div class="filter-options">
                                    <ul id="filter-sellers" class="filter-list" style="display: block; max-height: 25rem; overflow-y: auto">
                                        <?php foreach ($filterSellers as $key => $value) { ?>
                                        <li><a href="<?php echo rtrim($urlCriterias['forSellers'] .'_Vendedor_'. str_replace(' ','-',strtolower($value['company'])) .'?'. implode('',$urlQuery),'?'); ?>"><?php echo $value['company'];?> (<?php echo $value['total']; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($filterPrices) && !isset($filters['price'])) { ?>
                            <li class="filter-price">
                                <a class="filter-heading" href="javascript:void(0)" style="background-image: none;">
                                    <strong><?php echo $Language->get('By Price'); ?></strong>
                                </a>
                                <div id="filter-price" class="filter-options" style="display: block; max-height: 25rem; overflow-y: auto">
                                    <div class="price-controls row">
                                        <div class="large-6 medium-6 small-5 columns">
                                            <input type="text" name="bottomPrice" id="bottomPrice" placeholder="Min"/>
                                        </div>
                                        <div class="large-6 medium-6 small-5 columns">
                                            <input type="text" name="topPrice" id="topPrice" placeholder="Max"/>
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
                                <a class="filter-heading" href="javascript:void(0)">
                                    <strong><?php echo $Language->get('text_filter_per_color'); ?></strong>
                                </a>
                                <ul id="filter-color" class="filter-list" style="display: block; max-height: 25rem; overflow-y: auto">
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
    <?php if ($column_left) { ?>
            <?php echo $column_left; ?>
    <?php } ?>
    <!-- /column-left -->
        </div>
    </aside> 
    <!--column-center -->
    <?php if ($column_right) { ?>
        <aside id="columnCenter" class="large-6 medium-12 small-12 columns">
            <div class="widgets center-column"> 
    <?php } else { ?>
        <aside id="columnCenter" class="large-9 medium-12 small-12 columns">
            <div class="widgets center-column">
    <?php } ?> 
        <header class="page-heading">
            <h1><?php echo $Language->get('text_search_results'); ?></h1>
        </header>
        <?php if ($noResults) { ?><div class="message warning"><?php echo $Language->get('text_no_results'); ?></div><?php } ?>
        <?php if ($sorts) { ?>
            <div class="sort filter-sort">
                <select name="sort" onchange="window.location.href = this.value">
                    <?php foreach ($sorts as $sorted) { ?>
                    <option value="<?php echo $sorted['href']; ?>"<?php if (($sort . '-' . $order) == $sorted['value']) { ?> selected="selected"<?php } ?>><?php echo $sorted['text']; ?></option>
                    <?php } ?>
                </select>
                <a data-action="sort" class="view_style">
                    <i class="icon icon-sort">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/th-large.tpl"); ?> 
                    </i>
                </a>
            </div>
        <?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-list.tpl"); ?>
    <!-- column-center -->
    
        <!-- widgets -->
        <div class="large-12 medium-12 small-12 columns">
            <?php $position = 'main'; ?>
            <?php foreach($rows[$position] as $j => $row) { ?>
            <?php if (!$row['key']) continue; ?>
            <?php $row_id = $row['key']; ?>
            <?php $row_settings = unserialize($row['value']); ?>
            <div class="row" id="<?php echo $position; ?>_<?php echo $row_id; ?>" nt-editable>
                <?php foreach($row['columns'] as $k => $column) { ?>
                <?php if (!$column['key']) continue; ?>
                <?php $column_id = $column['key']; ?>
                <?php $column_settings = unserialize($column['value']); ?>
                <div class="large-<?php echo $column_settings['grid_large']; ?> medium-<?php echo $column_settings['grid_medium']; ?> small-<?php echo $column_settings['grid_small']; ?>" id="<?php echo $position; ?>_<?php echo $column_id; ?>" nt-editable>
                    <ul class="widgets">
                        <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget['name']; ?>%} <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <!-- widgets -->

    <!-- column-right -->
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    <!-- column-right -->


</section>
<script>

(function () { 
    window.deferjQuery(function () {
        var listResource = '<?php include(DIR_TEMPLATE  . $this->config->get('config_template') . '/shared/icons/menu.tpl');?>';
        var gridResource = '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . '/shared/icons/th-large.tpl'); ?>';
        var gridModeIcon = '<i class="icon icon-sort">' + gridResource + '</i>';
        var listModeIcon = '<i class="icon icon-sort">' + listResource + '</i>';
        var listModeFlag = 'catalog-list';
        var gridModeFlag = 'catalog-grid';
        var $productsWrapper = $('#productsWrapper');

        $("[data-action='sort']").click(function (e) {
            var isOnListMode = $productsWrapper.hasClass(listModeFlag);
            var $self = $(this);
            e.stopPropagation();
            e.preventDefault();

            if (isOnListMode) {
                $productsWrapper
                    .removeClass(listModeFlag)
                    .addClass(gridModeFlag);
                $self.html(listModeIcon);
            } else {
                $productsWrapper
                    .removeClass(gridModeFlag)
                    .addClass(listModeFlag);
                $self.html(gridModeIcon);
            }
        });
    });
})();
</script>
<?php echo $footer; ?>