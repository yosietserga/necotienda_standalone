<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <!--MESSAGE-ACTION-->
     <section class="message-actions">
        <div class="heading feature-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3> 
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
                    <?php echo $Language->get('text_recommendations');?>
                </h3>
            </div>
        </div>
        <div class="content" data-content="recommended"></div>
    </section>

    <!--/RECOMMENDED-ACTION-->
    
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>