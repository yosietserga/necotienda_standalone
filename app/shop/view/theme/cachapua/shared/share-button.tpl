<div class="share-buttons">
    <ul class="rrssb-buttons clearfix">
        <li class="rrssb-facebook">
            <a onclick="popupWindow('https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($Url::createUrl('store/product',array('product_id'=>$product['product_id']))); ?>', 'Facebook', 600 , 480); return false;"
               href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($Url::createUrl('store/product',array('product_id'=>$product['product_id']))); ?>">
                <span class="rrssb-icon">
                    <i class="fa fa-facebook"></i>
                </span>
                <span class="rrssb-text">facebook</span>
            </a>
        </li>
        <li class="rrssb-twitter">
            <a href="https://twitter.com/home?status=<?php echo urlencode($Url::createUrl('store/product',array('product_id'=>$product['product_id']))); ?>" class="popup">
                <span class="rrssb-icon">
                    <i class="fa fa-twitter"></i>
                </span>
                <span class="rrssb-text">twitter</span>
            </a>
        </li>
        <li class="rrssb-googleplus">
            <a href="https://plus.google.com/share?url=<?php echo urlencode($Url::createUrl('store/product',array('product_id'=>$product['product_id']))); ?>" class="popup">
                <span class="rrssb-icon">
                    <i class="fa fa-google-plus"></i>
                </span>
                <span class="rrssb-text">google+</span>
            </a>
        </li>
    </ul>
</div>
