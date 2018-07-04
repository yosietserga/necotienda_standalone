<?php
//$jsSharedPath is the common js folder outside the template
$jsPath = str_replace("%theme%", $tpl, $jsPath);
$jsAppPath = str_replace("%theme%", $tpl, $jsAppPath);


$js_assets = array(
    //JS Main Files
    $jsSharedPath.'vendor/prop-types/prop-types.min.js' => '*',
    $jsSharedPath.'vendor/react/react.js' => '*',
    $jsSharedPath.'vendor/react-dom/react-dom.js' => '*',
    $jsSharedPath.'vendor/react/JSXTransformer.js' => '*',
    $jsSharedPath.'vendor/redux/redux.min.js' => '*',
    $jsSharedPath.'vendor/react-redux/react-redux.min.js' => '*',
    $jsSharedPath.'vendor/react-pure-render/shallowEqual.js' => '*',
    $jsSharedPath.'vendor/immutable/immutable.min.js' => '*',
    $jsSharedPath.'vendor/react-swipe/react-swipe.min.js' => '*',

    //Theming Materia UI
    $jsSharedPath.'vendor/material-ui/material-ui.development.js' => '*',


    $jsPath.'necojs/neco.form.js' => '*',

    // JS App Core File
    $jsAppPath.'app/app.js' => '*',

    //JS Theme Files
    $jsPath.'main.js' => '*',
    $jsPath.'vendor/bootstrap.min.js' => '*',

    //JS Vendor Files
    $jsPath.'vendor/metisMenu/jquery.metisMenu.js' => '*',
    $jsPath.'vendor/slimscroll/jquery.slimscroll.min.js' => '*',

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

    //JS System Files
    $jsAppPath.'app/system/component.js' => '*',
    $jsAppPath.'app/system/model.js' => '*',
    $jsAppPath.'app/system/controller.js' => '*',
    $jsAppPath.'app/system/route.js' => '*',

    //JS Utils Files
    $jsAppPath.'app/utils/db.js' => '*',
    $jsAppPath.'app/utils/connection.js' => '*',
    $jsAppPath.'app/utils/task.js' => '*',
    $jsAppPath.'app/utils/image.js' => '*',

    $jsAppPath.'vendor/jquery.cryptography.min.js' => '*',

    //JS NecoTienda App Routed Files
    $jsAppPath.'vendor/attr-accept/attr-accept.js' => array(
        'store/product'
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

$product = array('store/product');

$jsx_assets = array(
    $jsAppPath.'app/components/necotienda/inputs/common/text.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/common/select.jsx' => $product,

    $jsAppPath.'app/components/necotienda/inputs/product/manufacturer_id.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/stock_status_id.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/tax_class_id.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/quantity.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/price.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/width.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/weight.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/length.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/descriptions.jsx' => $product,
    $jsAppPath.'app/components/necotienda/inputs/product/model.jsx' => $product,

    $jsAppPath.'app/components/necotienda/forms/product/add.jsx' => $product,
    $jsAppPath.'app/views/store/productFormImages.jsx' => $product,
    $jsAppPath.'app/views/store/productFormMain.jsx' => $product,

    $jsAppPath.'app/views/store/productSearchBox.jsx' => $product,
    $jsAppPath.'app/views/store/productList.jsx' => $product,
    $jsAppPath.'app/views/store/productListItems.jsx' => $product,
    $jsAppPath.'app/views/content/fileManagerModal.jsx' => $product,
    $jsAppPath.'app/views/store/productImportMain.jsx' => $product,
    $jsAppPath.'app/views/store/productListMain.jsx' => $product,
    $jsAppPath.'app/views/store/productMain.jsx' => $product,
);