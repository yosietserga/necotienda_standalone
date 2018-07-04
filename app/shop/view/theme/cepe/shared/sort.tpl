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

<script id="sort">
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