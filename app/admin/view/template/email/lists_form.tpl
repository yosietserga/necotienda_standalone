<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } 
echo $mostrarError;
?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
        <table class="form">
        <?php if (!empty($list_id)) { ?>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_list_id; ?><a title="Ingrese el nombre del cup&oacute;n. Le recomendamos 	que utilice nombres descriptivos y que hagan referencia a alguna promoci&oacute;n"> (?)</a></td>
            <td><?php echo $list_id; ?></td>
          </tr>
        <?php } ?>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?><a title="Ingrese el nombre del cup&oacute;n. Le recomendamos 	que utilice nombres descriptivos y que hagan referencia a alguna promoci&oacute;n"> (?)</a></td>
            <td><input type="text" name="name" value="<?php echo $name; ?>">
              <?php if (isset($error_name)) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
          <td><span class="required">*</span> <?php echo $entry_format; ?></td>
          <td><select name="format">
              <?php if ($format) { ?>
              <option value="h" selected="selected"><?php echo $text_html; ?></option>
              <option value="t"><?php echo $text_text; ?></option>
              <?php } else { ?>
              <option value="h"><?php echo $text_html; ?></option>
              <option value="t" selected="selected"><?php echo $text_text; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_notify; ?><a title="Ingrese el c&oacute;digo de verificaci&oacute;n del cup&oacute;n. Esto ser&aacute; utilizado para comprobar la legitimidad del mismo al momento de que el cliente lo utilice, le recomendamos que utilice c&oacute;digos complejos, si es necesario utilice generadores de claves"> (?)</a></td>
          <td><?php if ($notify == 1) { ?>
            <input type="radio" name="notify" value="1" checked="checked">
            <?php echo $entry_true; ?>
            <input type="radio" name="notify" value="0">
            <?php echo $entry_false; ?>
            <?php } else { ?>
            <input type="radio" name="notify" value="1">
            <?php echo $entry_true; ?>
            <input type="radio" name="notify" value="0" checked="checked">
            <?php echo $entry_false; ?>
            <?php } ?>
            <?php if (isset($error_notify)) { ?>
            <span class="error"><?php echo $error_notify; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_member; ?><a title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores"> (?)</a></td>
            <td>Seleeccionar Todos&nbsp;<input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'customer_id\']').attr('checked', this.checked);">
            <div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($customers as $customer) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($customer['customer_id'], $customer_id)) { ?>
                  <input title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores" type="checkbox" name="customer_id[]" value="<?php echo $customer['customer_id']; ?>" checked="checked">
                  <input type="hidden" name="email[]" value="<?php echo $customer['email']; ?>">
                  <?php echo $customer['firstname'].' '.$customer['lastname'].'&nbsp;&nbsp;[ '.$customer['email'].' ]'; ?>
                  <?php  } else {  ?>
                  <input title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores" type="checkbox" name="customer_id[]" value="<?php echo $customer['customer_id']; ?>">
                  <input type="hidden" name="email[]" value="<?php echo $customer['email']; ?>">
                  <?php echo $customer['firstname'].' '.$customer['lastname'].'&nbsp;&nbsp;[ '.$customer['email'].' ]'; ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div></td>
          </tr>
        <tr>
            <td><?php echo $entry_category; ?><a title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores"> (?)</a></td>
            <td>Seleeccionar Todos&nbsp;<input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'product_category\']').attr('checked', this.checked);">
            <div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($category['category_id'], $product_category)) { ?>
                  <input title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked">
                  <?php echo $category['name']; ?>
                  <?php } else { ?>
                  <input title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>">
                  <?php echo $category['name']; ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div></td>
          </tr>
     </table>
    </div>
</div>    
</form>
<?php echo $footer; ?>