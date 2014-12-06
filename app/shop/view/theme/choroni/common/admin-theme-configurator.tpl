<form id="cssDataWrapper"></form>
<form id="formStyle">
    <input type="hidden" id="selector" name="selector" value="" />
    <input type="hidden" id="mainselector" name="mainselector" value="" />

    <a class="style-icons nuevo" href="'<?php echo $new_theme; ?>'"></a>
    <a class="style-icons save" onclick="saveStyle('<?php echo $save_theme; ?>')"></a>
    <a class="style-icons clean" onclick="cleanStyle()"></a>
    <a class="style-icons copy" onclick="copyStyle()"></a>
    <a class="style-icons paste" onclick="pasteStyle()"></a>
    <a class="style-icons print" onclick="printStyle()"></a>
    <!-- <a class="style-icons close" onclick="slidePanel('style')"><?php echo $Language->get('text_close'); ?></a> -->

    <div class="clear"></div>

    <select id="selectors" onchange="setElementToStyle($(this).val())">
        <option value="null"><?php echo $Language->get('text_general'); ?></option>

        <optgroup label="<?php echo $Language->get('text_fonts'); ?>">
            <option value="h1"><?php echo $Language->get('text_heading_h1'); ?></option>
            <!-- <option value="h1:hover"><?php echo $Language->get('text_heading_h1_hover'); ?></option> -->
            <option value="subtitle"><?php echo $Language->get('text_subheading_h2_h6'); ?></option>
            <option value="p"><?php echo $Language->get('text_paragraphs'); ?></option>
            <option value="b"><?php echo $Language->get('text_strong'); ?></option>
            <option value="a"><?php echo $Language->get('text_links'); ?></option>
            <!-- <option value="a:hover"><?php echo $Language->get('text_links_hover'); ?></option> -->
        </optgroup>

        <optgroup label="<?php echo $Language->get('text_forms'); ?>">
            <option value="input"><?php echo $Language->get('text_inputs'); ?></option>
            <!-- <option value="input:hover"><?php echo $Language->get('text_inputs_hover'); ?></option> -->
            <!-- <option value="input:focus"><?php echo $Language->get('text_inputs_focus'); ?></option> -->
            <option value="select"><?php echo $Language->get('text_selects'); ?></option>
            <!-- <option value="select:hover"><?php echo $Language->get('text_selects_hover'); ?></option> -->
            <option value="textarea"><?php echo $Language->get('text_textareas'); ?></option>
            <!-- <option value="textarea:hover"><?php echo $Language->get('text_textareas_hover'); ?></option> -->
            <!-- <option value="textarea:focus"><?php echo $Language->get('text_textareas_focus'); ?></option> -->
            <option value="label"><?php echo $Language->get('text_label'); ?></option>
        </optgroup>

        <optgroup label="<?php echo $Language->get('text_tables'); ?>">
            <option value="th"><?php echo $Language->get('text_table_header'); ?></option>
            <option value="tr"><?php echo $Language->get('text_table_rows'); ?></option>
            <option value="td"><?php echo $Language->get('text_table_columns'); ?></option>
            <option value="tr:first-child"><?php echo $Language->get('text_table_first_row'); ?></option>
            <option value="td:first-child"><?php echo $Language->get('text_table_first_column'); ?></option>
        </optgroup>

        <optgroup label="<?php echo $Language->get('text_others'); ?>">
            <option value="li"><?php echo $Language->get('text_list_items'); ?></option>
            <option value="li:hover"><?php echo $Language->get('text_list_items_hover'); ?></option>
            <option value="span"><?php echo $Language->get('text_span'); ?></option>
            <option value=".header"><?php echo $Language->get('text_headers'); ?></option>
            <option value=".content"><?php echo $Language->get('text_contents'); ?></option>
        </optgroup>

    </select>

    <div class="clear"></div>

    <h3 style="padding:10px;background: #84A150;border: solid 1px ;#376300; color:#fff;"><?php echo $Language->get('text_selector'); ?>: <span id="el" style="font-weight: bold;"></span></h3>
    <div class="clear"></div>

    <div class="panelWrapper">
        <?php require_once('admin-theme-background.tpl'); ?>
        <?php require_once('admin-theme-fonts.tpl'); ?>
        <?php require_once('admin-theme-borders.tpl'); ?>
        <?php require_once('admin-theme-borderradius.tpl'); ?>
        <?php require_once('admin-theme-shadows.tpl'); ?>
        <?php require_once('admin-theme-margins.tpl'); ?>
        <?php require_once('admin-theme-paddings.tpl'); ?>
        <?php require_once('admin-theme-dimensions.tpl'); ?>
    </div>
</form>
