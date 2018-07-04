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

<?php if ($this->request->get['r']) { ?> 
  <?php if ($this->request->get['r'] !== "common/home") { ?> 
    <body> 
  <?php } else { ?> 
    <body data-section="home" class="home-page"> 
  <?php } ?> 
<?php } else { ?>
    <body data-section="home" class="home-page"> 
<?php } ?>

<div id="page" class="overheader">
    <!-- overheader-actions --> 
    <section id="overheader" class="row nt-editable">
      <div class="m-nav small-1 columns o-mobile-nav">
         <a class="hamburger o-mobile-nav__toggle" href="#leftOffCanvas">
            <span></span>
         </a>
      </div>
      <div itemscope itemtype="http://schema.org/LocalBusiness" class="phone large-2 medium-2 small-2 columns title-area c-topbar__item">
         <a itemprop="telephone c-topbar__item__action" class="tel" data-action="call">
               <i class="icon overheader-icon icon-phone">
                  <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/phone.tpl"); ?>
               </i>
               <small><?php echo $Config->get('config_telephone'); ?></small>
         </a>
      </div> 
      <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/common/overheader/search-input.tpl"); ?>
      <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/common/overheader/site-configuration.tpl"); ?>
      <!-- /location-actions -->
    </section>
</div>


<!-- main-header -->
<header class="main-header">
    <section class="row">
        <aside class="logo nt-editable">
            <?php if ($Config->get('config_logo')) { ?>
            <a title="<?php echo $store; ?>" href="<?php echo $Url::createUrl('common/home'); ?>">
               <img src="<?php echo HTTP_IMAGE. $Config->get('config_logo'); ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" />
            </a>
            <?php } else { ?>
            <a class="text-store" title="<?php echo $store; ?>" href="<?php echo $Url::createUrl("common/home"); ?>">
               <?php echo $text_store; ?>
            </a>
            <?php } ?>
        </aside>
    </section>
    
    
    <!-- Featured Header --> 
    <?php if($widgets && count($widgets) !== 0) { ?> 
       <div id="headerWidgets" class="widgets featured featured-header home-grid-full">
          <section class="row">
             <div class="column">
                <ul>
                   <?php if($widgets) { foreach ($widgets as $widget) { ?>
                      {%<?php echo $widget; ?>%}
                   <?php } } ?>
                </ul>
             </div>
          </section>
       </div> 
    <?php } ?> 
    <!-- Featured Header -->
</header>


