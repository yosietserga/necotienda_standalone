<?php
$jsPath = str_replace("%theme%", $tpl, HTTP_ADMIN_THEME_JS);
$jsFolder = str_replace("%theme%", $tpl, DIR_ADMIN_THEME_JS);
$js_assets = array(
    $jsPath.'vendor/jquery-ui.min.js' => '*',
    $jsPath.'necojs/neco.form.js' => '*',
    $jsPath.'vendor/jquery.sidr.min.js' => '*',
    $jsPath.'vendor/jquery.chosen/chosen.jquery.min.js' => '*',
    $jsPath.'vendor/jquery.cryptography.min.js' => '*',
    $jsPath.'vendor/highcharts-4.0.1/highcharts.js' => array(
        'common/home'
    ),
    $jsPath.'vendor/jquery.fancybox.pack.js' => '*',

    $jsPath.'vendor/jstree/jstree.min.js' => '*',
    $jsPath.'vendor/fileUploader/jquery.iframe-transport.js' => '*',
    $jsPath.'vendor/fileUploader/jquery.fileupload.js' => '*',

    $jsPath.'vendor/ckeditor/ckeditor.js' => array(
        'store/category/insert',
        'store/category/update',
        'store/manufacturer/insert',
        'store/manufacturer/update',
        'store/product/insert',
        'store/product/update',
        'content/post_category/insert',
        'content/post_category/update',
        'content/post/insert',
        'content/post/update',
        'content/page/insert',
        'content/page/update',
        'content/menu/insert',
        'content/menu/update',
        'style/widget',
        'setting/setting',
        'marketing/newsletter/insert',
        'marketing/newsletter/update',
    ),
    $jsPath.'vendor/jquery.ajaxqueue.min.js' => array(
        'store/category/insert',
        'store/category/update',
        'store/manufacturer/insert',
        'store/manufacturer/update',
        'store/product/insert',
        'store/product/update',
        'content/post_category/insert',
        'content/post_category/update',
        'content/post/insert',
        'content/post/update',
        'content/page/insert',
        'content/page/update',
        'style/widget',
    ),
    $jsPath.'formwidgets.js' => array(
        'store/category/insert',
        'store/category/update',
        'store/manufacturer/insert',
        'store/manufacturer/update',
        'store/product/insert',
        'store/product/update',
        'content/post_category/insert',
        'content/post_category/update',
        'content/post/insert',
        'content/post/update',
        'content/page/insert',
        'content/page/update',
    ),
    $jsPath.'vendor/jquery.nestedSortable.js' => array(
        'store/category',
        'content/post_category',
        'content/menu',
        'content/menu/insert',
        'content/menu/update'
    ),

    $jsPath.'vendor/ace/src-min/ace.js' => array(
        'style/editor',
        'style/widget'
    ),
    $jsPath.'vendor/ace/src-min/mode-html.js' => array(
        'style/editor'
    ),
    $jsPath.'vendor/ace/src-min/mode-css.js' => array(
        'style/editor'
    ),
    $jsPath.'vendor/ace/src-min/mode-javascript.js' => array(
        'style/editor'
    ),
    $jsPath.'vendor/ace/src-min/mode-php.js' => array(
        'style/editor'
    ),


    $jsPath.'plugins.js' => '*',
    $jsPath.'main.js' => '*'
);