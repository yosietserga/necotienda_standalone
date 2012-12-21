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
        <?php foreach ($languages as $language) { ?>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_bank; ?><a title="Ingrese las instrucciones del pago. Por ejemplo, indique en que bancos, los clientes pueden realizar la transferecnia con el debido n&uacute;mero de cuenta respectivo y a nombre de quien van a realizar el pago"> (?)</a></td>
          <td><textarea name="bank_transfer_bank_<?php echo $language['language_id']; ?>" cols="80" rows="10"><?php echo isset(${'bank_transfer_bank_' . $language['language_id']}) ? ${'bank_transfer_bank_' . $language['language_id']} : ''; ?></textarea>
            <imgsrc="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;"><br>
            <?php if (isset(${'error_bank_' . $language['language_id']})) { ?>
            <span class="error"><?php echo ${'error_bank_' . $language['language_id']}; ?></span>
            <?php } ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $entry_order_status; ?><a title="Seleccione el estado en el que resultar&aacute; el pedido luego de haberse realizado con esta forma de pago"> (?)</a></td>
          <td><select name="bank_transfer_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $bank_transfer_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?><a title="Seleccione la Geo Zona en la que desea est&eacute; disponible esta forma de pago"> (?)</a></td>
          <td><select name="bank_transfer_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $bank_transfer_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="Seleccione el estado del m&oacute;dulo"> (?)</a></td>
          <td><select name="bank_transfer_status">
              <?php if ($bank_transfer_status) { ?>
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
          <td><input  type="text" name="bank_transfer_sort_order" value="<?php echo $bank_transfer_sort_order; ?>" size="1"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>