<?php if ($tags || $manufacturer || $categories) { ?>
<ul id="<?php echo $widgetName; ?>_productTags">
    <?php if ($manufacturer_name) { ?>
    <li>
        <a class="manufacturer_tag" id="<?php echo $widgetName; ?>_productManufacturer" title="<?php echo $manufacturer_name; ?>" href="<?php echo str_replace('&', '&amp;', $manufacturer_link); ?>">
            <?php echo $manufacturer_name; ?>
        </a>
    </li>
    <?php } ?>

    <?php foreach ($categories as $tag) { ?>
    <li>
        <a class="category_tag" id="<?php echo $widgetName; ?>_productCategory_<?php echo $tag['category_id']; ?>" title="<?php echo $tag['name']; ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl('store/category',array('path'=>$tag['category_id']))); ?>">
            <?php echo $tag['name']; ?>
        </a>
    </li>
    <?php } ?>

    <?php foreach ($tags as $tag) { ?>
    <li>
        <a title="<?php echo $tag['tag']; ?>" href="<?php echo str_replace('&', '&amp;', $tag['href']); ?>">
            <?php echo $tag['tag']; ?>
        </a>
    </li>
    <?php } ?>

</ul>
<?php } ?>