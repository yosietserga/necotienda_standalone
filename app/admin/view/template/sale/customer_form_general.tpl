<h2>General</h2>
<table class="form">
	<tr>
		<td><label><?php echo $entry_rif; ?></label></td>
		<td><input title="<?php echo $help_rif; ?>" type="text" name="rif" id="rif" value="<?php echo $rif; ?>" /></td>
	</tr>
	<tr>
		<td><label><?php echo $entry_company; ?></label></td>
		<td><input title="<?php echo $help_company; ?>" type="text" name="company" id="company" value="<?php echo $company; ?>" /></td>
	</tr>
	<tr>
		<td><label><?php echo $entry_firstname; ?></label></td>
		<td><input title="<?php echo $help_firstname; ?>" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" /></td>
	</tr>
	<tr>
		<td><label><?php echo $entry_lastname; ?></label></td>
		<td><input title="<?php echo $help_lastname; ?>" name="lastname" value="<?php echo $lastname; ?>" /></td>
	</tr>
	<tr>
		<td><label><?php echo $entry_email; ?></label></td>
		<td><input title="<?php echo $help_email; ?>" type="email" name="email" value="<?php echo $email; ?>" /></td>
	</tr>
	<tr>
		<td><label><?php echo $entry_sexo; ?></label></td>
		<td>
            <select name="sexo" title="<?php echo $help_sexo; ?>">
                <option value=""><?php echo $text_sexo; ?></option>
				<option value="m"<?php if ($sexo=='m') { ?> selected="selected"<?php } ?>><?php echo $text_man; ?></option>
				<option value="f"<?php if ($sexo=='f') { ?> selected="selected"<?php } ?>><?php echo $text_woman; ?></option>		
			</select>
        </td>
	</tr>
	<tr>
		<td><label><?php echo $entry_telephone; ?></label></td>
		<td><input title="<?php echo $help_telephone; ?>" name="telephone" value="<?php echo $telephone; ?>" /></td>
	</tr>
	<tr>
		<td><label><?php echo $entry_customer_group; ?></label></td>
		<td>
			<select name="customer_group_id">
			<?php foreach ($customer_groups as $customer_group) { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group[ 'customer_group_id']==$customer_group_id) { ?> selected="selected"<?php } ?>><?php echo $customer_group[ 'name']; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
</table>