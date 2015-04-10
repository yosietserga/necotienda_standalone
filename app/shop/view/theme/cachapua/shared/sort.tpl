<?php if ($sorts) { ?>
    <div class="sort filter-sort">
        <select name="sort" onchange="window.location.href = this.value">
            <?php foreach ($sorts as $sorted) { ?>
                <option value="<?php echo $sorted['href']; ?>"<?php if (($sort . '-' . $order) == $sorted['value']) { ?> selected="selected"<?php } ?>><?php echo $sorted['text']; ?></option>
            <?php } ?>
        </select>
        <a class="view_style" onclick="if ($('#productsWrapper').hasClass('catalog-list')) { $('#productsWrapper').removeClass('catalog-list').addClass('catalog-grid'); $(this).find('i').removeClass('fa-th-list').addClass('fa-th-large'); } else { $('#productsWrapper').removeClass('catalog-grid').addClass('catalog-list'); $(this).find('i').removeClass('fa-th-large').addClass('fa-th-list'); }">
            <i class="fa fa-th-list fa-2x"></i>
        </a>
    </div>
<?php } ?>