<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <div class="actions">
        <div class="print-action">
            <a onclick="window.print();" class="button">Imprimir</a>
            <?php //TODO: <a onclick="window.print();" class="button">PDF</a> ?>
        </div>

        <div class="payment-address">
            <span><?php echo $text_payment_address; ?></span>
            <p><?php echo $payment_address; ?></p>

            <span><?php echo $text_payment_method; ?></span>
            <p><?php echo $payment_method; ?></p>


            <?php if ($shipping_address) { ?>
            <span><?php echo $text_shipping_address; ?></span>
            <p><?php echo $shipping_address; ?></p>
            <?php } ?>

            <?php if ($shipping_method) { ?>
            <span><?php echo $text_shipping_method; ?></span>
            <p><?php echo $shipping_method; ?></p>
            <?php } ?>
        </div>

        <div class="invoice">
            <?php if ($invoice_id) { ?><p><?php echo $text_invoice_id; ?>: <?php echo $invoice_id; ?></p><?php } ?>
            <p><?php echo $text_order_id; ?>: #<?php echo $order_id; ?></p>
            <p><?php echo $column_date_added; ?>: <?php echo $historys[(count($historys)-1)]['date_added']; ?></p>
            <p><?php echo $column_status; ?>:<?php echo $historys[(count($historys)-1)]['status']; ?></p>
        </div>

        <div class="order-table">
            <h3><?php echo $Language->get('text_recipe_details');?></h3>
            <table>
                <tr class="order_table_header">
                    <th><?php echo $text_product; ?></th>
                    <th><?php echo $text_model; ?></th>
                    <th><?php echo $text_quantity; ?></th>
                    <th><?php echo $text_price; ?></th>
                    <th><?php echo $text_total; ?></th>
                </tr>
                <?php foreach ($products as $product) { ?>
                <tr>
                    <td>&nbsp;<a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><?php echo $product['name']; ?></a>
                    <?php foreach ($product['option'] as $option) { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                    <?php } ?></td>
                    <td><?php echo $product['model']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['total']; ?></td>
                </tr>
                <?php } ?>
              </table>
        </div>

        <table id="orderTotals" class="order-totals">
            <?php foreach ($totals as $total) { ?>
            <tr>
                <td><?php echo $total['title']; ?></td>
                <td><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php if ($comment) { ?>
        <div class="oder-comment">
            <span><?php echo $text_comment; ?></span>
            <p><?php echo $comment; ?></p>
        </div>
        <?php } ?>

        <?php if ($historys) { ?>
        <div class="order-history row">
            <h3 class="large-12 medium-12 small-12 columns"><?php echo $text_order_history; ?></h3>
            <?php foreach ($historys as $history) { ?>
            <div class="large-2 medium-2 small-12 columns">
                <?php echo $history['status']; ?><br />
                <?php echo $history['date_added']; ?>
            </div>
            <div class="large-10 medium-10 small-12 columns">
                <?php echo $history['comment']; ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<?php echo $footer; ?>