<?php
$cssPath = str_replace("%theme%", $tpl, $cssPath);


$css_assets = array(
    'fonts.stylesheet.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'fonts.stylesheet.css'
        ),
        'routes'=> '*'
    ),
    'framework/vendor/jquery.mmenu.all.css' => array(
        'css' => array(
            'media' => 'only m',
            'href' => $cssPath . 'framework/vendor/jquery.mmenu.all.css'
        ),
        'routes'=> '*'
    ),
    'vendor/jQuery.jScrollPane/jquery.jscrollpane.min.css' => array(
        'css' => array(
            'media' => 'only x',
            'href' => $cssPath . 'vendor/jQuery.jScrollPane/jquery.jscrollpane.min.css'
        ),
        'routes'=> '*'
    ),
    'vendor/jQuery.jScrollPane/jquery.jscrollpane.theme.reskin.min.css' => array(
        'css' => array(
            'media' => 'only x',
            'href' => $cssPath . 'vendor/jQuery.jScrollPane/jquery.jscrollpane.theme.reskin.min.css'
        ),
        'routes'=> '*'
    ),
    'non-critical.css' => array(
        'css' => array(
            'media' => 'only x',
            'href' => $cssPath . 'non-critical.css'
        ),
        'routes'=> '*'
    ),
    'responsive.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'responsive.css'
        ),
        'routes'=> '*'
    ),
    'print.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'print.css'
        ),
        'routes'=> '*'
    ),
    'grids.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'grids.css'
        ),
        'routes'=> '*'
    ),
    'theme.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'theme.css'
        ),
        'routes'=> '*'
    ),
    /*
    'jquery-ui.min.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'jquery-ui.min.css'
        ),
        'routes'=> array (
            'common/home',
            'store/product',
            'store/product/insert',
            'store/product/update',
            'store/product/import'
        )
    )
    */
);