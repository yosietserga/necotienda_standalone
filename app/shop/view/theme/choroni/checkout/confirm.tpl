<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
  <div class="middle">
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <h3><?php echo $text_payment_address; ?></h3>
            <?php echo $payment_address; ?><br>
            <div><a title="<?php echo $text_change; ?>" href="<?php echo str_replace('&', '&amp;', $checkout_payment_address); ?>"><?php echo $text_change; ?></a>
    </div>
    <div>
            <h3><?php echo $text_payment_method; ?></h3>
            <?php echo $payment_method; ?><br>
            <a title="<?php echo $text_change; ?>" href="<?php echo str_replace('&', '&amp;', $checkout_payment); ?>"><?php echo $text_change; ?></a>
            </div>
    
            <?php if ($shipping_address) { ?>
            
            <h3><?php echo $text_shipping_address; ?></h3>
            <?php echo $shipping_address; ?><br>
            <a title="<?php echo $text_change; ?>" href="<?php echo str_replace('&', '&amp;', $checkout_shipping_address); ?>"><?php echo $text_change; ?></a>
            
            <?php } ?>
            
            
    <?php if ($shipping_method) { ?>
    <div>
    <h3><?php echo $text_shipping_method; ?></h3>
            <?php echo $shipping_method; ?><br>
            <a title="<?php echo $text_change; ?>" href="<?php echo str_replace('&', '&amp;', $checkout_shipping); ?>"><?php echo $text_change; ?></a></div>
            <?php } ?>
    <h3>Detalle de la Facturaci&oacute;n</h3>
   
    
      <table>
        <tr class="order_table_header">
          <th><?php echo $column_product; ?></th>
          <th><?php echo $column_model; ?></th>
          <th><?php echo $column_quantity; ?></th>
          <th><?php echo $column_price; ?></th>
          <th><?php echo $column_total; ?></th>
        </tr>
        <?php 
        $i = 0; 
        foreach ($products as $product) { 
          if ($i%2 == 0) { $classorder = 'detalle_factura_01';} else { $classorder = 'detalle_factura_02'; }
          $i++; ?>
        <tr class="<?php echo $classorder; ?>">
          <td style="text-align:left"><a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><?php echo $product['name']; ?></a>
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
      
      <div style="float:right">
        <table>
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="tdTopRight"><?php echo $total['title']; ?></td>
            <td class="tdTopRight"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
</div><br><br><br><br>

    <?php if ($comment) { ?>
    <b style="margin-bottom: 2px; display: block;"><?php echo $text_comment; ?></b>
    <div class="content"><?php echo $comment; ?></div>
    <?php } ?>
    <div id="payment"><?php echo $payment; ?></div>
  </div>
</div>
<?php echo $footer; ?> 