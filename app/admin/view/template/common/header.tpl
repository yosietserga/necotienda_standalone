<!DOCTYPE html><!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]--><!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]--><!--[if IE 8]><html class="no-js lt-ie9"> <![endif]--><!--[if gt IE 8]><!--><html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?></title>
    <?php if (!empty($keywords)) { ?><meta name="keywords" content="<?php echo $keywords; ?>"><?php } ?>
        
    <?php if (!empty($description)) { ?><meta name="description" content="<?php echo $description; ?>"><?php } ?>
        
    <base href="<?php echo $base; ?>">
    <?php if (!empty($icon)) { ?><link href="<?php echo $icon; ?>" rel="icon"><?php } ?>
        
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="image/mobile/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="image/mobile/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" href="image/mobile/apple-touch-icon.png" />
    <link rel="shortcut icon" href="image/apple-touch-icon.png" />
    <link rel="apple-touch-startup-image" media="(max-device-width: 480px) and not (-webkit-min-device-pixel-ratio: 2)" href="image/mobile/splash-320x460.png" />
    <link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="image/mobile/splash-640x920-retina.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (orientation: portrait)" href="image/mobile/splash-768x1004.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (orientation: landscape)" href="image/mobile/splash-1024x748.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 1536px) and (orientation: portrait)" href="image/mobile/splash-1536x2008-retina.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 2048px) and (orientation: landscape)" href="image/mobile/splash-2048x1496-retina.png" />
    
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="HandheldFriendly" content="true" />   
    <meta name="viewport" content="width=device-width; initial-scale=1.0">

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/text.css" />
    <link rel="stylesheet" href="css/screen.css" />
    <link rel="stylesheet" href="css/main.css">
    

    <script src="js/vendor/modernizr-2.6.1.min.js"></script>
    <script src="js/vendor/jquery.min-1.8.1.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.1.min.js"><\/script>')</script>
        
    <?php if (count($styles) > 0) foreach ($styles as $style) { ?>
    <link rel="stylesheet" type="text/css" media="<?php echo $style['media']; ?>" href="<?php echo $style['href']; ?>">
    <?php } ?>
        
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
        
    <?php if (!empty($javascripts) && is_array($javascripts)) foreach ($javascripts as $js) { ?>
    <script type="text/javascript" src="<?php echo $js; ?>"></script>
    <?php } ?>
</head>
<body>

    <div class="container_24">
    <?php if ($logged) { ?>
    
    <!-- Top navigation bar -->
    <div id="topNav">
        <div class="fixed">
            <div class="wrapper">
                <a id="logo" onclick="location = '<?php echo $home; ?>'"></a>
                <div class="userNav">
                    <ul>
                        <li class="dd"><img src="image/icons/topnav/register.png" alt="" /><span>Crear &darr;</span>
                            <ul class="menu_body">
                                <li><a href="<?php echo $create_product; ?>" title="Crear Producto">Producto</a></li>
                                <li><a href="<?php echo $create_page; ?>" title="Crear Producto">P&aacute;gina</a></li>
                                <li><a href="<?php echo $create_post; ?>" title="Crear Producto">Art&iacute;culo</a></li>
                                <li><a href="<?php echo $create_manufacturer; ?>" title="Crear Producto">Fabricante</a></li>
                                <li><a href="<?php echo $create_product_category; ?>" title="Crear Producto">Categor&iacute;a de Productos</a></li>
                                <li><a href="<?php echo $create_post_category; ?>" title="Crear Producto">Categor&iacute;a de Art&iacute;los</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $Url::createAdminUrl("sale/customer"); ?>" title="Clientes Nuevos"><img src="image/icons/topnav/profile.png" alt="Clientes Nuevos" /><span>Clientes</span><?php if ($new_customers) { ?><span class="numberTop"><?php echo (int)$new_customers; ?></span><?php } ?></a></li>
                        <li><a href="<?php echo $Url::createAdminUrl("sale/order"); ?>" title="Pedidos Nuevos"><img src="image/icons/topnav/cart.png" alt="Pedidos Nuevos" /><span>Pedidos</span><?php if ($new_orders) { ?><span class="numberTop"><?php echo (int)$new_orders; ?></span><?php } ?></a></li>
                        <!--
                        <li class="dd"><img src="image/icons/topnav/messages.png" alt="" /><span>Mensajes</span><span class="numberTop">8</span>
                            <ul class="menu_body">
                                <li><a href="#" title="" class="sAdd">Mensaje Nuevo</a></li>
                                <li><a href="#" title="" class="sInbox">Bandeja de Entrada</a></li>
                                <li><a href="#" title="" class="sOutbox">Mensaje Enviados</a></li>
                                <li><a href="#" title="" class="sTrash">Papelera</a></li>
                            </ul>
                        </li>
                        -->
                        <li><a href="<?php echo $Url::createAdminUrl("tool/task"); ?>" title="Tareas Programadas"><img src="image/icons/topnav/todo.png" alt="" /><span>Tareas</span></a></li>
                        <li class="dd"><img src="image/icons/topnav/bag.png" alt="" /><span>Tiendas &darr;</span>
                            <ul>
                                <?php foreach ($stores as $store) { ?>
                                <li><a href="<?php echo $store['url']; ?>" title="Ir a la tienda"><?php echo $store['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li><a href="<?php echo $Url::createAdminUrl("setting/setting"); ?>" title="Configuraci&oacute;n"><img src="image/icons/topnav/settings.png" alt="" /><span>Configuraci&oacute;n</span></a></li>
                        <li><a href="<?php echo $logout; ?>" title=""><img src="image/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
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
                        <li id="inicio" class="on" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/home.png" alt="Inicio" /><span><?php echo $tab_home; ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $text_home; ?>" href="<?php echo $home; ?>" accesskey="2">
                                        <img src="image/menu/inicio.png" alt="<?php echo $text_home; ?>" />
                                        <br /><span><?php echo $text_home; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $text_category; ?>" href="<?php echo $category; ?>">
                                        <img src="image/menu/category.png" alt="<?php echo $category; ?>" />
                                        <br /><span><?php echo $text_category; ?></span>
                                    </a>
                                    <a title="<?php echo $text_product; ?>" href="<?php echo $product; ?>">
                                        <img src="image/menu/product.png" />
                                        <br /><span><?php echo $text_product; ?></span>
                                    </a>
                                    <a title="<?php echo $text_manufacturer; ?>" href="<?php echo $manufacturer; ?>">
                                        <img src="image/menu/manufacture.png"  />
                                        <br /><span><?php echo $text_manufacturer; ?></span>
                                    </a>
                                    <a title="<?php echo $text_download; ?>" href="<?php echo $download; ?>">
                                        <img src="image/menu/download.png" />
                                        <br /><span><?php echo $text_download; ?></span>
                                    </a>
                                    <a title="<?php echo $text_review; ?>" href="<?php echo $review; ?>">
                                        <img src="image/menu/comment.png" />
                                        <br /><span><?php echo $text_review; ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="contenido" class="on" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/computer.png" alt="Inicio" /><span><?php echo $tab_content; ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $text_page; ?>" href="<?php echo $pages; ?>">
                                        <img src="image/menu/page.png" alt="<?php echo $text_page; ?>" />
                                        <br /><span><?php echo $text_page; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $text_post_category; ?>" href="<?php echo $post_category; ?>">
                                        <img src="image/menu/post-category.png" alt="<?php echo $text_post_category; ?>" />
                                        <br /><span><?php echo $text_post_category; ?></span>
                                    </a>
                                    <a title="<?php echo $text_post; ?>" href="<?php echo $post; ?>">
                                        <img src="image/menu/post.png" alt="<?php echo $text_post; ?>" />
                                        <br /><span><?php echo $text_post; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $text_menu; ?>" href="<?php echo $menu; ?>">
                                        <img src="image/menu/menu.png" alt="<?php echo $text_menu; ?>" />
                                        <br /><span><?php echo $text_menu; ?></span>
                                    </a>
                                    <a title="<?php echo $text_banner; ?>" href="<?php echo $banner; ?>">
                                        <img src="image/menu/banner.png" alt="<?php echo $text_banner; ?>" />
                                        <br /><span><?php echo $text_banner; ?></span>
                                    </a>
                                    <a title="<?php echo $text_form; ?>" href="<?php echo $form; ?>">
                                        <img src="image/menu/forms.png" alt="<?php echo $text_form; ?>" />
                                        <br /><span><?php echo $text_form; ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="admon" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/money.png" alt="Inicio" /><span><?php echo $tab_admon; ?></span></a>
                            <ul>
                                <li>
                                    <a title="<?php echo $text_report_sale; ?>" href="<?php echo $report_sale; ?>">
                                        <img src="image/menu/ventas.png" alt="<?php echo $text_order; ?>" />
                                        <br /><span><?php echo $text_report_sale; ?></span>
                                    </a>
                                    <a title="<?php echo $text_order; ?>" href="<?php echo $order; ?>">
                                        <img src="image/menu/order.png" alt="<?php echo $text_order; ?>" />
                                        <br /><span><?php echo $text_order; ?></span>
                                    </a>
                                    <a title="<?php echo $text_coupon; ?>" href="<?php echo $customer_coupon; ?>" >
                                        <img src="image/menu/coupon.png" alt="<?php echo $text_coupon; ?>" />
                                        <br /><span><?php echo $text_coupon; ?></span>
                                    </a>
                                </li>                
                                <li>
                                    <a title="<?php echo $text_customer; ?>" href="<?php echo $customer; ?>">
                                        <img src="image/menu/client.png" alt="<?php echo $text_customer; ?>" />
                                        <br /><span><?php echo $text_customer; ?></span>
                                    </a>
                                    <a title="<?php echo $text_customer_group; ?>" href="<?php echo $customer_group; ?>">
                                        <img src="image/menu/client_group.png" alt="<?php echo $text_customer_group; ?>" />
                                        <br /><span><?php echo $text_customer_group; ?></span>
                                    </a>
                                </li> 
                            </ul>
                        </li>
                        <li id="herramientas" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/dropbox.png" alt="Herramientas" /><span><?php echo $tab_tools; ?></span></a>
                            <ul>
                                <li>
                                    <a title="Respaldar" href="<?php echo $backup; ?>">
                                        <img src="image/menu/backup.png" alt="<?php echo $text_backup; ?>">
                                        <br /><span>Respaldar</span>
                                    </a>
                                    <a title="Restaurar" href="<?php echo $restore; ?>">
                                        <img src="image/menu/restore.png" alt="Restaurar" />
                                        <br /><span>Restaurar</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="<?php echo $text_module; ?>" href="<?php echo $module; ?>">
                                        <img src="image/menu/modulos.png" />
                                        <br /><span><?php echo $text_module; ?></span>
                                    </a>
                                    <a title="<?php echo $text_shipping; ?>" href="<?php echo $shipping; ?>">
                                        <img src="image/menu/shipping.png" />
                                        <br /><span><?php echo $text_shipping; ?></span>
                                    </a>
                                    <a title="<?php echo $text_payment; ?>" href="<?php echo $payment; ?>">
                                        <img src="image/menu/payment.png" />
                                        <br /><span><?php echo $text_payment; ?></span>
                                    </a>
                                    <a title="<?php echo $text_total; ?>" href="<?php echo $total; ?>">
                                        <img src="image/menu/total.png" />
                                        <br /><span><?php echo $text_total; ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="reportes" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/monitor.png" alt="Reportes" /><span><?php echo $tab_report; ?></span></a>
                            <ul>
                                <li>
                                    <a href="<?php echo $report_viewed; ?>" title="M&aacute;s Vistos">
                                        <img src="image/menu/p_mas_visto.png" alt="M&aacute;s Vistos">
                                        <br /><span>Productos</span>
                                    </a>
                                    <a title="Por Visitas" href="<?php echo $report_visited; ?>">
                                        <img src="image/menu/c_mas_visitas.png" alt="Con M&aacute;s Visitas">
                                        <br /><span>Clientes</span>
                                    </a>
                                    <a title="Por Pedidos" href="<?php echo $cupurchased; ?>">
                                        <img src="image/menu/c_mas_pedidos.png" alt="Con M&aacute;s Pedidos">
                                        <br /><span>Cat. Produuctos</span>
                                    </a>
                                    <a title="Por Pedidos" href="<?php echo $cupurchased; ?>">
                                        <img src="image/menu/c_mas_pedidos.png" alt="Con M&aacute;s Pedidos">
                                        <br /><span>Fabricantes</span>
                                    </a>
                                    <a title="Por Pedidos" href="<?php echo $cupurchased; ?>">
                                        <img src="image/menu/c_mas_pedidos.png" alt="Con M&aacute;s Pedidos">
                                        <br /><span>P&aacute;ginas</span>
                                    </a>
                                    <a title="Por Pedidos" href="<?php echo $cupurchased; ?>">
                                        <img src="image/menu/c_mas_pedidos.png" alt="Con M&aacute;s Pedidos">
                                        <br /><span>Art&iacute;culos</span>
                                    </a>
                                    <a title="Por Pedidos" href="<?php echo $cupurchased; ?>">
                                        <img src="image/menu/c_mas_pedidos.png" alt="Con M&aacute;s Pedidos">
                                        <br /><span>Cat. Art&iacute;culos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="mercadeo" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/megaphone.png" alt="Mercadeo" /><span><?php echo $tab_marketing; ?></span></a>
                            <ul>
                                <li>
                                    <a href="<?php echo $email_member; ?>">
                                        <img src="image/menu/contact.png" />
                                        <br /><span>Contactos</span>
                                    </a>
                                    <a href="<?php echo $email_lists; ?>" title="Crear una nueva lista de emails">
                                        <img src="image/menu/contact_list.png" />
                                        <br /><span>Listas de Contactos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $email_newsletter; ?>" title="Crear una nueva lista de emails">
                                        <img src="image/menu/mail.png" />
                                        <br /><span>Plantillas de Email</span>
                                    </a>
                                    <a href="<?php echo $email_campaign; ?>" title="Crear una nueva campa&ntilde;a">
                                        <img src="image/menu/send_mail.png" />
                                        <br /><span>Campa&ntilde;as</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="apariencia" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/bigBrush.png" alt="Apariencia" /><span><?php echo $tab_style; ?></span></a>
                            <ul>
                                <li>
                                    <a href="<?php echo $style_backgrounds; ?>" title="Crear una nueva lista de emails">
                                        <img src="image/menu/background.png" alt="Fondos" />
                                        <br /><span>Fondos</span>
                                    </a>
                                    <a href="<?php echo $style_fonts; ?>">
                                        <img src="image/menu/fonts.png" alt="Fuentes" />
                                        <br /><span>Fuentes</span>
                                    </a>
                                    <a href="<?php echo $style_links; ?>" title="Crear una nueva campa&ntilde;a">
                                        <img src="image/menu/enlaces.png" alt="Enlaces" />
                                        <br /><span>Enlaces</span>
                                    </a>
                                    <a href="<?php echo $style_borders; ?>" title="Crear una nueva campa&ntilde;a">
                                        <img src="image/menu/bordes.png" alt="Bordes" />
                                        <br /><span>Bordes</span>
                                    </a>
                                    <a href="<?php echo $style_buttons; ?>" title="Crear una nueva campa&ntilde;a">
                                        <img src="image/menu/botones.png" alt="Botones" />
                                        <br /><span>Botones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $style_layouts; ?>" title="Crear una nueva lista de emails">
                                        <img src="image/menu/templates.png" alt="Fondos" />
                                        <br /><span>Temas</span>
                                    </a>
                                    <a href="<?php echo $style_layouts; ?>" title="Crear una nueva lista de emails">
                                        <img src="image/menu/layouts.png" alt="Fondos" />
                                        <br /><span>Plantillas</span>
                                    </a>
                                    <a href="<?php echo $editor; ?>" title="Crear una nueva lista de emails">
                                        <img src="image/menu/editor.png" alt="Fondos" />
                                        <br /><span>Editor HTML</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="sistema" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/settings.png" alt="Sistema" /><span><?php echo $tab_system; ?></span></a>
                            <ul>
                                <li>
                                    <a href="<?php echo $setting; ?>" title="<?php echo $text_setting; ?>">
                                        <img src="image/menu/setting.png" />
                                        <br /><span><?php echo $text_setting; ?></span>
                                    </a>
                                    <a href="<?php echo $user; ?>" title="<?php echo $text_user; ?>">
                                        <img src="image/menu/user.png" />
                                        <br /><span><?php echo $text_user; ?></span>
                                    </a>
                                    <a href="<?php echo $user_group; ?>" title="<?php echo $text_user_group; ?>">
                                        <img src="image/menu/user_group.png" alt="<?php echo $text_user_group; ?>" />
                                        <br /><span><?php echo $text_user_group; ?></span>
                                    </a>
                                    <a href="<?php echo $language; ?>" title="<?php echo $text_language; ?>">
                                        <img src="image/menu/idioma.png" alt="<?php echo $text_language; ?>" />
                                        <br /><span><?php echo $text_language; ?></span>
                                    </a>
                                    <a href="<?php echo $currency; ?>" title="<?php echo $text_currency; ?>">
                                        <img src="image/menu/moneda.png" alt="<?php echo $text_currency; ?>" />
                                        <br /><span><?php echo $text_currency; ?></span>
                                    </a>
                                    <a href="<?php echo $order_status; ?>" title="<?php echo $text_order_status; ?>">
                                        <img src="image/menu/order_status.png" alt="<?php echo $text_order_status; ?>" />
                                        <br /><span><?php echo $text_order_status; ?></span>
                                    </a>
                                    <a href="<?php echo $stock_status; ?>" title="<?php echo $text_stock_status; ?>">
                                        <img src="image/menu/stock_status.png" alt="<?php echo $text_stock_status; ?>" />
                                        <br /><span><?php echo $text_stock_status; ?></span>
                                    </a>
                                    <a href="<?php echo $tax_class; ?>" title="<?php echo $text_tax_class; ?>">
                                        <img src="image/menu/iva.png" alt="<?php echo $text_tax_class; ?>" />
                                        <br /><span><?php echo $text_tax_class; ?></span>
                                    </a>
                                    <a href="<?php echo $geo_zone; ?>" title="<?php echo $text_geo_zone; ?>">
                                        <img src="image/menu/geo_zona.png" alt="<?php echo $text_geo_zone; ?>" />
                                        <br /><span><?php echo $text_geo_zone; ?></span>
                                    </a>
                                    <a href="<?php echo $weight_class; ?>" title="<?php echo $text_weight_class; ?>">
                                        <img src="image/menu/peso.png" alt="<?php echo $text_weight_class; ?>" />
                                        <br /><span><?php echo $text_weight_class; ?></span>
                                    </a>
                                    <a href="<?php echo $length_class; ?>" title="<?php echo $text_length_class; ?>">
                                        <img src="image/menu/metro.png" alt="<?php echo $text_length_class; ?>" />
                                        <br /><span><?php echo $text_length_class; ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="ayuda" onclick="menuOn(this);"><a class="itemenu"><img src="image/icons/middlenav/help.png" alt="Ayuda" /><span><?php echo $tab_help; ?></span></a>
                            <ul>
                                <li>
                                    <a>
                                        <img src="image/menu/guia_usuario.png" />
                                        <br /><span>Documentaci&oacute;n</span>
                                    </a>
                                    <a href="http://www.youtube.com/user/inecoyoad?feature=mhum" target='_blank'>
                                        <img src="image/menu/youtube.png" />
                                        <br /><span>Videos Tutoriales</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="http://inecoyoad.com/foro/" target='_blank'>
                                        <img src="image/menu/necotienda.png" />
                                        <br /><span>Foros</span>
                                    </a>
                                    <a href="http://www.webtino.com/" target='_blank'>
                                        <img src="image/menu/webtino.png" />
                                        <br /><span>Tienda</span>
                                    </a>
                                    <a href="http://www.necoyoad.com/" target='_blank'>
                                        <img src="image/menu/wordpress.png" />
                                        <br /><span>Blog</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="http://inecoyoad.com/index.php?page=customer/login" target='_blank'>
                                        <img src="image/menu/atencion.png" />
                                        <br /><span>Soporte</span>
                                    </a>
                                    <a>
                                        <img src="image/menu/acerca_de.png" />
                                        <br /><span>Acerca De</span>
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
    <?php if ($msg) { ?><div class="grid_24"><div class="message warning"><?php echo $msg; ?></div></div><?php } ?>
</div>
<div class="clear"></div>
<div class="container_24">