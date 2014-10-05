<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <!--<![endif]-->
<head>
    <meta charset="<?php echo ($Language->get('charset')) ? $Language->get('charset') : 'utf-8'; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title><?php echo $title; ?></title>
    
    <?php if (!empty($keywords)) { ?><meta name="keywords" content="<?php echo $keywords; ?>"><?php } ?>
        
    <?php if (!empty($description)) { ?><meta name="description" content="<?php echo $description; ?>"><?php } ?>
        
    <base href="<?php echo HTTP_HOME; ?>">
    
    <?php if (!empty($icon)) { ?><link href="<?php echo $icon; ?>" rel="icon"><?php } ?>
    
    <link href="http://www.necotienda.org/assets/images/data/favicon.png" rel="icon" />
    
    <meta name="HandheldFriendly" content="true" />   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <?php if ($css) { ?><style><?php echo $css; ?></style><?php } ?>
    
    <?php if (count($styles) > 0) { ?>
        <?php foreach ($styles as $style) { ?>
        <?php if (empty($style['href'])) continue; ?>
    <link rel="stylesheet" type="text/css" media="<?php echo $style['media']; ?>" href="<?php echo $style['href']; ?>" />
        <?php } ?>
    <?php } ?>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.1/modernizr.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>window.Modernizr || document.write('<script src="js/vendor/modernizr.js"><\/script>')</script>
    <script>window.$ || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
</head>
<body>

<?php if ($logged) { ?>
    
    <!-- Top navigation bar -->
    <div id="topNav">
        <div class="fixed">
            <div class="wrapper">
                <a id="simple-menu" href="#sidr" style="margin:5px 10px;float:left;"><i class="fa fa-bars fa-2x" style="color:#fff"></i></a>
                <a id="right-menu" href="#sidr-right" style="margin:5px 10px;float:right;"><i class="fa fa-bars fa-2x" style="color:#900"></i></a>
                
                <div class="userNav">
                    <ul>
                        <li class="hideOnMobile">
                            <a href="<?php echo $Url::createAdminUrl("setting/cache"); ?>" title="<?php echo $Language->get('text_delete_cache'); ?>">
                                <span><i class="fa fa-trash-o fa-2x"></i></span>
                                <span class="hideOnTablet"><?php echo $Language->get('text_delete_cache'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $Url::createAdminUrl("sale/order"); ?>" title="<?php echo $Language->get('text_orders'); ?>">
                                <span><i class="fa fa-bell fa-2x"></i></span>
                                <span class="numberTop">3</span>
                            </a>
                        </li>
                        <li class="dd hideOnMobile">
                            <span><i class="fa fa-comments fa-2x"></i></span>
                        </li>
                        <li class="dd hideOnMobile">
                            <span><i class="fa fa-shopping-cart fa-2x"></i></span>
                            <ul class="menu_body">
                                <li><a href="<?php echo HTTP_CATALOG; ?>" title="<?php echo $Language->get('text_main_store'); ?>" target="_blank"><?php echo $Language->get('text_main_store'); ?></a></li>
                                <?php foreach ($stores as $store) { ?>
                                <li><a href="<?php echo str_replace("www",$store['folder'],HTTP_CATALOG); ?>" target="_blank" title="Ir a la tienda"><?php echo $store['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="hideOnMobile">
                            <a href="<?php echo $Url::createAdminUrl("setting/setting"); ?>" title="<?php echo $Language->get('tab_help'); ?>">
                               <span><i class="fa fa-life-ring fa-2x"></i></span>
                            </a>
                        </li>
                        <li class="hideOnMobile">
                            <a href="<?php echo $Url::createAdminUrl("setting/setting"); ?>" title="<?php echo $Language->get('text_setting'); ?>">
                               <span><i class="fa fa-cog fa-2x"></i></span>
                            </a>
                        </li>
                        <li><a href="<?php echo $Url::createAdminUrl('common/logout'); ?>" title="<?php echo $Language->get('text_logout'); ?>">
                                <img src="image/icons/topnav/logout.png" alt="<?php echo $Language->get('text_logout'); ?>" />
                                <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('text_logout'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="fix"></div>
            </div>
        </div>
    </div>
    <?php } ?>tomer"); ?>" title="<?php echo $Language->get('text_customers'); ?>"><img src="image/icons/topnav/profile.png" alt="<?php echo $Language->get('text_customers'); ?>" />
                                <span><?php echo $Language->get('text_customers'); ?></span>
                                <?php if ($new_customers) { ?><span class="numberTop"><?php echo (int)$new_customers; ?></span><?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $Url::createAdminUrl("sale/order"); ?>" title="<?php echo $Language->get('text_orders'); ?>">
                                <img src="image/icons/topnav/cart.png" alt="<?php echo $Language->get('text_orders'); ?>" />
                                <span><?php echo $Language->get('text_orders'); ?></span>
                                <?php if ($new_orders) { ?><span class="numberTop"><?php echo (int)$new_orders; ?></span><?php } ?>
                            </a>
                        </li>
                        <!--
                        <li class="dd"><img src="image/icons/topnav/messages.png" alt="" /><span>Mensajes</span><span class="numberTop">8</span>
                            <ul class="menu_body">
                                <li><a href="#" title="" class="sAdd">Mensaje Nuevo</a></li>
                                <li><a href="#" title="" class="sInbox">Bandeja de Entrada</a></li>
                                <li><a href="#" title="" class="sOutbox">Mensaje Enviados</a></li>
                                <li><a href="#" title="" class="sTrash">Papelera</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $Url::createAdminUrl("tool/task"); ?>" title="Tareas Programadas"><img src="image/icons/topnav/todo.png" alt="" /><span>Tareas</span></a></li>
                        -->
                        <li class="dd">
                            <img src="image/icons/topnav/bag.png" alt="<?php echo $Language->get('text_stores'); ?>" />
                            <span><?php echo $Language->get('text_stores'); ?> &darr;</span>
                            <ul class="menu_body">
                                <li><a href="<?php echo HTTP_CATALOG; ?>" title="<?php echo $Language->get('text_main_store'); ?>" target="_blank"><?php echo $Language->get('text_main_store'); ?></a></li>
                                <?php foreach ($stores as $store) { ?>
                                <li><a href="<?php echo str_replace("www",$store['folder'],HTTP_CATALOG); ?>" target="_blank" title="Ir a la tienda"><?php echo $store['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li><a href="<?php echo $Url::createAdminUrl("setting/setting"); ?>" title="<?php echo $Language->get('text_setting'); ?>"><img src="image/icons/topnav/settings.png" alt="" /><span><?php echo $Language->get('text_setting'); ?></span></a></li>
                        <li class="BigScreen"><a onclick="if (BigScreen.enabled) { BigScreen.toggle(); } else { alert('No est\u00E1 habilitado esta opci\u00F3n en su navegador'); }"><img src="image/icons/color/arrow-in-out.png" alt="Full Screen" /></a></li>
                        <li><a href="<?php echo $Url::createAdminUrl('common/logout'); ?>" title="<?php echo $Language->get('text_logout'); ?>"><img src="image/icons/topnav/logout.png" alt="<?php echo $Language->get('text_logout'); ?>" /><span><?php echo $Language->get('text_logout'); ?></span></a></li>
                    </ul>
                </div>
                <div class="fix"></div>
            </div>
        </div>
    </div>

        <div id="menu_h">
            <ul class="ribbon">
                <li>
                    <ul class="menu">
                        <li id="inicio" class="on" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/home.png" alt="<?php echo $Language->get('tab_home'); ?>" /><span><?php echo $Language->get('tab_home'); ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $Language->get('text_home'); ?>" href="<?php echo $Url::createAdminUrl('common/home'); ?>" accesskey="2">
                                        <img src="image/menu/inicio.png" alt="<?php echo $Language->get('text_home'); ?>" />
                                        <br /><span><?php echo $Language->get('text_home'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $Language->get('text_category'); ?>" href="<?php echo $Url::createAdminUrl('store/category',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/category.png" alt="<?php echo $Language->get('text_category'); ?>" />
                                        <br /><span><?php echo $Language->get('text_category'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_product'); ?>" href="<?php echo $Url::createAdminUrl('store/product',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/product.png" />
                                        <br /><span><?php echo $Language->get('text_product'); ?></span>
                                    </a>
                                    <!--
                                    <a title="<?php echo $Language->get('text_attributes'); ?>" href="<?php echo $Url::createAdminUrl('store/attribute',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/attributes.png" alt="<?php echo $Language->get('text_attributes'); ?>" />
                                        <br /><span><?php echo $Language->get('text_attributes'); ?></span>
                                    </a>
                                    -->
                                    <a title="<?php echo $Language->get('text_manufacturer'); ?>" href="<?php echo $Url::createAdminUrl('store/manufacturer',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/manufacture.png"  />
                                        <br /><span><?php echo $Language->get('text_manufacturer'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_download'); ?>" href="<?php echo $Url::createAdminUrl('store/download',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/download.png" />
                                        <br /><span><?php echo $Language->get('text_download'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_review'); ?>" href="<?php echo $Url::createAdminUrl('store/review',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/comment.png" />
                                        <br /><span><?php echo $Language->get('text_review'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_shops'); ?>" href="<?php echo $Url::createAdminUrl('store/store',array('menu'=>'inicio')); ?>">
                                        <img src="image/menu/shop.png" />
                                        <br /><span><?php echo $Language->get('text_shops'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="contenido" class="on" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/computer.png" alt="Inicio" /><span><?php echo $Language->get('tab_content'); ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $Language->get('text_page'); ?>" href="<?php echo $Url::createAdminUrl('content/page',array('menu'=>'contenido')); ?>">
                                        <img src="image/menu/page.png" alt="<?php echo $Language->get('text_page'); ?>" />
                                        <br /><span><?php echo $Language->get('text_page'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $Language->get('text_post_category'); ?>" href="<?php echo $Url::createAdminUrl('content/post_category',array('menu'=>'contenido')); ?>">
                                        <img src="image/menu/post-category.png" alt="<?php echo $Language->get('text_post_category'); ?>" />
                                        <br /><span><?php echo $Language->get('text_post_category'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_post'); ?>" href="<?php echo $Url::createAdminUrl('content/post',array('menu'=>'contenido')); ?>">
                                        <img src="image/menu/post.png" alt="<?php echo $Language->get('text_post'); ?>" />
                                        <br /><span><?php echo $Language->get('text_post'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $Language->get('text_menu'); ?>" href="<?php echo $Url::createAdminUrl('content/menu',array('menu'=>'contenido')); ?>">
                                        <img src="image/menu/menu.png" alt="<?php echo $Language->get('text_menu'); ?>" />
                                        <br /><span><?php echo $Language->get('text_menu'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_banner'); ?>" href="<?php echo $Url::createAdminUrl('content/banner',array('menu'=>'contenido')); ?>">
                                        <img src="image/menu/banner.png" alt="<?php echo $Language->get('text_banner'); ?>" />
                                        <br /><span><?php echo $Language->get('text_banner'); ?></span>
                                    </a>
                                    <!--
                                    <a title="<?php echo $Language->get('text_form'); ?>" href="<?php echo $Url::createAdminUrl('content/form',array('menu'=>'contenido')); ?>">
                                        <img src="image/menu/forms.png" alt="<?php echo $Language->get('text_form'); ?>" />
                                        <br /><span><?php echo $Language->get('text_form'); ?></span>
                                    </a>
                                    -->                                
                                </li>
                            </ul>
                        </li>
                        <li id="admon" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/money.png" alt="Inicio" /><span><?php echo $Language->get('tab_admon'); ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $Language->get('text_report_sale'); ?>" href="<?php echo $Url::createAdminUrl('report/sale',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/ventas.png" alt="<?php echo $Language->get('text_order'); ?>" />
                                        <br /><span><?php echo $Language->get('text_report_sale'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_order'); ?>" href="<?php echo $Url::createAdminUrl('sale/order',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/order.png" alt="<?php echo $Language->get('text_order'); ?>" />
                                        <br /><span><?php echo $Language->get('text_order'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_payment'); ?>" href="<?php echo $Url::createAdminUrl('sale/payment',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/payment.png" alt="<?php echo $Language->get('text_payment'); ?>" />
                                        <br /><span><?php echo $Language->get('text_payment'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_coupon'); ?>" href="<?php echo $Url::createAdminUrl('sale/coupon',array('menu'=>'admon')); ?>" >
                                        <img src="image/menu/coupon.png" alt="<?php echo $Language->get('text_coupon'); ?>" />
                                        <br /><span><?php echo $Language->get('text_coupon'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $Language->get('text_customer'); ?>" href="<?php echo $Url::createAdminUrl('sale/customer',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/client.png" alt="<?php echo $Language->get('text_customer'); ?>" />
                                        <br /><span><?php echo $Language->get('text_customer'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_customer_group'); ?>" href="<?php echo $Url::createAdminUrl('sale/customergroup',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/client_group.png" alt="<?php echo $Language->get('text_customer_group'); ?>" />
                                        <br /><span><?php echo $Language->get('text_customer_group'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_balances'); ?>" href="<?php echo $Url::createAdminUrl('sale/balance',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/account_balances.png" alt="<?php echo $Language->get('text_balances'); ?>" />
                                        <br /><span><?php echo $Language->get('text_balances'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $Language->get('text_bank'); ?>" href="<?php echo $Url::createAdminUrl('sale/bank',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/bank.png" alt="<?php echo $Language->get('text_bank'); ?>" />
                                        <br /><span><?php echo $Language->get('text_bank'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_bank_account'); ?>" href="<?php echo $Url::createAdminUrl('sale/bank_account',array('menu'=>'admon')); ?>">
                                        <img src="image/menu/bank_account.png" alt="<?php echo $Language->get('text_bank_account'); ?>" />
                                        <br /><span><?php echo $Language->get('text_bank_account'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="herramientas" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/dropbox.png" alt="Herramientas" /><span><?php echo $Language->get('tab_tools'); ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $Language->get('text_backup'); ?>" href="<?php echo $Url::createAdminUrl('tool/backup',array('menu'=>'herramientas')); ?>">
                                        <img src="image/menu/backup.png" alt="<?php echo $Language->get('text_backup'); ?>">
                                        <br /><span><?php echo $Language->get('text_backup'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_restore'); ?>" href="<?php echo $Url::createAdminUrl('tool/backup',array('menu'=>'herramientas')); ?>">
                                        <img src="image/menu/restore.png" alt="<?php echo $Language->get('text_restore'); ?>" />
                                        <br /><span><?php echo $Language->get('text_restore'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $Language->get('text_module'); ?>" href="<?php echo $Url::createAdminUrl('extension/module',array('menu'=>'herramientas')); ?>">
                                        <img src="image/menu/modulos.png" />
                                        <br /><span><?php echo $Language->get('text_module'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_shipping'); ?>" href="<?php echo $Url::createAdminUrl('extension/shipping',array('menu'=>'herramientas')); ?>">
                                        <img src="image/menu/shipping.png" />
                                        <br /><span><?php echo $Language->get('text_shipping'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_payment'); ?>" href="<?php echo $Url::createAdminUrl('extension/payment',array('menu'=>'herramientas')); ?>">
                                        <img src="image/menu/payment.png" />
                                        <br /><span><?php echo $Language->get('text_payment'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_total'); ?>" href="<?php echo $Url::createAdminUrl('extension/total',array('menu'=>'herramientas')); ?>">
                                        <img src="image/menu/total.png" />
                                        <br /><span><?php echo $Language->get('text_total'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="reportes" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/monitor.png" alt="<?php echo $Language->get('tab_report'); ?>" /><span><?php echo $Language->get('tab_report'); ?></span></a>
                            <ul>
                                <li>
                                    <a href="<?php echo $Url::createAdminUrl('store/product/see',array('menu'=>'reportes')); ?>" title="<?php echo $Language->get('text_product'); ?>">
                                        <img src="image/menu/product-stats.png" alt="<?php echo $Language->get('text_product'); ?>">
                                        <br /><span><?php echo $Language->get('text_product'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_customer'); ?>" href="<?php echo $Url::createAdminUrl('report/visited',array('menu'=>'reportes')); ?>">
                                        <img src="image/menu/c_mas_visitas.png" alt="<?php echo $Language->get('text_customer'); ?>">
                                        <br /><span><?php echo $Language->get('text_customer'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('tab_category'); ?>" href="<?php echo $Url::createAdminUrl('store/category/see',array('menu'=>'reportes')); ?>">
                                        <img src="image/menu/category-stats.png" alt="<?php echo $Language->get('tab_category'); ?>">
                                        <br /><span><?php echo $Language->get('text_categories'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_manufacturer'); ?>" href="<?php echo $Url::createAdminUrl('store/manufacturer/see',array('menu'=>'reportes')); ?>">
                                        <img src="image/menu/manufacturer-stats.png" alt="<?php echo $Language->get('text_manufacturer'); ?>">
                                        <br /><span><?php echo $Language->get('text_manufacturer'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_page'); ?>" href="<?php echo $Url::createAdminUrl('content/page/see',array('menu'=>'reportes')); ?>">
                                        <img src="image/menu/page-stats.png" alt="<?php echo $Language->get('text_page'); ?>">
                                        <br /><span><?php echo $Language->get('text_page'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_post'); ?>" href="<?php echo $Url::createAdminUrl('content/post/see',array('menu'=>'reportes')); ?>">
                                        <img src="image/menu/post-stats.png" alt="<?php echo $Language->get('text_post'); ?>">
                                        <br /><span><?php echo $Language->get('text_post'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_post_category'); ?>" href="<?php echo $Url::createAdminUrl('content/post_category/see',array('menu'=>'reportes')); ?>">
                                        <img src="image/menu/post-category-stats.png" alt="<?php echo $Language->get('text_post_category'); ?>">
                                        <br /><span><?php echo $Language->get('text_post_category'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="mercadeo" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/megaphone.png" alt="Mercadeo" /><span><?php echo $Language->get('tab_marketing'); ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $Language->get('text_contacts'); ?>" href="<?php echo $Url::createAdminUrl('marketing/contact',array('menu'=>'mercadeo')); ?>">
                                        <img src="image/menu/contact.png" alt="<?php echo $Language->get('text_contacts'); ?>" />
                                        <br /><span><?php echo $Language->get('text_contacts'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl('marketing/list',array('menu'=>'mercadeo')); ?>" title="<?php echo $Language->get('text_contacts_lists'); ?>">
                                        <img src="image/menu/contact_list.png" alt="<?php echo $Language->get('text_contacts_lists'); ?>" />
                                        <br /><span><?php echo $Language->get('text_contacts_lists'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $Url::createAdminUrl('marketing/newsletter',array('menu'=>'mercadeo')); ?>" title="<?php echo $Language->get('text_newsletters'); ?>">
                                        <img src="image/menu/mail.png" alt="<?php echo $Language->get('text_newsletters'); ?>" />
                                        <br /><span><?php echo $Language->get('text_newsletters'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl('marketing/campaign',array('menu'=>'mercadeo')); ?>" title="<?php echo $Language->get('text_email_campaigns'); ?>">
                                        <img src="image/menu/send_mail.png" alt="<?php echo $Language->get('text_email_campaigns'); ?>" />
                                        <br /><span><?php echo $Language->get('text_email_campaigns'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("marketing/message",array('menu'=>'mercadeo')); ?>" title="<?php echo $Language->get('text_email_associations'); ?>">
                                        <img src="image/menu/asociations.png" alt="<?php echo $Language->get('text_email_associations'); ?>" />
                                        <br /><span><?php echo $Language->get('text_email_associations'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="apariencia" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/bigBrush.png" alt="Apariencia" /><span><?php echo $Language->get('tab_style'); ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $Language->get('text_views'); ?>" href="<?php echo Url::createAdminUrl("style/views"); ?>">
                                        <img src="image/menu/views.png" alt="<?php echo $Language->get('text_views'); ?>" />
                                        <br /><span><?php echo $Language->get('text_views'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_themes'); ?>" href="<?php echo Url::createAdminUrl("style/theme"); ?>">
                                        <img src="image/menu/theme.png" alt="<?php echo $Language->get('text_themes'); ?>" />
                                        <br /><span><?php echo $Language->get('text_themes'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_templates'); ?>" href="<?php echo $Url::createAdminUrl('style/layouts',array('menu'=>'apariencia')); ?>">
                                        <img src="image/menu/template.png" alt="<?php echo $Language->get('text_templates'); ?>" />
                                        <br /><span><?php echo $Language->get('text_templates'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_html_editor'); ?>" href="<?php echo $Url::createAdminUrl('style/editor',array('menu'=>'apariencia')); ?>">
                                        <img src="image/menu/editor.png" alt="<?php echo $Language->get('text_html_editor'); ?>" />
                                        <br /><span><?php echo $Language->get('text_html_editor'); ?></span>
                                    </a>
                                    <a title="<?php echo $Language->get('text_widgets'); ?>" href="<?php echo Url::createAdminUrl("style/widget"); ?>">
                                        <img src="image/menu/widgets.png" alt="<?php echo $Language->get('text_widgets'); ?>" />
                                        <br /><span><?php echo $Language->get('text_widgets'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="sistema" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/settings.png" alt="<?php echo $Language->get('text_system'); ?>" /><span><?php echo $Language->get('tab_system'); ?></span></a>
                            <ul>
                                <li>
                                    <a href="<?php echo $Url::createAdminUrl('setting/setting',array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_setting'); ?>">
                                        <img src="image/menu/setting.png" alt="<?php echo $Language->get('text_setting'); ?>" />
                                        <br /><span><?php echo $Language->get('text_setting'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl('user/user',array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_user'); ?>">
                                        <img src="image/menu/user.png" alt="<?php echo $Language->get('text_user'); ?>" />
                                        <br /><span><?php echo $Language->get('text_user'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl('user/user_permission',array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_user_group'); ?>">
                                        <img src="image/menu/user_group.png" alt="<?php echo $Language->get('text_user_group'); ?>" />
                                        <br /><span><?php echo $Language->get('text_user_group'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("localisation/language",array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_language'); ?>">
                                        <img src="image/menu/idioma.png" alt="<?php echo $Language->get('text_language'); ?>" />
                                        <br /><span><?php echo $Language->get('text_language'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("localisation/currency",array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_currency'); ?>">
                                        <img src="image/menu/moneda.png" alt="<?php echo $Language->get('text_currency'); ?>" />
                                        <br /><span><?php echo $Language->get('text_currency'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl('localisation/order_status',array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_order_status'); ?>">
                                        <img src="image/menu/order_status.png" alt="<?php echo $Language->get('text_order_status'); ?>" />
                                        <br /><span><?php echo $Language->get('text_order_status'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl('localisation/stock_status',array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_stock_status'); ?>">
                                        <img src="image/menu/stock_status.png" alt="<?php echo $Language->get('text_stock_status'); ?>" />
                                        <br /><span><?php echo $Language->get('text_stock_status'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("localisation/tax_class",array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_tax_class'); ?>">
                                        <img src="image/menu/iva.png" alt="<?php echo $Language->get('text_tax_class'); ?>" />
                                        <br /><span><?php echo $Language->get('text_tax_class'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("localisation/geo_zone",array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_geo_zone'); ?>">
                                        <img src="image/menu/geo_zona.png" alt="<?php echo $Language->get('text_geo_zone'); ?>" />
                                        <br /><span><?php echo $Language->get('text_geo_zone'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("localisation/weight_class",array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_weight_class'); ?>">
                                        <img src="image/menu/peso.png" alt="<?php echo $Language->get('text_weight_class'); ?>" />
                                        <br /><span><?php echo $Language->get('text_weight_class'); ?></span>
                                    </a>
                                    <a href="<?php echo $Url::createAdminUrl("localisation/length_class",array('menu'=>'sistema')); ?>" title="<?php echo $Language->get('text_length_class'); ?>">
                                        <img src="image/menu/metro.png" alt="<?php echo $Language->get('text_length_class'); ?>" />
                                        <br /><span><?php echo $Language->get('text_length_class'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="ayuda" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/help.png" alt="<?php echo $Language->get('text_help'); ?>" /><span><?php echo $Language->get('tab_help'); ?></span></a>
                            <ul>
                                <li>
                                    <a href="http://docs.necotienda.com/" title="<?php echo $Language->get('text_documentation'); ?>">
                                        <img src="image/menu/guia_usuario.png" alt="<?php echo $Language->get('text_documentation'); ?>" />
                                        <br /><span><?php echo $Language->get('text_documentation'); ?></span>
                                    </a>
                                    <a href="http://www.youtube.com/user/necotienda" title="<?php echo $Language->get('text_video_tutorials'); ?>" target='_blank'>
                                        <img src="image/menu/youtube.png" alt="<?php echo $Language->get('text_video_tutorials'); ?>" />
                                        <br /><span><?php echo $Language->get('text_video_tutorials'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="http://forum.necotienda.com/" title="<?php echo $Language->get('text_forum'); ?>" target='_blank'>
                                        <img src="image/menu/necotienda.png" alt="<?php echo $Language->get('text_forum'); ?>" />
                                        <br /><span><?php echo $Language->get('text_forum'); ?></span>
                                    </a>
                                    <a href="http://apps.necotienda.com/" title="<?php echo $Language->get('text_apps_store'); ?>" target='_blank'>
                                        <img src="image/menu/webtino.png" alt="<?php echo $Language->get('text_apps_store'); ?>" />
                                        <br /><span><?php echo $Language->get('text_apps_store'); ?></span>
                                    </a>
                                    <a href="http://blog.necotienda.com/" title="<?php echo $Language->get('text_blog'); ?>" target='_blank'>
                                        <img src="image/menu/wordpress.png" alt="<?php echo $Language->get('text_blog'); ?>" />
                                        <br /><span><?php echo $Language->get('text_blog'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="http://www.necotienda.com/support/" title="<?php echo $Language->get('text_support'); ?>" target='_blank'>
                                        <img src="image/menu/atencion.png" alt="<?php echo $Language->get('text_support'); ?>" />
                                        <br /><span><?php echo $Language->get('text_support'); ?></span>
                                    </a>
                                    <a>
                                        <img src="image/menu/acerca_de.png" alt="<?php echo $Language->get('text_support'); ?>" />
                                        <br /><span><?php echo $Language->get('text_about'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <?php if ($breadcrumbs) { ?>
    <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
    </ul>
    <?php } ?>
    <?php if ($success) { ?><div class="grid_24"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
    <?php if ($msg) { ?><div class="grid_24"><div class="message warning"><?php echo $msg; ?></div></div><?php } ?>
    <?php if ($error) { ?><div class="grid_24"><div class="message error"><?php echo $error; ?></div></div><?php } ?>
</div>
<div class="clear"></div>
<div class="container_24">