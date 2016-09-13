<?php echo $header; ?>
<?php echo $navigation; ?>
<!-- main-section -->
<main class="main-section">
   <?php if($featuredWidgets && count($featuredWidgets) !== 0) { ?>
      <section class="row">
         <div class="columns">
            <div id="featuredContent" class="widgets featured home-grid-full">
               <ul>
                  <?php if($featuredWidgets) { foreach ($featuredWidgets as $widget) { ?>
                        {%<?php echo $widget; ?>%}<?php
                  }} ?>
               </ul>
            </div>
         </div>
    </section>
   <?php } ?>

   <?php if (count($widgets) !== 0) { ?>
        <div class="row main-columns">
            <section id="content">
                 <!-- left-column -->
                <?php if ($column_left) { ?>
                    <aside id="columnLeft" class="large-3 columns">
                        <div class="widgets aside-column">
                            <?php echo $column_left; ?>
                        </div>
                    </aside>
                <?php } ?>
                <!--/left-column -->

                <!-- center-column -->

                <?php if ($column_left && $column_right) { ?>

                    <aside id="columnCenter" class="large-6 columns">
                        <div class="widgets center-column home-grid-small">
                <?php } else if ($column_left || $column_right) { ?>

                    <aside id="columnCenter" class="large-9 columns">
                        <div class="widgets center-column home-grid-medium">
                <?php } else { ?>
                    <aside id="columnCenter" class="columns">
                        <div class="widgets center-column home-grid-medium">
                <?php } ?>
                        <?php if($widgets) { ?>
                            <ul class="columns-widgets widgets">
                            <?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </aside>
                <!--/center-column -->

                <!-- right-column -->

                <?php if ($column_right) { ?>
                    <aside id="columnRight" class="large-3 columns">
                        <div class="widgets aside-column">
                            <?php echo $column_right; ?>
                        </div>
                    </aside>
                <?php } ?>
                <!--/right-column -->
            </section>
        </div>
   <?php } ?>
</main>
<!-- /main-section -->
<?php echo $footer; ?>