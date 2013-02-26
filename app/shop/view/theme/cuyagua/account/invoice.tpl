<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <?php if ($invoice_id) { ?>
      <div style="float:right;position:absolute;left:770px;">
        <b><?php echo $text_invoice_id; ?></b>: <?php echo $invoice_id; ?></div>
      <?php } ?>
      <div style="float:right;position:absolute;left:770px;top:220px;">
        <b><?php echo $text_order_id; ?></b>: #<?php echo $order_id; ?>
      </div>
      <?php foreach ($historys as $history) { ?>
        <div style="float:right;position:absolute;left:770px;top:240px;">
          <b><?php echo $column_date_added; ?></b>: <?php echo $history['date_added']; ?>
        </div>
        <div style="float:right;position:absolute;left:770px;top:260px;">
          <b><?php echo $column_status; ?></b>:<?php echo $history['status']; ?>
        </div>
      <?php } ?>
      <br>
      <h3><?php echo $text_payment_address; ?></h3>
        <?php echo $payment_address; ?><br>
      <h3><?php echo $text_payment_method; ?></h3>
        <?php echo $payment_method; ?><br>
      <?php if ($shipping_address) { ?>
        <h3><?php echo $text_shipping_address; ?></h3>
         <?php echo $shipping_address; ?><br>
      <?php } ?>
      <?php if ($shipping_method) { ?>
        <h3><?php echo $text_shipping_method; ?></h3>
         <?php echo $shipping_method; ?><br>
      <?php } ?>
      <h3>Detalle de la Facturaci&oacute;n</h3>
      <table>
        <tr class="order_table_header">
          <th><?php echo $text_product; ?></th>
          <th><?php echo $text_model; ?></th>
          <th><?php echo $text_quantity; ?></th>
          <th><?php echo $text_price; ?></th>
          <th><?php echo $text_total; ?></th>
        </tr>
        <?php 
        $i = 0; 
        foreach ($products as $product) { 
          if ($i%2 == 0) { $classorder = 'detalle_factura_01';} else { $classorder = 'detalle_factura_02'; }
          $i++; ?>
        <tr class="<?php echo $classorder; ?>">
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
      

      <br>
      <div style="float: right">
        <table>
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="tdTopRight"><b style="font-size:14px"><?php echo $total['title']; ?></b></td>
            <td class="tdTopRight"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
      </div><br><br><br><br>
    <?php if ($comment) { ?>
    <h3><?php echo $text_comment; ?></h3>
    <div class="content"><?php echo $comment; ?></div>
    <?php } ?>
    <?php if ($historys) { ?>
    <h3><?php echo $text_order_history; ?></h3>
    <div class="content">
     <b><?php echo $column_comment; ?>:</b><br>
        <?php foreach ($historys as $history) { ?>
        <?php echo $history['comment']; ?>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="buttons">
      <table>
        <tr>
          <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $continue); ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php echo $footer; ?> 