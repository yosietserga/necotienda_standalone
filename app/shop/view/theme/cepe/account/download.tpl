<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <?php if ($downloads) { ?>
    <div class="filter simple-form">
        <?php echo $Language->get('text_search_label');?>
        <input type="text" name="filter_name" id="filter_name" value="" placeholder="Buscar..." />
        <select name="filter_limit" id="filter_limit">
            <option value="5">5 por p&aacute;gina</option>
         <option value="10">10 por p&aacute;gina</option>
            <option value="20">20 por p&aacute;gina</option>
            <option value="50">50 por p&aacute;gina</option>
        </select>
        <a href="#" id="filter" class="button"><?php echo $Language->get('text_filter_button');?></a>
    </div>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
        <table>
            <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" style="width: 5px !important;" /></th>
                <th><?php echo $text_order; ?></th>
                <th><?php echo $text_name; ?></th>
                <th><?php echo $text_size; ?></th>
                <th><?php echo $text_remaining; ?></th>
                <th><?php echo $text_date_added; ?></th>
                <th><?php echo $text_download; ?></th>
            </tr>
            </thead>
            <?php foreach ($downloads as $value) { ?>
            <tr id="pid_<?php echo $value['order_id']; ?>">
                <td><input type="checkbox" name="selected[]" value="<?php echo $value['order_id']; ?>"<?php if ($value['selected']) { ?> checked="checked"<?php } ?> style="width: 5px !important;" /></td>
                <td><b>#<?php echo $value['order_id']; ?></b></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['size']; ?></td>
                <td><?php echo $value['remaining']; ?></td>
                <td><?php echo $value['date_added']; ?></td>
                <td>
                    <a href="<?php echo str_replace('&', '&amp;', $value['href']); ?>" title="<?php echo $text_download; ?>" class="button"><?php echo $text_download; ?></a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    </form>
    <?php } else { ?>
    <div><?php echo $Language->get('text_empty_page');?></div>
    <?php } ?>

    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<script>
(function () {
    window.deferjQuery(function () {
        function filterProducts() {
            var url = '';
            var subjectFilter = $('#filter_subject').val();
            var sortFilter = $('#filter_sort').val();
            var statusFilter = $('#filter_status').val();
            var limitFilter = $('#filter_limit').val();

            if (subjectFilter){
                url += '&keyword=' + subjectFilter;
            }

            if (sortFilter){
                url += '&sort=' + sortFilter;
            }

            if (statusFilter){
                url += '&status=' + statusFilter;
            }

            if (limitFilter){
                url += '&limit=' + limitFilter;
            }
            window.location.href = '<?php echo $Url::createUrl("account/order"); ?>' + url;
            return false;
        }
        $('#filter').on('click',function(e){
            filterProducts();
            return false;
        });
        $('#filter_customer_product').on('keydown',function(e) {
            if (e.keyCode == 13) {
                filterProducts();
            }
            return false;
        });
    });
})();
</script>
<?php echo $footer; ?>