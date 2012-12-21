<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/payment.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_payable; ?><a title="Ingrese a nombre de quien se van hacer los cheques seguido de los datos bancarios para que sean depositados"> (?)</a></td>
          <td><textarea  cols="80" rows="10" name="cheque_payable" value="<?php echo $cheque_payable; ?>"></textarea>
            <?php if ($error_payable) { ?>
            <span class="error"><?php echo $error_payable; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_order_status; ?><a title="Seleccione el estado en el que resultar&aacute; el pedido luego de haberse realizado con esta forma de pago"> (?)</a></td>
          <td><select name="cheque_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $cheque_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?><a title="Seleccione la Geo Zona en la que desea est&eacute; disponible esta forma de pago"> (?)</a></td>
          <td><select name="cheque_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $cheque_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="Seleccione el estado del m&oacute;dulo"> (?)</a></td>
          <td><select name="cheque_status">
              <?php if ($cheque_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?><a title="Ingrese la posici&oacute;n en la que desea, se muestre el m&oacute;dulo. Por ejemplo, si quiere que se muestre de segundo, coloque el n&uacute;mero 2"> (?)</a></td>
          <td><input  type="text" name="cheque_sort_order" value="<?php echo $cheque_sort_order; ?>" size="1"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>