<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <div class="filter-form simple-form break">
        <div class="form-entry">
            <input type="text" name="filter_list" id="filter_list" value="" placeholder="<?php echo $Language->get('text_recommendations');?>" />
        </div>
        <div class="form-entry">
            <select name="filter_status" id="filter_status">
                <option value=""><?php echo $Language->get('select_all');?></option>
                <?php foreach ($statuses as $status) { ?>
                <option value="<?php echo $status['order_status_id']; ?>"><?php echo $status['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-entry">
        <select name="filter_limit" id="filter_limit">
            <option value="5"><?php echo $Language->get('select_five_per_page');?></option>
            <option value="10"><?php echo $Language->get('select_ten_per_page');?></option>
            <option value="20"><?php echo $Language->get('select_twenty_per_page');?></option>
            <option value="50"><?php echo $Language->get('select_fifty_per_page');?></option>
        </select>
        </div>
        <div class="btn btn-filter btn--primary" data-action="filter" role="button" aria-label="Sort">
            <a onclick="filter()" id="filter"><?php echo $Language->get('text_filter');?></a>
        </div>
    </div>
    <div class="tabulated-data order-data" data-table="orders">
        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
            <?php if ($orders) { ?>
                <table>
                    <thead>
                    <tr>
                        <th style="width:5%"><div class="check-action"><input data-check='allOrders' title="Seleccionar Todos" type="checkbox"/><span></span></div></th>
                        <th style="width:15%"><?php echo $text_order; ?></th>
                        <th style="width:15%"><?php echo $text_status; ?></th>
                        <th style="width:15%"><?php echo $text_products; ?></th>
                        <th style="width:15%"><?php echo $text_date_added; ?></th>
                        <th style="width:15%"><?php echo $text_total; ?></th>
                        <th style="width:20%"><?php echo $Language->get('text_actions');?></th>
                    </tr>
                    </thead>
                    <?php foreach ($orders as $value) { ?>
                        <tr id="pid_<?php echo $value['order_id']; ?>">
                            <td data-label="Seleccionar"><div class="check-action"><input data-check="order" type="checkbox" name="selected[]" value="<?php echo $value['order_id']; ?>"<?php if ($value['selected']) { ?> checked="checked"<?php } ?> /><span></span></div></td>
                            <td data-label="<?php echo $text_order; ?>">#<?php echo $value['order_id']; ?></td>
                            <td data-label="<?php echo $text_status; ?>" id="status<?php echo $value['order_id']; ?>"><?php echo $value['status']; ?></td>
                            <td data-label="<?php echo $text_products; ?>"><?php echo $value['products']; ?></td>
                            <td data-label="<?php echo $text_date_added; ?>"><?php echo $value['date_added']; ?></td>
                            <td data-label="<?php echo $text_total; ?>"><?php echo $value['total']; ?></td>
                            <td data-label="Acciones">
                                <div class="group group--btn" role="group">
                                    <div class="btn btn-detail" data-action="showDetail">
                                        <a href="<?php echo $Url::createUrl("account/invoice",array("order_id"=>$value['order_id'])); ?>" title="Ver Detalles"><?php echo $Language->get('text_see');?></a>
                                    </div>
                                    <div class="btn btn-add btn--secondary" data-action="addToCart" role="button" aria-label="AddToCart">
                                        <?php if ($value['order_status_id'] != 7) { ?>
                                            <a href="<?php echo $Url::createUrl("account/payment/register",array("order_id"=>$value['order_id'])); ?>" title="Pagar"><?php echo $Language->get('text_pay');?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
            <?php } else { ?>
            <div class="no-info"><?php echo $Language->get('text_empty');?>, <a href="<?php echo $Url::createUrl("common/home"); ?>" title="Comprar"><?php echo $Language->get('text_empty');?></a></div>
            <?php } ?>
        </form>
    </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<script>
    (function () {
        window.deferjQuery(function () {

            var checkerForAll = document.querySelector("[data-check='allOrders']");
            var ordersInputs = document.querySelectorAll("[data-table='orders'] * [data-check='order']");

            var isChecked = function (check) {
                return (check.checked);
            };
            var switchChecks = function () {
                var args = [].slice.call(arguments);
                return [].forEach.call(args[1], function(check) {
                    check.checked = args[0];
                });
            };


            function filterProducts() {
                var url = '';
                var subjectFilter = $('#filter_subject').val();
                var sortFilter = $('#filter_sort').val();
                var statusFilter = $('#filter_status').val();
                var limitFilter = $('#filter_limit').val();

                if (subjectFilter) {
                    url += '&keyword=' + subjectFilter;
                }

                if (sortFilter) {
                    url += '&sort=' + sortFilter;
                }

                if (statusFilter) {
                    url += '&status=' + statusFilter;
                }

                if (limitFilter) {
                    url += '&limit=' + limitFilter;
                }
                window.location.href = '<?php echo $Url::createUrl("account/order"); ?>' + url;
                return false;
            }

            $('#filter').on('click', function (e) {
                filterProducts();
                return false;
            });
            $('#filter_customer_product').on('keydown', function (e) {
                if (e.keyCode === 13) {
                    filterProducts();
                }
                return false;
            });
            checkerForAll.addEventListener('click', function (e) {
            var checkbox = e.target;
            if (checkbox.checked) {
                    switchChecks(true, ordersInputs);
                } else if ([].some.call(ordersInputs, isChecked) && !checkbox.checked) {
                    switchChecks(false, ordersInputs);
                }
                return false;
            }, false);
        });
    })();
</script>
<?php echo $footer; ?>