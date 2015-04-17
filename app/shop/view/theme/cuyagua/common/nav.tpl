
<div class="content">

<!-- main-header -->
<header class="main-header">
    <div class="row">
        <div id="site-logo" class="logo nt-editable large-4 columns">
             <?php if ($Config->get('config_logo')) { ?>
                <a title="<?php echo $store; ?>" href="<?php echo $Url::createUrl("common/home"); ?>"><img src="<?php echo HTTP_IMAGE. $Config->get('config_logo'); ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
            <?php } else { ?>
                <a title="<?php echo $store; ?>" href="<?php echo $Url::createUrl("common/home"); ?>"><?php echo $text_store; ?></a>
            <?php } ?>
        </div>
        <nav id ="leftOffCanvas" class="nav large-8 columns">
            <div class="nav-list row collapse">
                <?php if (!empty($links)) { ?>
                    <div class="nav-links custom-links large-10 columns">
                        <?php echo $links; ?>
                    </div>
                <?php } ?>

                <?php if (empty($links)) { ?>
                    <div class="nav-links default-links large-2 columns">
                        <ul>
                            <li>
                                <a href="javascript:;" class="main-nav-trigger">
                                    <i class="icon icon-menu">
                                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/menu.tpl"); ?> 
                                    </i>
                                </a>
                                
                                <ul>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$Config->get('config_page_us_id')))); ?>" title="Saber Más"><?php echo $Language->get('tab_us'); ?></a></li>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("store/category/all")); ?>" title="<?php echo $Language->get('tab_categories'); ?>"><?php echo $Language->get('tab_categories'); ?></a>
                                    </li>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("store/product/all")); ?>" title="<?php echo $Language->get('tab_products'); ?>"><?php echo $Language->get('tab_products'); ?></a>
                                    </li>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("store/special")); ?>" title="<?php echo $Language->get('tab_specials'); ?>"><?php echo $Language->get('tab_specials'); ?></a>
                                    </li>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page/all")); ?>" title="<?php echo $Language->get('tab_pages'); ?>"><?php echo $Language->get('tab_pages'); ?></a>
                                    </li>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/category")); ?>" title="<?php echo $Language->get('tab_blog'); ?>"><?php echo $Language->get('tab_blog'); ?></a>
                                    </li>
                                    <li>
                                        <a class="link" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("page/contact")); ?>" title="<?php echo $Language->get('tab_contact'); ?>"><?php echo $Language->get('tab_contact'); ?></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </nav>
    </div>
</header>
<!--main-header-->
