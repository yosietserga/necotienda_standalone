<div class="content">
    <nav id="leftOffCanvas" class="main-nav large-12 columns">
      <div class="nav-links">
        <?php if (!empty($links)) { ?>
        <?php echo $links; ?> 
        <?php } else { ?> 
        <ul> 
          <li>
            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl('content/page',array('page_id'=>$Config->get('config_page_us_id')))); ?>" title="Saber Más">
              <?php echo $Language->get('tab_us'); ?>
            </a>
          </li>
          <li>
            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl('store/product/all')); ?>" title="<?php echo $Language->get('tab_products'); ?>">
              <?php echo $Language->get('tab_products'); ?>
            </a>
          </li>
          <li>
            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl('store/special')); ?>" title="<?php echo $Language->get('tab_specials'); ?>">
              <?php echo $Language->get('tab_specials'); ?>
            </a>
          </li>
          <li>
            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl('content/page/all')); ?>" title="<?php echo $Language->get('tab_pages'); ?>">
              <?php echo $Language->get('tab_pages'); ?>
            </a>
          </li>
          <li>
            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl('content/category')); ?>" title="<?php echo $Language->get('tab_blog'); ?>">
              <?php echo $Language->get('tab_blog'); ?>
            </a>
          </li>
          <li>
            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl('page/contact')); ?>" title="<?php echo $Language->get('tab_contact'); ?>">
              <?php echo $Language->get('tab_contact'); ?>
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </nav>
<script>
  (function () {
    var $nav;
    window.deferjQuery(function () {
      $nav = $("#leftOffCanvas");
      $nav.find("li > ul").parent().addClass("nested");
    });
    if (window.matchMedia("only screen and (max-width: 64em)").matches) {
      window.deferjQuery(function () {
        window.appendScriptSource("<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/mmenu/jquery.mmenu.oncanvas.js';?>");
      });
      window.deferPlugin('mmenu', function () {
        $nav.mmenu({
          navbar: {
            title	: "<?php echo $this->config->get("config_name") ?>",
          },
          navbars: true,
        }
        );
      });
    }
  })();
</script>
<!--main-header-->
