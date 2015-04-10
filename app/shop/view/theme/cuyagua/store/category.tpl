<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <!-- breadcrumbs -->
        <div class="large-12 small-12 medium-12 columns">
            <ul id="breadcrumbs" class="breadcrumbs nt-editable">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                     <a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>">
                         <?php echo $breadcrumb['text']; ?>
                     </a>
                </li>
            <?php } ?>
            </ul>
        </div>
        <!-- /breadcrumbs -->

        <!-- breadcrumbs -->
        <div class="large-12 medium-12 small-12 columns">
            <div id="featuredContent" class="feature-content">
            <ul class="widgets"><?php if($featuredWidgets) { foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
            </div>
        </div>
        <!-- breadcrumbs -->


        <!-- columns left -->
        <?php if ($column_left) { ?>
            <aside id="column_left" class="column-left large-3 medium-12 small-12 columns">
                <?php echo $column_left; ?>
            </aside>
        <?php } ?>
        <!--/ columns-left-->

        <!-- columns-center -->
        <?php if ($column_left && $column_right) { ?>
            <div class="column-center large-6 medium-12 small-12 columns">
        <?php } elseif ($column_left || $column_right) { ?>
            <div class="column-center large-9 medium-12 small-12 columns">
        <?php } else { ?>
            <div class="column-center large-12 medium-12 small-12 columns">
        <?php } ?>

            <h1><?php echo $heading_title; ?></h1>
            <div class="category-description">
                <?php if ($description) { ?><p><?php echo $description; ?></p><?php } ?>
            </div>

            <?php if($categories) { ?>
            <nav class="content">
                <ul class="category_view">
                <?php foreach($categories as $category) { ?>
                    <li
                        <a class="thumb" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" /></a>
                        <a class="name" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
                    </li>
                <?php } ?>
                </ul>
            </nav>
            <?php } ?>

            <div id="products"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
            <?php if($widgets) { ?>
                 <ul class="widgets">
                     <?php foreach ($widgets as $widget) { ?>
                         {%<?php echo $widget; ?>%}
                     <?php } ?>
                 </ul>
             <?php } ?>

        </div>
        <!-- /column-center -->

        <!-- column-rigth -->
        <?php if ($column_right) { ?>
            <aside id="column_right" class="column-right large-3 medium-12 small-12 columns">
                <?php echo $column_right; ?>
            </aside>
        <?php } ?>
        <!-- /column-right -->
    </section>
<?php echo $footer; ?>