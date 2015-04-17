<?php echo $header; ?>
<?php echo $navigation; ?>
<!-- main-section -->
<main class="main-section">
    <div class="row">
        <section id="featuredContent">
            <ul class="main-widgets widgets large-12 medium-12 small-12 columns">
                <?php if($featuredWidgets) { foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?>
            </ul>
        </section>
    </div>

    <div class="row main-columns">
            <?php if ($column_left && $column_right) { ?>
            <section id="content" class="home-grid-small">
            <?php } else if ($column_left || $column_right) { ?>
                <section id="content" class="home-grid-medium">
            <?php } else { ?>
                <section id="content" class="home-grid-full">
            <?php } ?>

             <!-- left-column -->
            <?php if ($column_left) { ?>
                <aside id="column_left" class="aside-column large-3 medium-12 small-12 columns">
                        <?php echo $column_left; ?>
                </aside>
            <?php } ?>
             <!--/left-column -->

            <!-- center-column -->

            <?php if ($column_left && $column_right) { ?>

                <div id="column_center" class="center-column large-6 medium-12 small-12 columns">

            <?php } else if ($column_left || $column_right) { ?>

                <div id="column_center" class="center-column large-9 medium-12 small-12 columns">

            <?php } else { ?>

                <div id="column_center" class="center-column large-12 medium-12 small-12 columns">

            <?php } ?>

                <?php if($widgets) { ?>
                    <ul class="columns-widgets widgets">
                    <?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?>
                    </ul>
                <?php } ?>

                </div>
            <!--/center-column -->

            <!-- right-column -->

            <?php if ($column_right) { ?><aside id="column_right" class="aside-column large-3 medium-12 small-12 columns"><?php echo $column_right; ?></aside><?php } ?>
            <!--/right-column -->
        </section>
    </div>
</main>
<!-- /main-section -->
<?php echo $footer; ?>