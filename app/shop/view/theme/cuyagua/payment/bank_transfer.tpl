<div class="heading widget-heading featured-heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div class="heading-title" onclick="$('#bankTransferGuide').slideToggle();">
        <h3 >
        <i class="heading-icon icon icon-library">
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/library.tpl"); ?>
        </i> 
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="simple-form guide break" id="bankTransferGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>

    <form id="bankTransferForm" name="bankTransferForm" method="post">

        <div class="form-entry">
            <label for="bank_transfer_order_id"><?php echo $Language->get('entry_bank_transfer_order_id'); ?></label>
            <select name="bank_transfer_order_id" title="<?php echo $Language->get('help_bank_transfer_order_id'); ?>">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-entry">
            <label for="bank_transfer_bank_id"><?php echo $Language->get('entry_bank_transfer_bank'); ?></label>
            <select name="bank_transfer_bank_id" id="bank_transfer_bank_id" title="<?php echo $Language->get('help_bank_transfer_bank'); ?>">
                <option value="">Seleccione la Cuenta donde deposit&oacute;</option>
                <?php foreach ($banks as $bank) { ?>
                <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-entry">
            <label for="bank_transfer_bank_account_id"><?php echo $Language->get('entry_bank_transfer_bank_account'); ?></label>
            <select name="bank_transfer_bank_account_id" id="bank_transfer_bank_account_id" title="<?php echo $Language->get('help_bank_transfer_bank_account'); ?>">
                <option value="">Seleccione la Cuenta donde deposit&oacute;</option>
                <?php foreach ($bank_accounts as $bank_account) { ?>
                <option value="<?php echo $bank_account['bank_account_id']; ?>"><?php echo $bank_account['number']." - ". $bank_account['accountholder']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-entry">
            <label for="bank_transfer_transact"><?php echo $Language->get('entry_bank_transfer_transact'); ?></label>
            <input type="text" name="bank_transfer_transact" title="<?php echo $Language->get('help_bank_transfer_transact'); ?>" value="" placeholder="Ingrese el n&uacute;mero de dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry">
            <label for="bank_transfer_date_added"><?php echo $Language->get('entry_bank_transfer_date_added'); ?></label>
            <input type="date" name="bank_transfer_date_added" title="<?php echo $Language->get('help_bank_transfer_date_added'); ?>" value="" placeholder="Ingrese la fecha del dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry">
            <label for="bank_transfer_amount"><?php echo $Language->get('entry_bank_transfer_amount'); ?></label>
            <input type="text" name="bank_transfer_amount" title="<?php echo $Language->get('help_bank_transfer_amount'); ?>" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>

        <div class="form-entry">
            <label for="bank_transfer_comment"><?php echo $Language->get('entry_bank_transfer_comment'); ?></label>
            <textarea name="bank_transfer_comment" title="<?php echo $Language->get('help_bank_transfer_comment'); ?>" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
    </form>
</div>
<script type="text/javascript">
$(function(){
    if (!jQuery().ntForm) {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>necojs/neco.form.js',
            'type':'text/javascript'
        }).appendTo('body');
    }
    if (typeof jQuery.ui == 'undefined') {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>vendor/jquery-ui.min.js',
            'type':'text/javascript'
        }).appendTo('body');
    }
    
    $('#bankTransferForm').ntForm({
        lockButton: false,
        ajax:true,
        url:'<?php echo $Url::createUrl("payment/bank_transfer/confirm"); ?>',
        beforeSend: function() {
            $('#temp').remove();
            $(document.createElement('div')).attr({
                'class':'overlay',
                'id':'temp'
            })
            .html('<img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="Cargando..." />')
            .appendTo('#bankTransferGuide');
        },
        success:function(data) {
            $('#temp').remove();
            if (typeof data.error != 'undefined' && typeof data.msg != 'undefined') {
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message error',
                })
                .html(data.msg)
                .appendTo('#bankTransferForm');
            } else if (typeof data.warning != 'undefined') {
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message warning',
                })
                .html(data.msg)
                .appendTo('#bankTransferForm');
            } else if (typeof data.success != 'undefined') {
                $('#bankTransferForm input').val('').removeAttr('checked').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#bankTransferForm select').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#bankTransferForm textarea').val('').removeClass('neco-input-success').removeClass('neco-input-error');
            
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message success',
                })
                .html(data.msg)
                .appendTo('#bankTransferForm');
            }
            if (typeof data.redirect != 'undefined') {
                window.location.href = data.redirect;
            }
        }
    });
    $('#bankTransferForm select').ntSelect();
    $('#bankTransferForm textarea').ntTextArea();
});
</script>
