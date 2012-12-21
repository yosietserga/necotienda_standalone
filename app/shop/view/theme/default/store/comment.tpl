<div class="header" id="review_title"><h1><?php echo $text_write; ?></h1></div>
<div class="content">
    <?php echo isset($fkey)? $fkey : ''; ?>
    <div class="details">
        <div class="label"><b><?php echo $entry_name; ?></b></div>
        <div class="detail"><input type="text" name="name" value="" /></div>
    </div>
    <div class="details">
        <div class="label"><b><?php echo $entry_review; ?></b></div>
        <div class="detail">
            <textarea name="text" style="width: 98%;" rows="8"></textarea>
            <span style="font-size: 11px;"><?php echo $text_note; ?></span>
        </div>
    </div>
    <div class="details">
        <div class="label"><b><?php echo $entry_rating; ?></b></div>
        <div class="detail">
            <span style="float: left;margin-right: 10px;"><?php echo $entry_bad; ?></span>
            <a class="star_review" id="1"></a>
            <a class="star_review" id="2"></a>
            <a class="star_review" id="3"></a>
            <a class="star_review" id="4"></a>
            <a class="star_review" id="5"></a>
            <input type="hidden" name="rating" id="review_" value="0" />
            <span style="float: left;margin-left:10px;"><?php echo $entry_good; ?></span>
        </div>
    </div>
    <div class="buttons"><a title="<?php echo $button_continue; ?>" onclick="review();" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>