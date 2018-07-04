<div id="search" nt-editable>

    <div class="large-8 medium-8 small-8 columns">
        <input id="filterKeyword" type="text" placeholder="<?php echo $Language->get('Search'); ?>" nt-editable />
        <a onclick="clearInput(this, '#filterKeyword')">X</a>
    </div>

    <div class="large-1 medium-1 small-1 columns">
        <a onclick="moduleSearch($('#filterKeyword'));">
            <?php echo $Language->get('GO'); ?>
        </a>
    </div>

</div>