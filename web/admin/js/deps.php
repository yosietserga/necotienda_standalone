<?php
$jsPath = str_replace("%theme%", $tpl, HTTP_ADMIN_THEME_JS);
$jsAppPath = str_replace("%theme%", $tpl, HTTP_ADMIN_THEME_JS);
$js_assets = array(
    $jsPath.'vendor/backbone/underscore-min.js' => '*',
    $jsPath.'vendor/backbone/backbone-min.js' => '*',
    $jsPath.'vendor/react/react.min.js' => '*',
    $jsPath.'vendor/react/JSXTransformer.js' => '*',
    $jsPath.'vendor/react/backbone-react-component-min.js' => '*',

    $jsPath.'plugins.js' => '*',
    $jsPath.'main.js' => '*',
    $jsPath.'vendor/bootstrap.min.js' => '*',

    $jsPath.'vendor/metisMenu/jquery.metisMenu.js' => '*',
    $jsPath.'vendor/slimscroll/jquery.slimscroll.min.js' => '*',

    $jsPath.'vendor/flot/jquery.flot.js' => '*',
    $jsPath.'vendor/flot/jquery.flot.tooltip.min.js' => '*',
    $jsPath.'vendor/flot/jquery.flot.spline.js' => '*',
    $jsPath.'vendor/flot/jquery.flot.resize.js' => '*',
    $jsPath.'vendor/flot/jquery.flot.pie.js' => '*',

    $jsPath.'vendor/peity/jquery.peity.min.js' => '*',
    $jsPath.'demo/peity-demo.js' => '*',

    $jsPath.'vendor/pace/pace.min.js' => '*',
    $jsPath.'vendor/jquery-ui/jquery-ui.min.js' => '*',
    $jsPath.'vendor/gritter/jquery.gritter.min.js' => '*',
    $jsPath.'vendor/sparkline/jquery.sparkline.min.js' => '*',
    $jsPath.'demo/sparkline-demo.js' => '*',
    $jsPath.'vendor/chartJs/Chart.min.js' => '*',
    $jsPath.'vendor/toastr/toastr.min.js' => '*',

    $jsPath.'vendor/simpleStorage/simpleStorage.js' => '*',

    $jsAppPath.'app/app.js' => '*',

    $jsAppPath.'app/system/route.js' => '*',

    $jsAppPath.'app/utils/db.js' => '*',
    $jsAppPath.'app/utils/connection.js' => '*',
    $jsAppPath.'app/utils/task.js' => '*',
    $jsAppPath.'app/utils/image.js' => '*',

    $jsAppPath.'vendor/attr-accept/attr-accept.js' => array(
        'store/product'
    ),

    $jsAppPath.'vendor/react-dropzone/react-dropzone.js' => array(
        'store/product'
    ),

    $jsAppPath.'vendor/chosen/chosen.jquery.js' => array(
        'store/product'
    ),

    $jsAppPath.'vendor/fileUploader/jquery.iframe-transport.js' => array(
        'store/product',
        'user/user'
    ),

    $jsAppPath.'vendor/fileUploader/jquery.fileupload.js' => array(
        'store/product',
        'user/user'
    ),

    $jsAppPath.'vendor/summernote/summernote.min.js' => array(
        'store/product'
    ),

    $jsAppPath.'app/models/localisation/language.js' => array(
        'store/product'
    ),
    $jsAppPath.'app/models/store/product.js' => array(
        'store/product'
    ),
    $jsAppPath.'app/collections/store/products.js' => array(
        'store/product'
    ),

);

$jsx_assets = array(
    $jsAppPath.'app/views/store/productSearchBox.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productList.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productListItems.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productFormDescription.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productFormImages.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/content/fileManagerModal.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productFormMain.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productImportMain.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productListMain.jsx' => array(
        'store/product'
    ),
    $jsAppPath.'app/views/store/productMain.jsx' => array(
        'store/product'
    ),
);