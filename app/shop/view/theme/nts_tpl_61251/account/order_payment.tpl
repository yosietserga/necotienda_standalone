<?php echo $header; ?>

<!--contentContainer -->
<div id="contentContainer" class="tpl-home" nt-editable>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-featured.tpl");?>

    <!--mainContentContainer -->
    <div id="mainContentContainer" nt-editable>
        <div class="row">

            <!-- left-column -->
            <div class="large-3 medium-3 small-12">
                <div id="columnLeft" nt-editable>
                    <?php echo $account_column_left; ?>
                    <?php if ($column_left) { echo $column_left; } ?>
                </div>
            </div>
            <!--/left-column -->

            <!--center-column -->
            <?php if ($column_left && $column_right) { ?>
            <div class="large-6 medium-6 small-12">
                <?php } elseif ($column_left || $column_right) { ?>
                <div class="large-9 medium-9 small-12">
                    <?php } else { ?>
                    <div class="large-12 medium-12 small-12">
                        <?php } ?>
                        <div id="columnCenter" nt-editable>


                                <div class="form-entry">
                                    <input type="text" name="filter_order" id="filter_order" value="" placeholder="Buscar Pedido..." />
                                </div>
                                <?php echo $text_sort; ?>
                                <div class="btn btn-filter btn--primary" data-action="filter" role="button" aria-label="Sort">
                                    <a href="#" id="filter"><?php echo $Language->get('text_filter');?></a>
                                </div>

                            <ul id="paymentMethods" class="nt-editable payment-methods">
                                <?php foreach ($payment_methods as $payment_method) { ?>
                                <li data-action="payment">{%<?php echo $payment_method['id']; ?>%}</li>
                                <?php } ?>
                            </ul>




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
                    </div>
                    <!--/center-column -->

                    <!-- right-column -->
                    <?php if ($column_right) { ?>
                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-column-right.tpl");?>
                    <?php } ?>
                    <!--/right-column -->

                </div>
            </div>
            <!--/mainContentContainer -->

            <!--featuredFooterContainer -->
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/widgets-featured-footer.tpl");?>
            <!--/featuredFooterContainer -->

        </div>
        <!--/contentContainer -->

        <?php echo $footer; ?>