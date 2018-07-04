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

    <div id="products">
        <?php if($products) { ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/sort.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-list.tpl"); ?>
        <?php } else { ?>
        <div class="content"><?php echo $Language->get('text_error'); ?></div>
        <?php } ?>
    </div>

    <?php $position = 'main'; ?>
    <?php foreach($rows[$position] as $j => $row) { ?>
    <div class="row" id="<?php echo $position; ?>_container_<?php echo $j; ?>" nt-editable>
        <?php foreach($row['columns'] as $k => $column) { ?>
        <div class="medium-<?php echo $column['column']; ?>" id="<?php echo $position; ?>_column_<?php echo $j ."_". $k; ?>" nt-editable>
            <ul class="widgets">
                <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget; ?>%} <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-footer-widgets.tpl");?>
    </section>


<?php echo $footer; ?>