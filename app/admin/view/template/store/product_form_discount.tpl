<div>
    <table id="discount" class="list">
        <thead>
            <tr>
                <th><?php echo $entry_customer_group; ?></th>
                <th><?php echo $entry_quantity; ?></th>
                <th><?php echo $entry_priority; ?></th>
                <th><?php echo $entry_price; ?></th>
                <th><?php echo $entry_date_start; ?></th>
                <th><?php echo $entry_date_end; ?></th>
                <th></th>
            </tr>
        </thead>
        <?php $discount_row = 0; ?>
        <tbody id="discount_row<?php echo $discount_row; ?>">
        <?php foreach ($product_discounts as $product_discount) { ?>
            <tr>
                <td>
                    <select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </td>
                <td><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" size="2"></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" size="2"></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>"></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" class="date"></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" class="date"></td>
                <td><a onclick="$('#discount_row<?php echo $discount_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
            <?php $discount_row++; ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6"></td>
                <td><a onclick="addDiscount();" class="button"><?php echo $button_add_discount; ?></a></td>
            </tr>
        </tfoot>
    </table>
                
</div>
<script type="text/javascript">
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
	html  = '<tbody id="discount_row' + discount_row + '">';
	html += '<tr>'; 
    html += '<td class="left"><select name="product_discount[' + discount_row + '][customer_group_id]" style="margin-top: 3px;">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';
    html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" size="2" style="width:40px"></td>';
    html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" size="2" style="width:40px"></td>';
	html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][price]" value=""></td>';
    html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" class="date"></td>';
	html += '<td class="left"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" class="date"></td>';
	html += '<td class="left"><a onclick="$(\'#discount_row' + discount_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';	
    html += '</tbody>';
	
	$('#discount tfoot').before(html);
		
	$('#discount_row' + discount_row + ' .date').datepicker({dateFormat: 'dd-mm-yy'});
	
	discount_row++;
}
</script>