<header class="page-heading columns">
    <h1>
        <?php echo $heading_title; ?>
    </h1>
    <?php if ($weight) { ?>
    <span id="weight"><?php echo $Language->get('text_cart_weight'); ?>&nbsp;<?php echo $weight; ?></span>
    <?php } ?>
</header>
<div id="contentWrapper" class="columns break">
    <?php if (isset($products) && !empty($products)) { ?>
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" id="orderForm" data-wizard="form">

        <?php include('shopping_cart_checkout_'. $settings['view'] .'_steps_control.tpl'); ?>

        <div class="clear"></div>

        <?php if (!empty($message)) { ?>
        <div class="message warning"><?php echo $message; ?></div>
        <?php } ?>

        <div class="neco-wizard-steps" data-wizard="steps">
            <?php include('shopping_cart_checkout_'. $settings['view'] .'_step_1.tpl'); ?>
            <?php include('shopping_cart_checkout_'. $settings['view'] .'_step_2.tpl'); ?>
            <?php include('shopping_cart_checkout_'. $settings['view'] .'_step_3.tpl'); ?>
            <?php include('shopping_cart_checkout_'. $settings['view'] .'_step_4.tpl'); ?>
            <?php include('shopping_cart_checkout_'. $settings['view'] .'_step_5.tpl'); ?>
        </div>

        <div class="necoform-actions" data-actions="necoform">
            <p>Al continuar con el proceso de compra, usted est&aacute; aceptando los <a href="<?php echo $Url::createUrl('content/page',array('page_id'=>$Config->get('config_checkout_id'))); ?>">t&eacute;rminos legales y las condiciones de uso</a> de este sitio web.</p>
        </div>

    </form>

    <script>
        window.nt.customer = window.nt.customer || {};
        window.nt.cart = window.nt.cart || {};

        window.nt.customer.isLogged = <?php echo (int)$this->customer->isLogged(); ?>;

        window.nt.cart.shippingCountryId = <?php echo (int)$shipping_country_id; ?>;
        window.nt.cart.shippingZoneId = <?php echo (int)$shipping_zone_id; ?>;
        window.nt.cart.shippingMethods = <?php echo (int)$shipping_methods; ?>;

        window.nt.cart.paymentCountryId = <?php echo (int)$payment_country_id; ?>;
        window.nt.cart.paymentZoneId = <?php echo (int)$payment_zone_id; ?>;

        window.nt.cart.txtButtonCheckout = '<?php echo $Language->get('button_checkout'); ?>';
        window.nt.cart.txtMustSelectShippingMethod = 'Debes seleccionar un m\u00E9todo de env\u00EDo';
        window.nt.cart.txtMustFillMandatory = 'Debes rellenar todos los campos obligatorios identificados con asterisco (*)';
        window.nt.cart.txtMustFillCorrectly = 'Debes rellenar este campo con la informaci\u00F3n correspondiente';

    </script>

    <?php } else { ?>
    <div style="text-align:center">
        <h3><?php echo $Language->get('Your Shopping Cart Is Empty!'); ?></h3>
        <small>
            <?php echo $Language->get('Visit our catalog to add some products to your shopping cart'); ?>
            <a href="<?php echo $Url::createUrl(store/product/all); ?>" class="btn"><?php echo $Language->get('See Products'); ?></a>
        </small>
    </div>
    <?php } ?>
</div>