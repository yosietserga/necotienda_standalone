<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent" class="row">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>

        <!--FEATURE-CONTENT-WIDGETS-->
        <div class="feature-content large-12 small-12 medium-12 columns">
            <div id="featuredContent">
                <ul class="widgets"><?php if($featuredWidgets) {
                    foreach ($featuredWidgets as $widget) { ?>
                        {%<?php echo $widget; ?>%}<?php }
                    } ?>
                </ul>
            </div>
        </div>
        <!--/FEATURE-CONTENT-WIDGETS-->

        <!--COLUMN LEFT-->
        <?php if ($column_left) { ?>
            <aside id="column_left" class="aside-column column-left large-3 medium-12 small-12 columns">
                <?php echo $column_left; ?>
            </aside>
        <?php } ?>
        <!--/COLUMN LEFT-->

        <!--COLUMN-CENTER-->
        <?php if ($column_left && $column_right) { ?>
            <div class="column-center large-6 medium-12 small-12 columns">
        <?php } elseif ($column_left || $column_right) { ?>
            <div class="column-center large-9 medium-12 small-12 columns">
        <?php } else { ?>
            <div class="column-center large-12 medium-12 small-12 columns">
        <?php } ?>

                <h1 class="error-heading"><?php echo $heading_title; ?></h1>
                <span class="error-content"><?php echo $text_error; ?></span>
                <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            </div>
        <!--column right-->
        <?php if ($column_right) { ?>
            <aside id="column_right" class="aside-column column-right large-3 medium-12 small-12 columns">
                <?php echo $column_right; ?>
            </aside>
        <?php } ?>
        <!--column right-->
    </section>
</div>
<?php echo $footer; ?>