
<?php if ($column_left && $column_right) { ?>
    <section id="content" class="home-grid-small">
<?php } else if ($column_left || $column_right) { ?>
    <section id="content" class="home-grid-medium">
<?php } else { ?>
    <section id="content" class="home-grid-full">
<?php } ?>

<!-- columns-left -->
<?php if ($column_left) { ?>
    <aside class="column-left large-3 medium-3 small-12">
        <div id="columnLeft" class="widgets aside-column">
            <?php echo $column_left; ?>
        </div>
    </aside>
<?php } ?>
<!-- /column-left -->

<!-- columns-center -->
<?php if ($column_left && $column_right) { ?>
    <aside class="column-center large-6 column home-grid-small">
        <div class="widgets center-column">
<?php } elseif ($column_left || $column_right) { ?>
    <aside class="column-center large-9 column home-grid-medium">
        <div class="widgets center-column">
<?php } else { ?>
    <aside class="column-center column home-grid-full">
       <div class="widgets center-column">
<?php } ?>
