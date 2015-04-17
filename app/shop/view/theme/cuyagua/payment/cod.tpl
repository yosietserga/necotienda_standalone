<div class="heading widget-heading featured-heading large-heading-dropdown" id="<?php echo $widgetName; ?>Header">
    <div onclick="$('#codGuide').slideToggle();" class="heading-title">
        <h3>
            <i class="heading-icon icon icon-home">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/home.tpl"); ?>
            </i>
            <?php echo $Language->get('text_title'); ?>
        </h3>
    </div>
</div>

<div class="simple-form guide break" id="codGuide" style="display: none;">
    <?php if (!empty($instructions)) { echo $instructions; } ?>
    <form action="<?php echo $Url::createUrl("payment/cod/confirm"); ?>" method="post" id="codForm">
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
    </form>
</div>

<script type="text/javascript">
$(function(){
    
    var guide = $('#codGuide');
    var body = $('body');
    var form = $("#codForm");
    var overlay;

    var appendMessage = function (target, messageElement) {
        target.find('.spinner-loader').remove();
        target.append(messageElement);
    };

    var clearForm = function () {
        form.find('input')
            .val('')
            .removeAttr('checked')
            .removeClass('neco-input-success')
            .removeClass('neco-input-error');
        form.find('select')
            .removeClass('neco-input-success')
            .removeClass('neco-input-error');
        form.find('textarea')
            .val('')
            .removeClass('neco-input-success')
            .removeClass('neco-input-error');
    };
    var createMessage = function (type, message) {
        var message = $('<div>').attr({
            'id': 'temp',
            'class': 'message overlayed ' +  type
        }).html(message);
        return message;
    };
    var createOverlay = function () {
        var overlay = $('<div>');
        overlay.attr({
            'class':'overlay-view',
            'id': 'temp'
        }).css({
            opacity: 1,
            position: "fixed",
            overflow: 'hidden'
        }).html(
            '<i class="spinner-loader icon">'
            + '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . '/shared/icons/loader.tpl'); ?>'
            +' </i>'
        );
        overlay.click(function (e) {
            var $self = $(this);
            $self.css({
                opacity: 0,
            });
            $self.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function (e) {
                body.css({
                    overflow: 'auto',
                    marginRight: '0rem'
                });
                $self.remove();
            });
        });
        return overlay;
    };

    if (!jQuery.fn.ntForm) {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>necojs/neco.form.js',
            'type':'text/javascript'
        }).appendTo('body');
    }
    if (typeof jQuery.ui === 'undefined') {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>vendor/jquery-ui.min.js',
            'type':'text/javascript'
        }).appendTo('body');
    }
    form.ntForm({
        ajax:true,
        url:'<?php echo $Url::createUrl("payment/cod/confirm"); ?>',
        beforeSend: function() {
            overlay = createOverlay();
            body.css({
                overflow: 'hidden',
                marginRight: '1.063rem'
            });
            guide.append(overlay);
        },
        success:function(data) {
            if (typeof data.error !== 'undefined' && typeof data.msg !== 'undefined') {
                appendMessage(overlay, createMessage('error', data.msg));
            }
            else if (typeof data.warning !== 'undefined') {
                appendMessage(overlay, createMessage('warning', data.msg));
            }
            else if (typeof data.success !== 'undefined') {
                clearForm();
                appendMessage(overlay, createMessage('success', data.msg));
            }
            if (typeof data.redirect !== 'undefined') {
                window.location.href = data.redirect;
            }
        }
    });
});
</script>
