<?php echo $header; ?>
<?php echo $navigation; ?>
    <section id="maincontent" class="row">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>


        <h1><?php echo $heading_title; ?></h1>
        <div class="text-message"><?php echo $text_message; ?></div>

        <div class="payment-data tabulated-data break">
            <h3>Tabla de Pagos Asociados al Pedido #<?php echo $order_id; ?></h3>
            <table>
                <tr>
                    <th>Descripcion</th>
                    <th>Pagos</th>
                    <th>Total</th>
                </tr>

                <tr>
                    <td>Total del Pedido</td>
                    <td>&nbsp;</td>
                    <td><?php echo $totals[count($totals)-1]['text']; ?></td>
                </tr>

                <?php foreach ($payments as $value) { ?>
                <?php if ($value['amount'] <= 0) continue; ?>
                <tr>
                    <td><a href="<?php echo $Url::createUrl("account/payment/receipt",array('payment_id'=>$value['order_payment_id'])); ?>" target="_blank">Pago #<?php echo $value['order_payment_id']; ?></a></td>
                    <td><?php echo $Currency->format($value['amount']); ?></td>
                    <td></td>
                </tr>
                <?php $total_payments = $total_payments + $value['amount']; ?>
                <?php } ?>

                <tr>
                    <td><b>Total Pagos Aprobados</b></td>
                    <td><?php echo $Currency->format($total_payments); ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Total A Devolver</td>
                    <td>&nbsp;</td>
                    <td>
                        <span><?php
                            if (($totals[count($totals)-1]['value'] - $total_payments) < 0) {
                                echo $Currency->format($total_payments - $totals[count($totals)-1]['value']);
                            } else {
                                echo $Currency->format(0);
                            }
                        ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Total A Pagar</td>
                    <td></td>
                    <td>
                        <h2>
                        <?php
                            if (($totals[count($totals)-1]['value'] - $total_payments) > 0) {
                                echo $Currency->format($totals[count($totals)-1]['value'] - $total_payments);
                            } else {
                                    echo $Currency->format(0);
                            }
                            ?>
                        </h2>
                    </td>
                </tr>
            </table>
        </div>
        <div class="payment-form">
            <h2>Seleccionar Forma de Pago</h2>
            <ul id="paymentMethods" class="nt-editable">
                <?php foreach ($payment_methods as $payment_method) { ?>
                    <li>{%<?php echo $payment_method['id']; ?>%}</li>
                <?php } ?>
            </ul>
        </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>