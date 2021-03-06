<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent">
        <section id="content">
    
        <?php if ($column_left) { ?><aside id="column_left" class="grid_3"><?php echo $column_left; ?></aside><?php } ?>
        
        <?php if ($column_left && $column_right) { ?>
        <div class="grid_6">
        <?php } elseif ($column_left || $column_right) { ?>
        <div class="grid_9">
        <?php } else { ?>
        <div class="grid_12">
        <?php } ?>
            
			<h1><?php echo $heading_title; ?></h1>
            <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
            <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
            
            <div class="grid_3" style="float: right !important;">
                <a onclick="window.print();" class="button">Imprimir</a>
                <?php //TODO: <a onclick="window.print();" class="button">PDF</a> ?>
            </div>
    
            <div class="clear"></div><br />
            
            <div class="grid_9">
                <h3><?php echo $text_payment_address; ?></h3>
                <p><?php echo $payment_address; ?></p>
                
                <div class="clear"></div><br />
                
                <h3><?php echo $text_payment_method; ?></h3>
                <p><?php echo $payment_method; ?></p>
                
                <div class="clear"></div><br />
                
                <?php if ($shipping_address) { ?>
                <h3><?php echo $text_shipping_address; ?></h3>
                <p><?php echo $shipping_address; ?></p>
                <div class="clear"></div><br />
                <?php } ?>
      
                <?php if ($shipping_method) { ?>
                <h3><?php echo $text_shipping_method; ?></h3>
                <p><?php echo $shipping_method; ?></p>
                <div class="clear"></div><br />
                <?php } ?>
            </div>
            
            <div class="grid_3" style="float: right !important;">
                <?php if ($invoice_id) { ?><p><b><?php echo $text_invoice_id; ?></b>: <?php echo $invoice_id; ?></p><?php } ?>
                <p><b><?php echo $text_order_id; ?></b>: #<?php echo $order_id; ?></p>
                <p><b><?php echo $column_date_added; ?></b>: <?php echo $historys[(count($historys)-1)]['date_added']; ?></p>
                <p><b><?php echo $column_status; ?></b>:<?php echo $historys[(count($historys)-1)]['status']; ?></p>
            </div>
            
            <div class="clear"></div><br />
            
            <div class="grid_13">
                <h3>Detalle de la Facturaci&oacute;n</h3>
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
                        <td style="text-align:left">&nbsp;<a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><?php echo $product['name']; ?></a>
                        <?php foreach ($product['option'] as $option) { ?>
                        <br>
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
            
            <div class="grid_3" style="float: right !important;">
                <table id="orderTotals">
                    <?php foreach ($totals as $total) { ?>
                    <tr>
                        <td><b><?php echo $total['title']; ?></b></td>
                        <td><?php echo $total['text']; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            
            <div class="clear"></div>
            
            <?php if ($comment) { ?>
            <div class="grid_13">
                <h3><?php echo $text_comment; ?></h3>
                <p><?php echo $comment; ?></p>
            </div>
            <?php } ?>
            
            <div class="clear"></div>
            
            <?php if ($historys) { ?>
            <div class="grid_13">
                <div class="clear"></div><br />
                <h3><?php echo $text_order_history; ?></h3>
                <?php foreach ($historys as $history) { ?>
                <div class="grid_2">
                    <?php echo $history['status']; ?><br />
                    <?php echo $history['date_added']; ?>
                </div>
                <div class="grid_9">
                    <?php echo $history['comment']; ?>
                </div>
                <div class="clear"></div><hr />
                <?php } ?>
            </div>
            <?php } ?>
            
        </div>
        
        <?php if ($column_right) { ?><aside id="column_right" class="grid_3"><?php echo $column_right; ?></aside><?php } ?>

            <div class="clear"></div>

            <div class="grid_12">
                <div id="featuredFooter">
                <ul class="widgets" data-position="featuredFooter"><?php if($featuredFooterWidgets) { foreach ($featuredFooterWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
                </div>
            </div>

        </section>
    </section>
</div>
<?php echo $footer; ?>