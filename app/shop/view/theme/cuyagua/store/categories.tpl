<?php echo $header; ?>
<?php echo $navigation; ?>

<!-- section-categories -->
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

    <h1><?php echo $heading_title; ?></h1>
    <?php if($categories) { ?>
    <nav class="catalog catalog-grid catalog-break">
        <ul>
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
    <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<!-- /section-categories -->
<?php echo $footer; ?>