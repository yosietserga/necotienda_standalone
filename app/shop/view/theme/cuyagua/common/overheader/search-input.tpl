<?php if (count($languages) >= 2 || count($currencies) >= 2) { ?>
    <div class="search action-input action-input-inverse nt-editable large-6 medium-12 small-12 columns" data-component="main-search">
<?php } else { ?>
    <div class="search action-input action-input-inverse nt-editable large-7 medium-12 small-12 columns" data-component="main-search">
<?php }?>
    <div class="row collapse">
        <div id="search" class="large-10 medium-10 small-10 columns">
            <input class="search-input" id="filterKeyword" type="text" placeholder="Buscar en tienda. Ej: Producto..." data-input="search"/>
        </div>
        <div class="large-1 medium-1 small-1 columns">
            <a class="clear-trigger" title="Limpiar campo" data-action="clear-input">
                <i class="icon input-icon icon-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16">
                      <path d="M11.59 11.804q0 .357-.25.607l-1.215 1.215q-.25.25-.607.25t-.607-.25L6.287 11 3.66 13.625q-.25.25-.606.25t-.607-.25L1.233 12.41q-.25-.25-.25-.606t.25-.607l2.625-2.625-2.625-2.625q-.25-.25-.25-.607t.25-.607L2.447 3.52q.25-.25.607-.25t.607.25l2.626 2.624L8.91 3.52q.25-.25.608-.25t.607.25l1.214 1.213q.25.25.25.607t-.25.607L8.713 8.572l2.625 2.625q.25.25.25.607z" fill="#444"/>
                    </svg>
                </i>
            </a>
        </div>
        <div class="large-1 medium-1 small-1 columns">
            <a class="search-trigger" title="Buscar" onclick="moduleSearch($('#filterKeyword'));">
                <i class="icon input-icon icon-search">
                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/search.tpl"); ?>
                </i>
            </a>
        </div>
    </div>
</div>