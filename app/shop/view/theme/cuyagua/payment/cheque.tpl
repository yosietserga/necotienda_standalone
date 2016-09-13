<div class="heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div class="heading-title" onclick="$('#chequeGuide').slideToggle();">
        <h3> 
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="simple-form guide break" id="chequeGuide" style="display: none;" data-guide="payment">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
    <form id="chequeForm" name="chequeForm" method="post" action="<?php echo $Url::createUrl("payment/cheque/confirm"); ?>" data-form="payment" data-async>
        <div class="form-entry">
            <label for="cheque_order_id"><?php echo $Language->get('entry_cheque_order_id'); ?></label>
            <select name="cheque_order_id" title="<?php echo $Language->get('help_cheque_order_id'); ?>" showquick="off">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-entry">
            <label for="cheque_bank_account_id"><?php echo $Language->get('entry_cheque_bank_account'); ?></label>
            <select name="cheque_bank_account_id" id="cheque_bank_account_id" title="<?php echo $Language->get('help_cheque_bank_account'); ?>" showquick="off">
                <option value="">Seleccione la Cuenta donde deposit&oacute;</option>
                <?php foreach ($bank_accounts as $bank_account) { ?>
                <option value="<?php echo $bank_account['bank_account_id']; ?>"><?php echo $bank_account['number']." - ". $bank_account['accountholder']; ?></option>
                <?php } ?>
            </select>
        </div>
            
        <div class="form-entry">
            <label for="cheque_transact"><?php echo $Language->get('entry_cheque_transact'); ?></label>
            <input type="text" name="cheque_transact" title="<?php echo $Language->get('help_cheque_transact'); ?>" value="" placeholder="Ingrese el n&uacute;mero de dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry">
            <label for="cheque_date_added"><?php echo $Language->get('entry_cheque_date_added'); ?></label>
            <input type="date" name="cheque_date_added" title="<?php echo $Language->get('help_cheque_date_added'); ?>" value="" placeholder="Ingrese la fecha del dep&oacute;sito" required="required" />
        </div>
            
        <div class="form-entry">
            <label for="cheque_amount"><?php echo $Language->get('entry_cheque_amount'); ?></label>
            <input type="text" name="cheque_amount" title="<?php echo $Language->get('help_cheque_amount'); ?>" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry">
            <label for="cheque_comment"><?php echo $Language->get('entry_cheque_comment'); ?></label>
            <textarea name="cheque_comment" title="<?php echo $Language->get('help_cheque_comment'); ?>" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
        <div class="necoform-actions" data-actions="necoform"></div>
    </form>
</div>

