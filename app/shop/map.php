<?php
$loader->auto('url');
$loader->auto('user');
$loader->auto('customer');
$loader->auto('currency');
$loader->auto('tax');
$loader->auto('weight');
$loader->auto('length');
$loader->auto('cart');
$loader->auto('validar');
$loader->auto('encoder');
$loader->auto('browser');
$loader->auto('tracker');

$registry->set('load', $loader);
$registry->set('config', $config);
$registry->set('db', $db);
$registry->set('log', $log);
$registry->set('request', $request);
$registry->set('response', $response);
$registry->set('session', $session);
$registry->set('cache', new Cache());
$registry->set('document', new Document());
$registry->set('language', $language);
$registry->set('user', new User($registry));
$registry->set('api', new Api($registry));

$customer = new Customer($registry);

// App Libs
$registry->set('customer', $customer);
$registry->set('currency', new Currency($registry));
$registry->set('tax', new Tax($registry));
$registry->set('weight', new Weight($registry));
$registry->set('length', new Length($registry));
$registry->set('cart', new Cart($registry));
$registry->set('browser', new Browser);
$registry->set('tracker', new Tracker($registry));
$registry->set('javascripts', array());
$registry->set('styles', array());
$registry->set('scripts', array());


if ($request->hasQuery('refby')) {
    $customer->setRefByCustomer($request->getQuery('refby'));
}

if ($request->hasQuery('ref')) {
    $customer->setRefCustomer($request->getQuery('ref'));
};

// for background color when it resizes images
(!defined('IMAGE_BG_COLOR_R') && $config->get('config_image_bg_color_r')) ?
    define('IMAGE_BG_COLOR_R', $config->get('config_image_bg_color_r')) : define('IMAGE_BG_COLOR_R', 255);
(!defined('IMAGE_BG_COLOR_G') && $config->get('config_image_bg_color_g')) ?
    define('IMAGE_BG_COLOR_G', $config->get('config_image_bg_color_g')) : define('IMAGE_BG_COLOR_G', 255);
(!defined('IMAGE_BG_COLOR_B') && $config->get('config_image_bg_color_b')) ?
    define('IMAGE_BG_COLOR_B', $config->get('config_image_bg_color_b')) : define('IMAGE_BG_COLOR_B', 255);

// Default
$language->load('common/header');

$loader->auto('account/customer');
$loader->auto('store/product');
$loader->auto('store/category');
//TODO: redise�ar clase de URLs
$loader->auto('localisation/language');
$loader->auto('localisation/currency');

$registry->set('validar', new Validar());

$route = $request->hasQuery('_r_') ? strtolower($request->getQuery('_r_')) : strtolower($request->getQuery('r'));
// Currency code
if (!empty($_GET['cc'])) {
    $config->set('config_currency', $_GET['cc']);
}

$tpl = $config->get('config_template') ? $config->get('config_template') : 'cuyagua';

$header_javascripts = $javascripts = $styles = $scripts = array();

$jsSharedPath = ($config->get('config_render_js_in_file')) ? DIR_JS : HTTP_JS;
$jsPath = ($config->get('config_render_js_in_file')) ? DIR_THEME_JS : HTTP_THEME_JS;
$jsAppPath = ($config->get('config_render_js_in_file')) ? DIR_THEME_JS : HTTP_THEME_JS;
if (file_exists(str_replace("%theme%", $tpl, DIR_THEME_JS) . 'deps.php')) {
    require_once(str_replace("%theme%", $tpl, DIR_THEME_JS) . 'deps.php');

    foreach ($js_assets as $i => $routes) {
        if (empty($routes)) continue;
        if (is_array($routes) && in_array($route, $routes) || $routes === '*') {
            array_push($javascripts, $i);
            unset($js_assets[$i]);
        }
    }

    foreach ($js_header_assets as $i => $routes) {
        if (empty($routes)) continue;
        if (is_array($routes) && in_array($route, $routes) || $routes === '*') {
            array_push($header_javascripts, $i);
            unset($js_header_assets[$i]);
        }
    }

    if ($jsx_assets) {
        foreach ($jsx_assets as $i => $routes) {
            if (empty($routes)) continue;
            if ((is_array($routes) && in_array($route, $routes)) || $routes === '*') {
                array_push($scripts, array(
                    'method'=>'jsx',
                    'id'=>$i,
                    'script'=>file_get_contents($i)
                ));
                unset($jsx_assets[$i]);
            }
        }
    }

    $registry->set('js_assets', $js_assets);
    $registry->set('js_header_assets', $js_header_assets);
    $registry->set('jsx_assets', $jsx_assets);
}

$cssSharedPath = ($config->get('config_render_css_in_file')) ? DIR_CSS : HTTP_CSS;
$cssPath = ($config->get('config_render_css_in_file')) ? DIR_THEME_CSS : HTTP_THEME_CSS;
if (file_exists(str_replace("%theme%", $tpl, DIR_THEME_CSS) . 'deps.php')) {
    require_once(str_replace("%theme%", $tpl, DIR_THEME_CSS) . 'deps.php');
    foreach ($css_assets as $i => $asset) {
        if (empty($asset['css'])) continue;
        if ((is_array($asset['routes']) && in_array($route, $asset['routes'])) || $asset['routes'] === '*') {
            array_push($styles, $asset['css']);
            unset($css_assets[$i]);
        }
    }
    $registry->set('css_assets', $css_assets);
}

$registry->set('header_javascripts', $header_javascripts);
$registry->set('javascripts', $javascripts);
$registry->set('styles', $styles);
$registry->set('scripts', $scripts);