<div class="grid_2" onclick="$('#codGuide').slideToggle();">
    <?php if ($Config->get('cod_image')) { ?><img src="<?php echo $Image::resizeAndSave($Config->get('cod_image'),90,90); ?>" alt="Pagar en la tienda" /><?php } ?>
</div>

<div class="grid_6">
    <h3 onclick="$('#codGuide').slideToggle();"><?php echo $Language->get('text_title'); ?></h3>
</div>

<div class="grid_2">
    <a onclick="$('#codGuide').slideToggle();" title="<?php echo $Language->get('button_pay'); ?>" id="codCheckout" class="button"><?php echo $Language->get('button_pay'); ?></a>
</div>

<div class="clear"></div>

<div class="guide" id="codGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
    <form action="<?php echo $Url::createUrl("payment/cod/confirm"); ?>" method="post" id="codForm">
        
        <div class="row">
            <label for="cod_order_id"><?php echo $Language->get('entry_cod_order_id'); ?></label>
            <select name="cod_order_id" title="<?php echo $Language->get('help_cod_order_id'); ?>" showquick="off">
                <option value="">Seleccione el ID del Pedido</option>
                <?php foreach ($orders as $order) { ?>
                <option value="<?php echo $order['order_id']; ?>"<?php if ($order_id == $order['order_id']) echo ' selected="selected"'; ?>><?php echo "#". $order['order_id']." - ". $order['date_added'] ." - ". $order['total']; ?></option>
                <?php } ?>
            </select>
        </div>
            
        <div class="clear"></div>
            
        <div class="property">
            <label for="cod_date_of_payment"><?php echo $Language->get('entry_cod_date_of_payment'); ?>:</label>
            <input type="necoDate" id="cod_date_of_payment" name="cod_date_of_payment" title="<?php echo $Language->get('help_cod_date_of_payment'); ?>" required="required" placeholder="dd/mm/yyyy" />
        </div>
        
        <div class="clear"></div>
            
        <div class="property">
            <label for="cod_amount"><?php echo $Language->get('entry_cod_amount'); ?>:</label>
            <input type="money" name="cod_amount" id="cod_amount" title="<?php echo $Language->get('help_cod_amount'); ?>" value="" placeholder="Ingrese el monto del dep&oacute;sito" required="required" />
        </div>
        
        <div class="clear"></div>
            
        <div class="property">
            <label for="cod_payment_method_on_delivery"><?php echo $Language->get('entry_cod_payment_method_on_delivery'); ?>:</label>
            <select name="cod_payment_method_on_delivery" id="cod_payment_method_on_delivery" title="<?php echo $Language->get('help_cod_payment_method_on_delivery'); ?>" showquick="off">
                <option value="tc" <?php if (strtolower($payment_method_on_delivery) == 'tc') echo 'selected="selected"'; ?>>Tarjeta de Cr�dito</option>
                <option value="td" <?php if (strtolower($payment_method_on_delivery) == 'td') echo 'selected="selected"'; ?>>Tarjeta de D�bito</option>
                <option value="efectivo" <?php if (strtolower($payment_method_on_delivery) == 'efectivo') echo 'selected="selected"'; ?>>Efectivo</option>
                <option value="cod" <?php if (strtolower($payment_method_on_delivery) == 'cod') echo 'selected="selected"'; ?>>Cheque</option>
            </select>
        </div>
        
        <div class="clear"></div>
            
        <div class="row">
            <label for="cod_comment"><?php echo $Language->get('entry_cod_comment'); ?></label>
            <textarea name="cod_comment" title="<?php echo $Language->get('help_cod_comment'); ?>" placeholder="Ingresa tu comentario aqu&iacute;" showquick="off"></textarea>
        </div>
            
        <div class="clear"></div>
            
    </form>
</div>
    
<div class="clear"></div>

<script type="text/javascript">
$(function(){
    if (!jQuery.fn.ntForm()) {
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
    $('#codForm').ntForm({
        lockButton: false,
        ajax:true,
        url:'<?php echo $Url::createUrl("payment/cod/confirm"); ?>',
        beforeSend: function() {
            $('#temp').remove();
            $(document.createElement('div')).attr({
                'class':'overlay',
                'id':'temp'
            })
            .html('<img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="Cargando..." />')
            .appendTo('#codGuide');
        },
        success:function(data) {
            $('#temp').remove();
            
            if (typeof data.error != 'undefined' && typeof data.msg != 'undefined') {
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message error',
                })
                .html(data.msg)
                .appendTo('#codForm');
            } else if (typeof data.warning != 'undefined') {
            } else if (typeof data.success != 'undefined') {
                $('#codForm input').val('').removeAttr('checked').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#codForm select').removeClass('neco-input-success').removeClass('neco-input-error');
                $('#codForm textarea').val('').removeClass('neco-input-success').removeClass('neco-input-error');
                $(document.createElement('div')).attr({
                    'id':'temp',
                    'class':'message success',
                })
                .html(data.msg)
                .appendTo('#codForm');
            }
            if (typeof data.redirect != 'undefined') {
                window.location.href = data.redirect;
            }
        }
    });
    $('#codForm select').ntSelect();
    $('#codForm textarea').ntTextArea();
});
</script>
