<div>
    <a onclick="addOption();" class="button"><?php echo $button_add_option; ?></a>
                    
    <select id="option" size="20">
    <?php $option_row = 0; ?>
    <?php $option_value_row = 0; ?>
    <?php foreach ($product_options as $product_option) { ?>
        <option value="option<?php echo $option_row; ?>"><?php echo $product_option['language'][$language_id]['name']; ?></option>
        <?php if ($product_option['product_option_value']) { ?>
            <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
                <?php foreach ($languages as $language) { ?>
                    <?php if ($language['language_id'] == $language_id) { ?>
        <option value="option<?php echo $option_row; ?>_<?php echo $option_value_row; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $product_option_value['language'][$language['language_id']]['name']; ?></option>
                            <?php $option_value_row++; ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php $option_row++; ?>
    <?php } ?>
    </select>
                    
    <?php $option_row = 0; ?>
    <?php $option_value_row = 0; ?>
    <?php foreach ($product_options as $product_option) { ?>
    <div id="option<?php echo $option_row; ?>" class="option">
        <table class="form">
            <tr>
                <td><?php echo $entry_option; ?><a title="<?php echo $help_option; ?>"> (?)</a></td>
                <td>
                <?php foreach ($languages as $language) { ?>
                    <?php if ($language['language_id'] == $language_id) { ?>
                    <input title="<?php echo $help_option; ?>" name="product_option[<?php echo $option_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option['language'][$language['language_id']]['name']; ?>" onkeyup="$('#option option[value=\'option<?php echo $option_row; ?>\']').text(this.value);" />
                    <?php } else { ?>
                    <input title="<?php echo $help_option; ?>" name="product_option[<?php echo $option_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option['language'][$language['language_id']]['name']; ?>">
                    <?php } ?>
                    <img src="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"><br>
     			<?php } ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_sort_order; ?></td>
                <td><input title="<?php echo $help_sort_order; ?>" type="number" name="product_option[<?php echo $option_row; ?>][sort_order]" value="<?php echo $product_option['sort_order']; ?>" size="2"></td>
            </tr>
            <tr>
                <td colspan="2"><a onclick="addOptionValue('<?php echo $option_row; ?>');" class="button"><span><?php echo $button_add_option_value; ?></span></a> <a onclick="removeOption('<?php echo $option_row; ?>');" class="button"><span><?php echo $button_remove; ?></span></a></td>
            </tr>
        </table>
    </div>
    
    <?php if ($product_option['product_option_value']) { ?>
        <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
    <div id="option<?php echo $option_row; ?>_<?php echo $option_value_row; ?>" class="option">
        <table class="form">
            <tr>
                <td><?php echo $entry_option_value; ?><a title="<?php echo $help_option_value; ?>"> (?)</a></td>
                <td>
                <?php foreach ($languages as $language) { ?>
                    <?php if ($language['language_id'] == $language_id) { ?>
                    <input title="<?php echo $help_option_value; ?>" type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option_value['language'][$language['language_id']]['name']; ?>" onkeyup="$('#option option[value=\'option<?php echo $option_row; ?>_<?php echo $option_value_row; ?>\']').text('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + this.value);">
                    <?php } else { ?>
                    <input title="<?php echo $help_option_value; ?>" type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option_value['language'][$language['language_id']]['name']; ?>">
                    <?php } ?>
                    <img src="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"><br>
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_quantity; ?><a title="<?php echo $help_quantity; ?>"> (?)</a></td>
                <td><input title="<?php echo $help_quantity; ?>" type="number" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" size="2"></td>
            </tr>
            <tr>
                <td><?php echo $entry_subtract; ?><a title="<?php echo $help_subtract; ?>"> (?)</a></td>
                <td>
                    <select title="<?php echo $help_subtract; ?>" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]">
                    <?php if ($product_option_value['subtract']) { ?>
                        <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                        <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                        <option value="1"><?php echo $text_yes; ?></option>
                        <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_price; ?><a title="<?php echo $help_price; ?>"> (?)</a></td>
                <td><input title="<?php echo $help_price; ?>" type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>"></td>
            </tr>
            <tr>
                <td><?php echo $entry_prefix; ?><a title="<?php echo $help_prefix; ?>"> (?)</a></td>
                <td>
                    <select title="<?php echo $help_prefix; ?>" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][prefix]">
                    <?php  if ($product_option_value['prefix'] != '-') { ?>
                        <option value="+" selected="selected"><?php echo $text_plus; ?></option>
                        <option value="-"><?php echo $text_minus; ?></option>
                    <?php } else { ?>
                        <option value="+"><?php echo $text_plus; ?></option>
                        <option value="-" selected="selected"><?php echo $text_minus; ?></option>
                    <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_sort_order; ?><a title="<?php echo $help_sort_order; ?>"> (?)</a></td>
                <td><input title="<?php echo $help_sort_order; ?>" type="number" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][sort_order]" value="<?php echo $product_option_value['sort_order']; ?>" size="2"></td>
            </tr>
            <tr>
                <td colspan="2"><a onclick="removeOptionValue('<?php echo $option_row; ?>_<?php echo $option_value_row; ?>');" class="button"><span><?php echo $button_remove; ?></span></a></td>
            </tr>
        </table>
    </div>
        <?php $option_value_row++; ?>
        <?php } ?>
    <?php } ?>
    <?php $option_row++; ?>
<?php } ?>
</div>

<script type="text/javascript">
$('#option').bind('change', function() {
	$('.option').hide();
	
	$('#' + $('#option option:selected').attr('value')).show();
});

$('#option option:first').attr('selected', 'selected');

$('#option').trigger('change');
						 
var option_row = <?php echo $option_row; ?>;

function addOption() {	
	html  = '<div id="option' + option_row + '" class="option">';
	html += '<table class="form">';
	html += '<tr>';
	html += '<td><?php echo $entry_option; ?></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	<?php if ($language["language_id"] == $language_id) { ?>
	html += '<input   type="text" name="product_option[' + option_row + '][language][<?php echo $language["language_id"]; ?>][name]" value="Option ' + option_row + '" onkeyup="$(\'#option option[value=\\\'option' + option_row + '\\\']\').text(this.value);">&nbsp;<imgsrc="image/flags/<?php echo $language["image"]; ?>" title="<?php echo $language["name"]; ?>"><br>';
	<?php } else { ?>
	html += '<input  type="text" name="product_option[' + option_row + '][language][<?php echo $language["language_id"]; ?>][name]" value="Option ' + option_row + '">&nbsp;<imgsrc="image/flags/<?php echo $language["image"]; ?>" title="<?php echo $language["name"]; ?>"><br>';
	<?php } ?>
	<?php } ?>
	html += '</td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_sort_order; ?></td>';
	html += '<td><input  type="text" name="product_option[' + option_row + '][sort_order]" value="" size="2"></td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td colspan="2"><a  onclick="addOptionValue(\'' + option_row + '\');" class="button"><span><?php echo $button_add_option_value; ?></span></a> <a  onclick="removeOption(\'' + option_row + '\');" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</table>';
	html += '</div>';
		 
	$('#options').append(html);
	
	$('#option').append('<option value="option' + option_row + '"><?php echo $text_option; ?> ' + option_row + '</option>');
	$('#option option[value=\'option' + option_row + '\']').attr('selected', 'selected');
	$('#option').trigger('change');

	option_row++;
}

function removeOption(option_row) {
	$('#option option[value=\'option' + option_row + '\']').remove();
	$('#option option[value^=\'option' + option_row + '_\']').remove();
	
	$('#options div[id=\'option' + option_row + '\']').remove();
	$('#options div[id^=\'option' + option_row + '_\']').remove();
}

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_id) {
	html  = '<div id="option' + option_id + '_' + option_value_row + '" class="option">';
	html += '<table class="form">';
	html += '<tr>';
	html += '<td><?php echo $entry_option_value; ?></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	<?php if ($language['language_id'] == $language_id) { ?>
	html += '<input  type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][language][<?php echo $language["language_id"]; ?>][name]" value="Option Value ' + option_value_row + '" onkeyup="$(\'#option option[value=\\\'option' + option_id + '_' + option_value_row + '\\\']\').text(\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\' + this.value);">&nbsp;<imgsrc="image/flags/<?php echo $language["image"]; ?>" title="<?php echo $language["name"]; ?>"><br>';
	<?php } else { ?>
	html += '<input  type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][language][<?php echo $language["language_id"]; ?>][name]" value="Option Value ' + option_value_row + '">&nbsp;<imgsrc="image/flags/<?php echo $language["image"]; ?>" title="<?php echo $language["name"]; ?>"><br>';
	<?php } ?>	
	<?php } ?>
	html += '</td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_quantity; ?></td>';
	html += '<td><input  type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][quantity]" value="' + '" size="2"></td>';	
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_subtract; ?></td>';
	html += '<td><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][subtract]">';
    html += '<option value="1"><?php echo $text_yes; ?></option>';
    html += '<option value="0"><?php echo $text_no; ?></option>';
    html += '</select></td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td><?php echo $entry_price; ?></td>';
	html += '<td><input  type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][price]" value=""></td>';
	html += '</tr>';
	html += '<tr>';	
	html += '<td><?php echo $entry_prefix; ?></td>';
	html += '<td><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][prefix]">';
	html += '<option value="+"><?php echo $text_plus; ?></option>';
	html += '<option value="-"><?php echo $text_minus; ?></option>';
	html += '</select></td>';
	html += '</tr>';
	html += '<tr>';	
	html += '<td><?php echo $entry_sort_order; ?></td>';	
	html += '<td><input  type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][sort_order]" value="" size="2"></td>';
	html += '</tr>';
	html += '<tr>';		
	html += '<td colspan="2"><a  onclick="removeOptionValue(\'' + option_id + '_' + option_value_row + '\');" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</table>';
	html += '</div>';
	
	$('#options').append(html);
	
	option = $('#option option[value^=\'option' + option_id + '_\']:last');
	
	if (option.size()) {
		option.after('<option value="option' + option_id + '_' + option_value_row + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $text_option_value; ?> ' + option_value_row + '</option>');
	} else {
		$('#option option[value=\'option' + option_id + '\']').after('<option value="option' + option_id + '_' + option_value_row + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $text_option_value; ?> ' + option_value_row + '</option>');
	}
	
	$('#option option[value=\'option' + option_id + '_' + option_value_row + '\']').attr('selected', 'selected');
	
	$('#option').trigger('change');
	
	option_value_row++;
}

function removeOptionValue(option_value_row) {
	$('#option option[value=\'option' + option_value_row + '\']').remove();
	
	$('#option' + option_value_row).remove();
}
</script>