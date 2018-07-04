<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    
    <?php if ($breadcrumbs) { ?>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
    
    <?php if ($success) { ?><div class="grid_12"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
    <?php if ($msg || $error_warning) { ?><div class="grid_12"><div class="message warning"><?php echo ($msg) ? $msg : $error_warning; ?></div></div><?php } ?>
    <?php if ($error) { ?><div class="grid_12"><div class="message error"><?php echo $error; ?></div></div><?php } ?>
    <div class="grid_12" id="msg"></div>
    
    <div class="box">
        <h1><?php echo $Language->get('heading_title'); ?></h1>
        <div class="buttons">
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_back'); ?></a>
        </div>

        <div class="clear"></div>

        <ul id="vtabs" class="vtabs">
            <li><a data-target="#tab_profile" onclick="showTab(this)"><?php echo $Language->get('text_profile'); ?></a></li>
            <li><a data-target="#tab_reviews" onclick="showTab(this)"><?php echo $Language->get('text_reviews'); ?></a></li>
            <li><a data-target="#tab_balance" onclick="showTab(this)"><?php echo $Language->get('text_balances'); ?></a></li>
            <li><a data-target="#tab_orders" onclick="showTab(this)"><?php echo $Language->get('text_orders'); ?></a></li>
            <li><a data-target="#tab_payments" onclick="showTab(this)"><?php echo $Language->get('text_payments'); ?></a></li>
            <li><a data-target="#tab_shopping_carts" onclick="showTab(this)"><?php echo $Language->get('text_shopping_carts'); ?></a></li>
            <li><a data-target="#tab_visits" onclick="showTab(this)"><?php echo $Language->get('text_visits'); ?></a></li>
            <li><a data-target="#tab_activities" onclick="showTab(this)"><?php echo $Language->get('text_activities'); ?></a></li>
            <li><a data-target="#tab_messages" onclick="showTab(this)"><?php echo $Language->get('text_messages'); ?></a></li>
            <li><a data-target="#tab_clients_referred" onclick="showTab(this)"><?php echo $Language->get('text_clients_referred'); ?></a></li>
            <li><a data-target="#tab_customer_groups" onclick="showTab(this)"><?php echo $Language->get('text_customer_groups'); ?></a></li>
            <li><a data-target="#tab_promotions" onclick="showTab(this)"><?php echo $Language->get('text_promotions'); ?></a></li>
            <li><a data-target="#tab_shared" onclick="showTab(this)"><?php echo $Language->get('text_shareds'); ?></a></li>
        </ul>

        <div class="vtabs_page" id="tab_profile"></div>

        <div class="vtabs_page" id="tab_reviews"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_balance"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_orders"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_payments"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_shopping_carts"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_visits"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_activities"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_messages"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_clients_referred"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_customer_groups"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_promotions"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>
        <div class="vtabs_page" id="tab_shared"><img src="<?php echo HTTP_IMAGE; ?>loader.gif" alt="<?php echo $Language->get('text_loading'); ?>" /></div>

    </div>
</div>
<?php echo $footer; ?>