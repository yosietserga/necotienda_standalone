<div class="heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div  onclick="$('#debitGuide').slideToggle();" class="heading-title">
        <h3>
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="simple-form guide" id="debitGuide" style="display: none;" data-guide="payment">

    <p><?php echo $Language->get('text_amount_available'); ?>&nbsp;<b id="amount_available"><?php echo $balance['available']; ?></b></p>

    <form id="debitForm" name="debitForm" method="post" data-form="payment" action="<?php echo $Url::createUrl("payment/debit/confirm"); ?>" data-async>
    
        <div class="form-entry">
            <label for="amount"><?php echo $Language->get('entry_debit_amount'); ?></label>
            <input type="text" name="amount" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry">
            <label for="order_id"><?php echo $Language->get('entry_debit_order_id'); ?></label>
            <select name="order_id">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-entry">
            <label for="comment"><?php echo $Language->get('entry_debit_order_id'); ?></label>
            <textarea name="comment" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
        <input type="hidden" name="payment_method" value="debit" />
        <div class="necoform-actions" data-actions="necoform"></div>
    </form>
</div>
