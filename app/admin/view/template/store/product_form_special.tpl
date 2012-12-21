<div>
    <table id="special" class="list">
        <thead>
            <tr>
                <th><?php echo $entry_customer_group; ?></th>
                <th><?php echo $entry_priority; ?></th>
                <th><?php echo $entry_price; ?></th>
                <th><?php echo $entry_date_start; ?></th>
                <th><?php echo $entry_date_end; ?></th>
                <th></th>
            </tr>
        </thead>
        <?php $special_row = 0; ?>
        <tbody id="special_row<?php echo $special_row; ?>">
        <?php foreach ($product_specials as $product_special) { ?>
            <tr>
                <td>
                    <select name="product_special[<?php echo $special_row; ?>][customer_group_id]">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </td>
                <td><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" size="2"></td>
                <td><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>"></td>
                <td><input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" class="date"></td>
                <td><input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" class="date"></td>
                <td><a onclick="$('#special_row<?php echo $special_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
            <?php $special_row++; ?>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td><a onclick="addSpecial();" class="button"><?php echo $button_add_special; ?></a></td>
            </tr>
        </tfoot>
    </table>
</div>
<script type="text/javascript">
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tbody id="special_row' + special_row + '">';
	html += '<tr>'; 
    html += '<td class="left"><select name="product_special[' + special_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';		
    html += '<td class="left"><input  type="text" name="product_special[' + special_row + '][priority]" value="" size="2"></td>';
	html += '<td class="left"><input  type="text" name="product_special[' + special_row + '][price]" value=""></td>';
    html += '<td class="left"><input  type="text" name="product_special[' + special_row + '][date_start]" value="" class="date"></td>';
	html += '<td class="left"><input  type="text" name="product_special[' + special_row + '][date_end]" value="" class="date"></td>';
	html += '<td class="left"><a  onclick="$(\'#special_row' + special_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
    html += '</tbody>';
	
	$('#special tfoot').before(html);
 
	$('#special_row' + special_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	special_row++;
}
</script>             