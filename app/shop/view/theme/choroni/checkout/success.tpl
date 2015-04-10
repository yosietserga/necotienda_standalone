<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent">
        <section id="content">
        <?php if ($breadcrumbs) { ?>
        <div class="grid_12 hideOnMobile">
            <ul id="breadcrumbs" class="nt-editable">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
            </ul>
        </div>
        <?php } ?>
        
        <div class="clear"></div><br /><br />
        
        <div class="grid_12">
            <div id="featuredContent">
            <ul class="widgets"><?php if($featuredWidgets) { foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
            </div>
        </div>
            
        <div class="clear"></div>
        
        <div class="grid_12">
        
            <h1><?php echo $heading_title; ?></h1>
            <p><?php echo $text_message; ?></p>
              
            <h2>Tabla de Pagos Asociados al Pedido #<?php echo $order_id; ?></h2>
            <table>
                <tr>
                    <th>Descripcion</th>
                    <th>Pagos</th>
                    <th>Total</th>
                </tr>
                
                <tr>
                    <td>Total del Pedido</td>
                    <td>&nbsp;</td>
                    <td style="text-align:right;"><?php echo $totals[count($totals)-1]['text']; ?></td>
                </tr>
            
                <?php foreach ($payments as $value) { ?>
                <?php if ($value['amount'] <= 0) continue; ?>
                <tr>
                    <td><a href="<?php echo $Url::createUrl("account/payment/receipt",array('payment_id'=>$value['order_payment_id'])); ?>" target="_blank">Pago #<?php echo $value['order_payment_id']; ?></a></td>
                    <td style="text-align:right;"><?php echo $Currency->format($value['amount']); ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php $total_payments = $total_payments + $value['amount']; ?>
                <?php } ?>
                
                <tr>
                    <td><b>Total Pagos Aprobados</b></td>
                    <td style="text-align:right;"><b><?php echo $Currency->format($total_payments); ?></b></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><b>Total A Devolver</b></td>
                    <td>&nbsp;</td>
                    <td style="text-align:right;">
                        <b><?php
                        if (($totals[count($totals)-1]['value'] - $total_payments) < 0) {
                            echo $Currency->format($total_payments - $totals[count($totals)-1]['value']);
                        } else {
                                echo $Currency->format(0);
                        }
                        ?></b>
                    </td>
                </tr>
                <tr>
                    <td><b>Total A Pagar</b></td>
                    <td>&nbsp;</td>
                    <td style="text-align:right;">
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
            <hr />
            <h2>Seleccionar Forma de Pago</h2>
            <ul id="paymentMethods" class="nt-editable">
            <?php foreach ($payment_methods as $payment_method) { ?>
                <li>{%<?php echo $payment_method['id']; ?>%}</li>
            <?php } ?>
            </ul>
    
        </div>
        
            <div class="clear"></div>

            <div class="grid_12">
                <div id="featuredFooter">
                <ul class="widgets" data-position="featuredFooter"><?php if($featuredFooterWidgets) { foreach ($featuredFooterWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
                </div>
            </div>

        </section>
    </section>
</div>
<?php echo $footer; ?>