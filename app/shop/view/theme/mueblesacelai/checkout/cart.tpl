<?php echo $header; ?>
<?php echo $navigation; ?>
<!-- cart-chekcout -->
<section id="maincontent" class="row">
    <div class="cart-checkout">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
        <header class="page-heading columns">
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <?php if ($weight) { ?>
                 <span id="weight"><?php echo $Language->get('text_cart_weight'); ?>&nbsp;<?php echo $weight; ?></span>
            <?php } ?>
        </header>
        <div id="contentWrapper" class="columns break">
            <!-- neco wizard -->
                <ul class="neco-wizard-controls" data-wizard="controls">
                    <li id="necoWizardControl_1" data-wizard="nav" data-wizard-step="basket">
                        <span><?php echo $Language->get('text_basket'); ?></span>
                    </li>

                    <?php if (!$isLogged) { ?>
                    <li id="necoWizardControl_2" data-wizard="nav" data-wizard-step="billing">
                        <span><?php echo $Language->get('text_billing'); ?></span>
                    </li>
                    <?php } ?>

                    <?php if ($shipping_methods || (!$isLogged || ($isLogged && !$shipping_country_id))) { ?>

                    <li id="necoWizardControl_3" data-wizard="nav" data-wizard-step="shipping">
                        <span><?php echo $Language->get('text_shipping'); ?></span>
                    </li>

                    <?php }?>

                    <li id="necoWizardControl_4" data-wizard="nav" data-wizard-step="confirm">
                        <span><?php echo $Language->get('text_confirm'); ?></span>
                    </li>

                    <li id="necoWizardControl_5" data-wizard="nav" data-wizard-step="complete">
                        <span><?php echo $Language->get('text_complete'); ?></span>
                    </li>
                </ul>

                <?php if (!empty($message)) { ?>
                    <div class="message warning"><?php echo $message; ?></div>
                <?php } ?>

                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" id="orderForm" data-wizard="form">
                    <div class="neco-wizard-steps" data-wizard="steps">

                        <!-- recipe-info -->
                        <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                            <section id="necoWizardStep_1" class="store" data-wizard="step">
                        <?php } else { ?>
                            <section id="necoWizardStep_1" class="not-store" data-wizard="step">
                        <?php } ?>
                            <div class="cart-detail">
                                <table class="cart-recipe">
                                    <thead>
                                        <tr>
                                            <th><?php echo $Language->get('column_image'); ?></th>
                                            <th><?php echo $Language->get('column_name'); ?></th>
                                            <th><?php echo $Language->get('column_model'); ?></th>
                                            <th><?php echo $Language->get('column_quantity'); ?></th>
                                            <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                                <th><?php echo $Language->get('column_price'); ?></th>
                                                <th><?php echo $Language->get('column_total'); ?></th>
                                            <?php } ?>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) { ?>
                                        <tr>
                                            <td><a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>

                                            <td>
                                                <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                                                    <?php echo $product['name']; ?>
                                                </a>
                                                <div>
                                                    <?php foreach ($product['option'] as $option) { ?>
                                                        - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                                                    <?php } ?>
                                                </div>
                                            </td>

                                            <td data-label="<?php echo $Language->get('column_model'); ?>"><?php echo $product['model']; ?></td>

                                            <td data-label="<?php echo $Language->get('column_quantity'); ?>">
                                                <input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" showquick="off" size="3"  onchange="refreshCart(this,'<?php echo $product['key']; ?>')" />

                                                <a class="update-product" onclick="refreshCart(this,'<?php echo $product['key']; ?>')" title="<?php echo $Language->get('text_update'); ?>">
                                                </a>
                                            </td>
                                            <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                                <td data-label="<?php echo $Language->get('column_price'); ?>"><?php echo $product['price']; ?></td>
                                                <td data-label="<?php echo $Language->get('column_total'); ?>"><?php echo $product['total']; ?></td>
                                            <?php } ?>
                                            <td>
                                                <a class="delete-product" onclick="deleteCart(this,'<?php echo $product['key']; ?>')" title="<?php echo $Language->get('text_delete'); ?>">
                                                    <i class="cart-icon icon icon-bin">
                                                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/bin.tpl"); ?>
                                                    </i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                                    <table id="totals" class="cart-totals">
                                        <?php foreach ($totals as $total) { ?>
                                            <tr>
                                                <td><?php echo $total['title']; ?></td>
                                                <td><?php echo $total['text']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } ?>
                            </div>

                            <div class="coupon-wrapper">
                                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/coupon.tpl"); ?>
                            </div>
                        </section>
                        <!-- recipe info -->

                        <?php if (!$isLogged) { ?>

                        <!-- address info -->
                        <section id="necoWizardStep_2" data-wizard="step">
                            <div class="recipe-info info-form">
                                <fieldset>
                                    <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                                        <div class="heading-title">
                                            <h3>
                                                <i class="heading-icon icon icon-credit-card">
                                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/credit-card.tpl"); ?>
                                                </i>
                                                <?php echo $Language->get('legend_recipe_form'); ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <?php if ($isLogged) { ?>
                                        <a href="index.php?r=account/account" title="<?php echo $Language->get('text_update'); ?>"></a>
                                    <?php } ?>

                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/email.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/lastname.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/company.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/rif.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/telephone.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/referenceby.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/location.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/city.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/street.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/postcode.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/address.tpl"); ?>

                                </fieldset>
                            </div>
                        </section>
                    <?php } ?>
                    <!-- /address-info -->

                    <!--shipping-section -->
                    <?php if ($shipping_methods || (!$isLogged || ($isLogged && !$shipping_country_id))) { ?>
                    <section id="necoWizardStep_3" data-wizard="step">
                        <div class="delivery-form info-form">
                            <?php if (!$isLogged || ($isLogged && !$shipping_country_id)) { ?>
                                <fieldset>
                                    <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                                        <div class="heading-title">
                                            <h3>
                                                <i class="heading-icon icon icon-truck">
                                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/truck.tpl"); ?>
                                                </i>
                                                <?php echo $Language->get('legend_shipping_form'); ?>
                                            </h3>
                                        </div>
                                    </div>

                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/shipping/country.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/shipping/zone.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/shipping/city.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/shipping/street.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/shipping/code.tpl"); ?>
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/shipping/address.tpl"); ?>

                                    <input type="hidden" name="payment_country_id" id="payment_country_id" value="<?php echo $payment_country_id; ?>" />
                                    <input type="hidden" name="payment_zone_id" id="payment_zone_id" value="<?php echo $payment_zone_id; ?>" />
                                    <input type="hidden" name="payment_street" id="payment_street" value="<?php echo $payment_street; ?>" />
                                    <input type="hidden" name="payment_city" id="payment_city" value="<?php echo $payment_city; ?>" />
                                    <input type="hidden" name="payment_postcode" id="payment_postcode" value="<?php echo $payment_postcode; ?>" />
                                    <input type="hidden" name="payment_address_1" id="payment_address_1" value="<?php echo $payment_address_1; ?>" />
                                </fieldset>
                                <?php } else { ?>
                                    <input type="hidden" name="payment_country_id" id="payment_country_id" value="<?php echo $payment_country_id; ?>" />
                                    <input type="hidden" name="payment_zone_id" id="payment_zone_id" value="<?php echo $payment_zone_id; ?>" />
                                    <input type="hidden" name="payment_city" id="payment_city" value="<?php echo $payment_city; ?>" />
                                    <input type="hidden" name="payment_street" id="payment_street" value="<?php echo $payment_street; ?>" />
                                    <input type="hidden" name="payment_postcode" id="payment_postcode" value="<?php echo $payment_postcode; ?>" />
                                    <input type="hidden" name="payment_address_1" id="payment_address_1" value="<?php echo $payment_address_1; ?>" />

                                    <input type="hidden" name="shipping_country_id" id="shipping_country_id" value="<?php echo $shipping_country_id; ?>" />
                                    <input type="hidden" name="shipping_zone_id" id="shipping_zone_id" value="<?php echo $shipping_zone_id; ?>" />
                                    <input type="hidden" name="shipping_city" id="shipping_city" value="<?php echo $shipping_city; ?>" />
                                    <input type="hidden" name="shipping_street" id="shipping_street" value="<?php echo $shipping_street; ?>" />
                                    <input type="hidden" name="shipping_postcode" id="shipping_postcode" value="<?php echo $shipping_postcode; ?>" />
                                    <input type="hidden" name="shipping_address_1" id="shipping_address_1" value="<?php echo $shipping_address_1; ?>" />
                                <?php } ?>

                            <?php if ($shipping_methods) { ?>
                            <div class="shipping-methods break">
                                <fieldset>
                                    <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                                        <div class="heading-title">
                                            <h3>
                                                <i class="heading-icon icon icon-envelope">
                                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/envelope.tpl"); ?>
                                                </i>
                                                <?php echo $Language->get('text_shipping_methods'); ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th><?php echo $Language->get('table_head_shipping_select'); ?></th>
                                                <th><?php echo $Language->get('table_head_shipping_method'); ?></th>
                                                <th><?php echo $Language->get('table_head_shipping_price'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($shipping_methods as $shipping_method) { ?>
                                            <?php foreach ($shipping_method['quote'] as $quote) { ?>
                                            <tr>
                                                <td data-label="<?php echo $Language->get('table_head_shipping_select'); ?>">
                                                    <div class="check-action">
                                                        <input data-check="order" type="radio" name="shipping_method" value="<?php echo $quote['id']; ?>" />
                                                        <span class="radio-button"></span>
                                                    </div>
                                                </td>
                                                <td data-shipping_title>
                                                    <?php echo $quote['title']; ?>
                                                </td>
                                                <td data-shipping_price data-label="<?php echo $Language->get('table_head_shipping_price'); ?>">
                                                    <?php echo $quote['text']; ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                            <?php } ?>
                        </div>
                    </section>
                    <?php } ?>
                    <!--/shipping section-->

                    <!--payment section -->
                    <section id="necoWizardStep_4" data-wizard="step" class="break">
                        <div class="payment-section row">
                            <div class="recipe-data medium-6 column data">
                                <h3 class="payment-heading data-heading"><?php echo $Language->get('text_order_confirm'); ?></h3>
                                <ul class="confirmOrder">
                                    <li>
                                        <span><?php echo $Language->get('text_company'); ?>:</span>
                                        <span id="confirmCompany"><?php echo $company; ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo $Language->get('text_rif'); ?>:</span>
                                        <span id="confirmRif"><?php echo $riff; ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo $Language->get('text_address'); ?>:</span>
                                        <span id="confirmPaymentAddress"><?php echo $payment_address; ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="shipping-data large-6 medium-6 small-12 columns data">
                                <h3 class="shipping-heading data-heading"><?php echo $Language->get('text_shipping_address_and_method'); ?></h3>
                                <ul class="confirmOrder">
                                    <?php if ($shipping_methods) { ?>
                                    <li>
                                        <span><?php echo $Language->get('text_payment_shipping_method'); ?>:</span>
                                        <span id="shipping_method"></span>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <span><?php echo $Language->get('text_payment_address'); ?>:</span>
                                        <span id="confirmShippingAddress"><?php echo $shipping_address; ?></span>
                                    </li>
                                </ul>
                            </div>

                            <div class="cart-summary large-12 medium-6 column">
                                <table class="cart-recipe">
                                    <thead>
                                        <tr>
                                            <th><?php echo $Language->get('text_summary_description'); ?></th>
                                            <th><?php echo $Language->get('text_summary_model');?></th>
                                            <th><?php echo $Language->get('text_summary_cant');?></th>
                                            <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                                                <th><?php echo $Language->get('text_summary_price');?></th>
                                                <th><?php echo $Language->get('text_summary_total');?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) { ?>
                                            <tr id="confirmItem<?php echo $product['product_id']; ?>">
                                                <td>
                                                    <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                                                        <?php echo $product['name']; ?>
                                                    </a>
                                                    <div>
                                                        <?php foreach ($product['option'] as $option) { ?>- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td data-label="<?php echo $Language->get('text_summary_model'); ?>">
                                                    <?php echo $product['model']; ?>
                                                </td>
                                                <td data-label="<?php echo $Language->get('text_summary_cant'); ?>" id="confirmQty<?php echo $product['product_id']; ?>">
                                                    <?php echo $product['quantity']; ?>
                                                </td>
                                                <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                                    <td data-label="<?php echo $Language->get('text_summary_price'); ?>">
                                                        <?php echo $product['price']; ?>
                                                    </td>
                                                    <td data-label="<?php echo $Language->get('text_summary_total'); ?>" id="confirmTotal<?php echo $product['product_id']; ?>">
                                                        <?php echo $product['total']; ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                <table id="totalsConfirm" class="cart-totals">
                                    <?php foreach ($totals as $total) { ?>
                                        <tr>
                                            <td><?php echo $total['title']; ?></td>
                                            <td><?php echo $total['text']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>
                            </div>
                            <div class="confirmation-comment column">
                                <textarea name="comment" placeholder="Ingresa tus comentarios sobre el pedido aqu&iacute;"></textarea>
                            </div>
                        </div>
                    </section>
                    <!-- payment-section-->

                    <!--  request-section -->
                    <section id="necoWizardStep_5" class="wizard-step processing-step" data-wizard="step">
                        <div class="loader">
                            <i>
                                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . '/shared/icons/loader.tpl'); ?>
                            </i>
                        </div>
                        <div class="text-block" style="text-align:center">
                            <p>
                                <?php echo $Language->get('help_processing'); ?>
                            </p>
                        </div>

                    </section>
                    <!--  request-section -->
                </div>
                   <div class="necoform-actions" data-actions="necoform">

                                <p>Al continuar con el proceso de compra, usted est&aacute; aceptando los <a href="<?php echo $Url::createUrl('content/page',array('page_id'=>$Config->get('config_checkout_id'))); ?>">t&eacute;rminos legales y las condiciones de uso</a> de este sitio web.</p>
                   </div>
            </form>
            <!-- /neco-wizard -->

        </div>
        <!-- /content-wrapper -->
    </div>

    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

</section>
<!-- cart-checkout -->
<?php echo $footer; ?>