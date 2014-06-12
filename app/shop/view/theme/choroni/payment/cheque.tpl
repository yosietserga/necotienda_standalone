<div class="grid_2" onclick="$('#chequeGuide').slideToggle();">
    <?php if ($Config->get('cheque_image')) { ?><img src="<?php echo $Image::resizeAndSave($Config->get('cheque_image'),90,90); ?>" alt="Cheque" /><?php } ?>
</div>

<div class="grid_6">
    <h3 onclick="$('#chequeGuide').slideToggle();"><?php echo $Language->get('text_title'); ?></h3>
</div>

<div class="grid_2">
    <a onclick="$('#chequeGuide').slideToggle();" title="<?php echo $Language->get('button_pay'); ?>" id="chequeCheckoutCheckout" class="button"><?php echo $Language->get('button_pay'); ?></a>
</div>

<div class="clear"></div>

<div class="guide" id="chequeGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
    
    <div class="clear"></div>
    
    <form id="chequeForm" name="chequeForm" method="post">
        
        <div class="row">
            <label for="cheque_order_id"><?php echo $Language->get('entry_cheque_order_id'); ?></label>
            <select name="cheque_order_id" title="<?php echo $Language->get('help_cheque_order_id'); ?>" showquick="off">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>
            
        <div class="clear"></div>
            
        <div class="row">
            <label for="cheque_bank_account_id"><?php echo $Language->get('entry_cheque_bank_account'); ?></label>
            <select name="cheque_bank_account_id" id="cheque_bank_account_id" title="<?php echo $Language->get('help_cheque_bank_account'); ?>" showquick="off">
                <option value="">Seleccione la Cuenta donde deposit&oacute;</option>
                <?php foreach ($bank_accounts as $bank_account) { ?>
                <option value="<?php echo $bank_account['bank_account_id']; ?>"><?php echo $bank_account['number']." - ". $bank_account['accountholder']; ?></option>
                <?php } ?>
            </select>
        </div>
            
        <div class="clear"></div>
            
        <div class="row">
            <label for="cheque_transact"><?php echo $Language->get('entry_cheque_transact'); ?></label>
            <input type="text" name="cheque_transact" title="<?php echo $Language->get('help_cheque_transact'); ?>" value="" placeholder="Ingrese el n&uacute;mero de dep&oacute;sito" required="required" />
        </div>
            
        <div class="clear"></div>
            
        <div class="row">
            <label for="cheque_date_added"><?php echo $Language->get('entry_cheque_date_added'); ?></label>
            <input type="necoDate" name="cheque_date_added" title="<?php echo $Language->get('help_cheque_date_added'); ?>" value="" placeholder="Ingrese la fecha del dep&oacute;sito" required="required" />
        </div>
            
        <div class="clear"></div>
            
        <div class="row">
            <label for="cheque_amount"><?php echo $Language->get('entry_cheque_amount'); ?></label>
            <input type="money" name="cheque_amount" title="<?php echo $Language->get('help_cheque_amount'); ?>" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>
            
        <div class="clear"></div>
            
        <div class="row">
            <label for="cheque_comment"><?php echo $Language->get('entry_cheque_comment'); ?></label>
            <textarea name="cheque_comment" title="<?php echo $Language->get('help_cheque_comment'); ?>" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
            
        <div class="clear"></div>
            
    </form>
</div>

<div class="clear"></div>

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
    
    $('#chequeForm').ntForm({
        lockButton: false,
        ajax:true,
        url:'<?php echo $Url::createUrl("payment/cheque/confirm"); ?>',
        beforeSend: function() {
            $('#temp').remove();
            $(document.createElement('div')).attr({
                'class':'overlay',
                'id':'temp'
            })
            .html('<img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="Cargando..." />')
            .appendTo('#chequeGuide');
        },
        success:function(data) {
            $('#temp').remove();
            if (typeof data.error != 'undefined' && typeof data.msg != 'undefined') {
                alert(data.msg);
            } else if (typeof data.warning != 'undefined') {
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message warning',
                })
                .html(data.msg)
                .appendTo('#chequeForm');
            } else if (typeof data.success != 'undefined') {
                $('#chequeForm input').val('').removeAttr('checked').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#chequeForm select').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#chequeForm textarea').val('').removeClass('neco-input-success').removeClass('neco-input-error');
            
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message success',
                })
                .html(data.msg)
                .appendTo('#chequeForm');
            }
            if (typeof data.redirect != 'undefined') {
                window.location.href = data.redirect;
            }
        }
    });
    $('#chequeForm select').ntSelect();
    $('#chequeForm textarea').ntTextArea();
});
</script>
