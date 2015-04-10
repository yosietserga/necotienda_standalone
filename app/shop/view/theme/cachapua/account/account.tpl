<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/messages.tpl"); ?>

    <h1><?php echo $heading_title; ?></h1>
    <!--MESSAGE-ACTION-->
     <section class="message-actions">
        <div class="heading feature-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-envelope fa-2x"></i>
                    <?php echo $Language->get('text_my_orders');?>
                </h3>
            </div>
        </div>
        <div class="content" data-content="messages"></div>
    </section>
    <!--/MESSAGE-ACTION-->

    <!--ACTIVITY-ACTION-->
    <section class="activity-actions">
        <div class="heading feature-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-user fa-2x"></i>
                    <?php echo $Language->get('text_recent_activities');?>
                </h3>
            </div>
        </div>
        <div class="content" data-content="activities"></div>
    </section>
    <!--/ACTIVITY-ACTION-->


    <!--ORDER-ACTION-->
    <section class="order-actions">
        <div class="heading feature-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-shopping-cart fa-2x"></i>
                    <?php echo $Language->get('text_latest_orders');?>
                </h3>
            </div>
        </div>
        <div class="content" data-content="orders"></div>
    </section>
    <!--/ORDER-ACTION-->

    <!--RECOMMENDED-ACTION-->
    <section class="recommended-actions">
        <div class="heading feature-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-star fa-2x"></i>
                    <?php echo $Language->get('text_recommendations');?>
                </h3>
            </div>
        </div>
        <div class="content" data-content="recommended"></div>
    </section>

    <!--/RECOMMENDED-ACTION-->
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>