<!-- Featured Footer -->
<?php if (count($widgetsBeforeFooter) !== 0) { ?>
   <section id="footerWidgets" class="widgets featured featured-footer home-grid-full">
      <div class="row">
         <div class="columns">
            <ul>
               <?php if($widgetsBeforeFooter) { foreach ($widgetsBeforeFooter as $widget) { ?>
                  {%<?php echo $widget; ?>%}
               <?php } } ?>
            </ul>
         </div>
      </div>
   </section>
<?php } ?>
<!-- Featured Footer -->

<!-- footer underbottom -->
<?php if (count($widgets) !== 0) { ?>
    <footer class="underbottom">
        <section class="row">
            <ul class="underbottom-widgets widgets">
                <?php if ($widgets) {
                    foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}
                <?php } } ?>
            </ul>
        </section>
    </footer>
<?php } ?>
<!-- footer underbottom -->
<!-- terms -->
<section class="terms">
    <div class="row">
        <div class="medium-7 column credits">
            <em><?php echo $text_powered_by; ?></em>
        </div>
    </div>
</section>
<!-- /terms -->
</div>
<!--/footer underbottom-->
<?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/fragment/footer-start.tpl"); ?>

</body>
</html>