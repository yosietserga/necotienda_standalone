<div class="heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div onclick="$('#codGuide').slideToggle();" class="heading-title">
        <h3> 
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="simple-form guide break" id="codGuide" style="display: none;" data-guide="payment">
    <?php if (!empty($instructions)) { echo $instructions; } ?>

    <form action="<?php echo $Url::createUrl("payment/cod/confirm"); ?>" method="post" action="<?php echo $Url::createUrl("payment/cod/confirm"); ?>" id="codForm" data-form="payment" data-async>
        <div class="form-entry">
            <label for="cod_order_id"><?php echo $Language->get('entry_cod_order_id'); ?></label>
            <select name="cod_order_id" title="<?php echo $Language->get('help_cod_order_id'); ?>" showquick="off">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-entry property">
            <label for="cod_date_of_payment"><?php echo $Language->get('entry_cod_date_of_payment'); ?>:</label>
            <input type="date" id="cod_date_of_payment" name="cod_date_of_payment" title="<?php echo $Language->get('help_cod_date_of_payment'); ?>" required="required" placeholder="dd/mm/yyyy" />
        </div>

        <div class="form-entry property">
            <label for="cod_amount"><?php echo $Language->get('entry_cod_amount'); ?>:</label>
            <input type="text" name="cod_amount" id="cod_amount" title="<?php echo $Language->get('help_cod_amount'); ?>" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry property">
            <label for="cod_payment_method_on_delivery"><?php echo $Language->get('entry_cod_payment_method_on_delivery'); ?>:</label>
            <select name="cod_payment_method_on_delivery" id="cod_payment_method_on_delivery" title="<?php echo $Language->get('help_cod_payment_method_on_delivery'); ?>" showquick="off">
                <option value="tc" <?php if (strtolower($payment_method_on_delivery) == 'tc') echo 'selected="selected"'; ?>>Tarjeta de Crédito</option>
                <option value="td" <?php if (strtolower($payment_method_on_delivery) == 'td') echo 'selected="selected"'; ?>>Tarjeta de Débito</option>
                <option value="efectivo" <?php if (strtolower($payment_method_on_delivery) == 'efectivo') echo 'selected="selected"'; ?>>Efectivo</option>
                <option value="cod" <?php if (strtolower($payment_method_on_delivery) == 'cod') echo 'selected="selected"'; ?>>Cheque</option>
            </select>
        </div>

        <div class="form-entry">
            <label for="cod_comment"><?php echo $Language->get('entry_cod_comment'); ?></label>
            <textarea name="cod_comment" title="<?php echo $Language->get('help_cod_comment'); ?>" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
        <div class="necoform-actions" data-actions="necoform"></div>
    </form>
</div>

