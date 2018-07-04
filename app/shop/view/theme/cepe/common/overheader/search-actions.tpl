<aside class="search action-input nt-editable large-12 medium-12 small-12 columns" data-component="main-search">
    <section class="row collapse">
        <aside id="search" class="large-9 medium-9 small-9 columns">
            <input class="search-input" id="filterKeyword" type="search" placeholder="Buscar en tienda. Ej: Producto..." data-input="search"/>
        </aside>
        <aside class="large-1 medium-1 small-1 columns">
            <a class="clear-trigger" title="Limpiar campo" data-action="clear-input" style="">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/close.tpl"); ?>
            </a>
        </aside>
        <aside class="large-2 medium-2 small-2 columns">
            <a class="search-trigger" title="Buscar" onclick="moduleSearch($('#filterKeyword'));">
                <i class="icon input-icon icon-search">
                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/search.tpl"); ?>
                </i>
            </a>
        </aside>
    </section>
</aside>