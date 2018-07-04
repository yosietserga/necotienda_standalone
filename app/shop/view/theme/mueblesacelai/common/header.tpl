<!doctype html>
<head<?php if (isset($headAttributes)) { echo $headAttributes; } ?>>

    <?php if (isset($opengraph)) {
    foreach ($opengraph as $k=>$v) {
        if (empty($v)) continue; ?>
    <meta property="<?php echo $k; ?>" content="<?php echo $v; ?>" />
    <?php } } ?>

    <meta charset="UTF-8" />
    <title><?php echo $title; ?></title>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>

    <meta name="author" content="Necoyoad">

    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($icon) { ?>
        <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>

    <?php if (count($styles) > 0) {
    foreach ($styles as $style) {
    if (empty($style['href'])) continue; ?>
    <link href="<?php echo $style['href']; ?>" rel='stylesheet' type='text/css' media="<?php echo $style['media']; ?>">
    <?php } } ?>

    <?php if ($css) { ?><style><?php echo $css; ?></style><?php } ?>

    <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/fragment/header-start.tpl"); ?>
</head>

<body>

<!--mainContainer -->
<div id="mainContainer" nt-editable><!--opening tag for <div id="mainContainer"> in footer.tpl-->

    <!--headerContainer -->
    <div id="headerContainer" nt-editable>

        <!--overheader -->
        <div id="overheader" nt-editable>
            <?php $position = 'overheader'; ?>
            <?php foreach($rows[$position] as $j => $row) { ?>
            <div class="row" id="<?php echo $position; ?>_container_<?php echo $j; ?>">
                <?php foreach($row['columns'] as $k => $column) { ?>
                <div class="medium-<?php echo $column['column']; ?>" id="<?php echo $position; ?>_column_<?php echo $j ."_". $k; ?>">
                    <ul class="widgets">
                        <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget; ?>%} <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <!--overheader -->

        <!--header -->
        <div id="header" nt-editable>
        <?php $position = 'header'; ?>
        <?php foreach($rows[$position] as $j => $row) { ?>
                <?php if (!$row['key']) continue; ?>
                <?php $row_id = $row['key']; ?>
                <?php $row_settings = unserialize($row['value']); ?>
                <div class="row" id="<?php echo $position; ?>_<?php echo $row_id; ?>">
                <?php foreach($row['columns'] as $k => $column) { ?>
                    <?php if (!$column['key']) continue; ?>
                    <?php $column_id = $column['key']; ?>
                    <?php $column_settings = unserialize($column['value']); ?>
                    <div class="large-<?php echo $column_settings['grid_large']; ?> medium-<?php echo $column_settings['grid_medium']; ?> small-<?php echo $column_settings['grid_small']; ?>" id="<?php echo $position; ?>_<?php echo $column_id; ?>">
                        <ul class="widgets">
                            <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget['name']; ?>%} <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                </div>
        <?php } ?>
        </div>
        <!--/header -->

    <!--/headerContainer -->
    </div>
