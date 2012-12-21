<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/customer.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?><a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_name; ?>" name="name" value="<?php echo $name; ?>">
            <?php if ($error_name) { ?>
            <span class="error"><?php echo $error_name; ?></span>
            <?php  } ?></td>
        </tr>
        <tr>
          <td>Cant. de Pedidos Mensuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="cant_orders" value="<?php echo $cant_orders; ?>"></td>
        </tr>
        </tr>
        <tr>
          <td>Cant. de Compras Mensuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="cant_invoices" value="<?php echo $cant_invoices; ?>"></td>
        </tr>
        </tr>
        <tr>
          <td>Cant. de Comentarios Mensuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="cant_reviews" value="<?php echo $cant_reviews; ?>"></td>
        </tr>
        </tr>
        <tr>
          <td>Cant. de Referencias Mensuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="cant_references" value="<?php echo $cant_references; ?>"></td>
        </tr>
        <tr>
          <td>Cant. de Pedidos Anuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="total_orders" value="<?php echo $total_orders; ?>"></td>
        </tr>
        </tr>
        <tr>
          <td>Cant. de Compras Anuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="total_invoices" value="<?php echo $total_invoices; ?>"></td>
        </tr>
        </tr>
        <tr>
          <td>Cant. de Comentarios Anuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="total_reviews" value="<?php echo $total_reviews; ?>"></td>
        </tr>
        </tr>
        <tr>
          <td>Cant. de Referencias Anuales<a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input type="number" title="<?php echo $help_name; ?>" name="total_references" value="<?php echo $total_references; ?>"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>