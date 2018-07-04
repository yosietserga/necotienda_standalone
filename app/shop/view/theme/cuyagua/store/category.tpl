<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-heading.tpl");?>

    <?php if ($description && strlen($description) > 1) { ?>
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
                <a class="thumb" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" /></a>
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