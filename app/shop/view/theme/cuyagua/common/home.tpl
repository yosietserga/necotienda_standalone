<?php echo $header; ?>
<?php echo $navigation; ?>
<!-- main-section -->
<main class="main-section">
    <div class="row main-section__content">
        <section id="featuredContent">
            <ul class="main-widgets widgets large-12 medium-12 small-12 columns">
                <?php if($featuredWidgets) { foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?>
            </ul>
        </section>
    </div>
    <div class="row main-columns">
         <section id="content">
            <?php if ($column_left) { ?>
                <aside id="column_left" class="large-3 medium-12 small-12 columns">
                    <?php echo $column_left; ?></aside><?php } ?>

                    <?php if ($column_left && $column_right) { ?>
                        <div class="large-6 medium-12 small-12 columns">
                    <?php } elseif ($column_left || $column_right) { ?>
                        <div class="large-9 medium-12 small-12 columns">
                    <?php } else { ?>
                        <div class="large-12 medium-12 small-12 columns">
                    <?php } ?>

                    <?php if($widgets) { ?>
                        <ul class="columns-widgets widgets">
                        <?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            <?php if ($column_right) { ?><aside id="column_right" class="large-3 medium-12 small-12 columns"><?php echo $column_right; ?></aside><?php } ?>
        </section>
    </div>
</main>
<!-- /main-section -->
<?php echo $footer; ?>