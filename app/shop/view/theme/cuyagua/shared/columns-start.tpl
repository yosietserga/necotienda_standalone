<?php if ($column_left && $column_right) { ?>
    <section id="content" class="home-grid-small">
<?php } else if ($column_left || $column_right) { ?>
    <section id="content" class="home-grid-medium">
<?php } else { ?>
<section id="content" class="home-grid-full">
<?php } ?>

<!-- columns-left -->
<?php if ($column_left) { ?>
    <aside id="column_left" class="aside-column column-left large-3 medium-12 small-12 columns">
        <?php echo $column_left; ?>
    </aside>
<?php } ?>
<!-- /column-left -->

<!-- columns-center -->
<?php if ($column_left && $column_right) { ?>
    <div class="column-center large-6 medium-12 small-12 columns">
<?php } elseif ($column_left || $column_right) { ?>
    <div class="column-center large-9 medium-12 small-12 columns">
<?php } else { ?>
    <div class="column-center large-12 medium-12 small-12 columns">
<?php } ?>