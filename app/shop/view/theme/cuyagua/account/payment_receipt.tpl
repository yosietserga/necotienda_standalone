<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>
        <!--<div class="print-action">
            <a onclick="window.print();" class="button">Imprimir</a>
            <?php //TODO: <a onclick="window.print();" class="button">PDF</a> ?>
        </div>-->

        <div class="order-info row">
            <div class="large-8 columns">
                <img src="<?php echo HTTP_IMAGE . $Config->get('config_logo'); ?>" alt="<?php echo $Config->get('config_name'); ?>" />
                <?php echo $Config->get('config_owner'); ?>
                <?php echo $Config->get('config_rif'); ?>
                <?php echo $Config->get('config_address'); ?>
            </div>
            <div class="large-8 columns">
                Control N&deg; <?php echo $order_payment_id; ?><br />
                Pedido N&deg; <?php echo $order_id; ?><br />
                Fecha de Emisi&oacute;n <?php echo date('d-m-Y h:i A',strtotime($date_added)); ?>
            </div>
        </div>

        <div class="payment-message">
            <p>Hemos recibido un pago realizado por <?php echo $payment_firstname ." ". $payment_lastname; ?> por la cantidad de <?php echo $amount; ?> por concepto del pago/abono del pedido <?php echo $order_id; ?> con un total de <?php echo $total; ?>.</p>
            <p>El pago fue realizado a tr&aacute;ves del m&eacute;todo <span><?php echo ucfirst($payment_method); ?></span></p>
        </div>
        <div class="order-data">
            <h2>Datos del Pedido</h2>
            <table>
                <tr>
                    <td>Pedido ID</td>
                    <td><b><?php echo $order_id; ?></b></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><b><?php echo $total; ?></b></td>
                </tr>
            </table>
        </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>