<div class="grid_2" onclick="$('#debitGuide').slideToggle();">
    <?php if ($Config->get('debit_image')) { ?><img src="<?php echo $Image::resizeAndSave($Config->get('debit_image'),90,90); ?>" alt="Cheque" /><?php } ?>
</div>

<div class="grid_6">
    <h3 onclick="$('#debitGuide').slideToggle();"><?php echo $Language->get('text_title'); ?></h3>
</div>

<div class="grid_2">
    <a onclick="$('#debitGuide').slideToggle();" title="<?php echo $Language->get('button_pay'); ?>" id="debitCheckoutCheckout" class="button"><?php echo $Language->get('button_pay'); ?></a>
</div>

<div class="clear"></div>

<div class="guide" id="debitGuide" style="display: none;">

    <p><?php echo $Language->get('text_amount_available'); ?>&nbsp;<b style="font-size: 24px;" id="amount_available"><?php echo $balance['available']; ?></b></p>
    
    
    <div class="clear"></div>
    
    <form id="debitForm" name="debitForm" method="post">
    
        <div class="row">
            <label for="amount"><?php echo $Language->get('entry_debit_amount'); ?></label>
            <input type="money" name="amount" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>
        
        <div class="clear"></div>
        
        <div class="row">
            <label for="order_id"><?php echo $Language->get('entry_debit_order_id'); ?></label>
            <select name="order_id" showquick="off">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="clear"></div>
        
        <div class="row">
            <label for="comment"><?php echo $Language->get('entry_debit_order_id'); ?></label>
            <textarea name="comment" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
        
        <input type="hidden" name="payment_method" value="debit" />
        
        <div class="clear"></div>
        
    </form>
</div>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>necojs/neco.form.js"></script>
<script type="text/javascript">
$(function(){
    $('#debitForm').ntForm({
        lockButton: false,
        ajax:true,
        url:'<?php echo $Url::createUrl("payment/debit/confirm"); ?>',
        beforeSend: function() {
            $('#temp').remove();
            $(document.createElement('div')).attr({
                'class':'overlay',
                'id':'temp'
            })
            .html('<img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="Cargando..." />')
            .appendTo('#debitGuide');
        },
        success:function(data) {
            $('#temp').remove();
            
            if (typeof data.error != 'undefined') {
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message error',
                })
                .html(data.msg)
                .appendTo('#debitForm');
            } else if (typeof data.warning != 'undefined' && typeof data.msg != 'undefined') {
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message warning',
                })
                .html(data.msg)
                .appendTo('#debitForm');
            } else if (typeof data.success != 'undefined') {
                $('#debitForm input').val('').removeAttr('checked').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#debitForm select').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#debitForm textarea').val('').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#amount_available').html(data.amount_available);
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message success',
                })
                .html(data.msg)
                .appendTo('#debitForm');
            }
            if (typeof data.redirect != 'undefined') {
                window.location.href = data.redirect;
            }
        }
    });
    
    $('#debitCheckout select').ntSelect();
    $('#debitCheckout textarea').ntTextArea();
    $('#debitCheckoutCheckout').on('click',function() {
        if ($('#debitGuide').hasClass('on')) {
            $('#debitGuide').removeClass('on').slideUp();
        } else {
            $('#debitGuide').addClass('on').slideDown();
        }
    });
});
</script>