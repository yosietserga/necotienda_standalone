<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_balance_id; ?>')"<?php if ($sort == 'b.balance_id') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_balance_id'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_customer; ?>')"<?php if ($sort == 'customer') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_customer'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_type; ?>')"<?php if ($sort == 'b.`type`') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_type'); ?></a></th>
                <th><?php echo $Language->get('column_description'); ?></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_amount; ?>')"<?php if ($sort == 'b.amount') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_amount'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_amount_blocked; ?>')"<?php if ($sort == 'b.amount_blocked') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_amount_blocked'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_amount_available; ?>')"<?php if ($sort == 'b.amount_available') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_amount_available'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_amount_total; ?>')"<?php if ($sort == 'b.amount_total') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_amount_total'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'op.date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_date_added'); ?></a></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($balances) { ?>
            <?php foreach ($balances as $balance) { ?>
            <tr id="tr_<?php echo $balance['balance_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $balance['balance_id']; ?>" <?php if ($balance['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $balance['balance_id']; ?></td>
                <td><a href="<?php echo $Url::createAdminUrl("sale/customer",array('customer_id'=>$balance['customer_id'])); ?>"><?php echo $balance['customer']['firstname'] .' '. $balance['customer']['lastname']; ?></a></td>
                <td><?php echo $Language->get('text_'.$balance['type']); ?></td>
                <td><?php echo $balance['description']; ?></td>
                <td><?php echo $balance['amount']; ?></td>
                <td><?php echo $balance['amount_blocked']; ?></td>
                <td><b><?php echo $balance['amount_available']; ?></b></td>
                <td><?php echo $balance['amount_total']; ?></td>
                <td><?php echo $balance['date_added']; ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="5" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>