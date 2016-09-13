<?php
$cssPath = str_replace("%theme%", $tpl, DIR_ADMIN_THEME_CSS);
$css_assets = array(
    'bootstrap.min.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'bootstrap.min.css'
        ),
        'routes'=> '*'
    ),
    'font-awesome.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'vendor/font-awesome/css/font-awesome.css'
        ),
        'routes'=> '*'
    ),
    'toastr.min.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'vendor/toastr/toastr.min.css'
        ),
        'routes'=> '*'
    ),
    'gritter/jquery.gritter.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'vendor/gritter/jquery.gritter.css'
        ),
        'routes'=> '*'
    ),
    'chosen.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'vendor/chosen/chosen.css'
        ),
        'routes'=> '*'
    ),
    'summernote.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'vendor/summernote/summernote.css'
        ),
        'routes'=> '*'
    ),
    'summernote-bs3.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'vendor/summernote/summernote-bs3.css'
        ),
        'routes'=> '*'
    ),
    'animate.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'animate.css'
        ),
        'routes'=> '*'
    ),
    'style.css' => array(
        'css' => array(
            'media' => 'all',
            'href' => $cssPath . 'style.css'
        ),
        'routes'=> '*'
    ),
    /**
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
     **/
);
