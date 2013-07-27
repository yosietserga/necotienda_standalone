<div class="container_16">
    <div id="bgNav" class="bgNav nt-editable">
        <nav id="nav" class="nt-editable">
            <div class="grid_16">
            <?php if (isset($links)) { echo $links; } else { ?>
                <ul>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("common/home")); ?>" title="<?php echo $Language->get('tab_home'); ?>"><?php echo $Language->get('tab_home'); ?></a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$Config->get('config_page_us_id')))); ?>" title="Nosotros"><?php echo $Language->get('tab_us'); ?></a></li>
                    <li>
                        <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("store/category/all")); ?>" title="<?php echo $Language->get('tab_categories'); ?>"><?php echo $Language->get('tab_categories'); ?></a>
                    </li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("store/product/all")); ?>" title="<?php echo $Language->get('tab_products'); ?>"><?php echo $Language->get('tab_products'); ?></a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("store/special")); ?>" title="<?php echo $Language->get('tab_specials'); ?>"><?php echo $Language->get('tab_specials'); ?></a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page/all")); ?>" title="<?php echo $Language->get('tab_pages'); ?>"><?php echo $Language->get('tab_pages'); ?></a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/category")); ?>" title="<?php echo $Language->get('tab_blog'); ?>"><?php echo $Language->get('tab_blog'); ?></a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("page/contact")); ?>" title="<?php echo $Language->get('tab_contact'); ?>"><?php echo $Language->get('tab_contact'); ?></a></li>
                </ul>
                <?php } ?>
            </div>
        </nav>
    </div>
</div>