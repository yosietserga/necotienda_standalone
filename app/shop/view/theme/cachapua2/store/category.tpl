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


        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

            <h1><?php echo $heading_title; ?></h1>
            <?php if ($description && strlen($description) > 10) { ?>
                <div class="category-description">
                    <p><?php echo $description; ?></p>
                </div>
            <?php } ?>

            <?php if($categories) { ?>
            <nav class="catalog catalog-grid catalog-break">
                <ul class="category-view">
                <?php foreach($categories as $category) { ?>
                    <li>
                        <figure class="picture">
                        <a class="thumb" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" /></a><br />
                        </figure>
                        <div class="info">
                            <a class="name" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
                        </div>
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

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    </section>
<?php echo $footer; ?>