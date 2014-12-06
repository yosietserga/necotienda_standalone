<h3><?php echo $Language->get('text_backgrounds'); ?></h3>
<div>
    <a onclick="showAdvanced(this)"><?php echo $Language->get('text_advanced'); ?></a>
    <input class="style-panel advanced" type="hidden" id="borderRadiusAdvanced" value="" />
    <div>
        <table>
            <tr>
                <td><?php echo $Language->get('text_color'); ?>:<div id="background-colorpicker"></div></td>
                <td>
                    <input class="style-panel" type="text" id="backgroundColor" name="Style[background-color]" value="" />
                    <span class="transparent-background" onclick="$('#backgroundColor').val('transparent');setStyle();"></span>
                </td>
                <td><a class="style-icons help" title="<?php echo $Language->get('help_color'); ?>"></a></td>
            </tr>
            <tr>
                <td><?php echo $Language->get('text_image'); ?>:<br /><a onclick="image_upload()" style="font-size:7px !important;">Ver Servidor</a></td>
                <td><input class="style-panel" type="url" id="backgroundImage" name="Style[background-image]" value="" /></td>
                <td><a class="style-icons help" title="<?php echo $Language->get('help_image'); ?>"></a></td>
            </tr>
            <tr>
                <td><?php echo $Language->get('text_image_repeat'); ?>:</td>
                <td>
                    <select class="style-panel" id="backgroundRepeat" name="Style[background-repeat]">
                        <option value=""><?php echo $Language->get('text_default'); ?></option>
                        <option value="repeat"><?php echo $Language->get('text_repeat'); ?></option>
                        <option value="repeat-x"><?php echo $Language->get('text_repeat_from_left_to_right'); ?></option>
                        <option value="repeat-y"><?php echo $Language->get('text_repeat_from_top_to_bottom'); ?></option>
                        <option value="no-repeat"><?php echo $Language->get('text_no_repeat'); ?></option>
                    </select>
                </td>
                <td><a class="style-icons help" title="<?php echo $Language->get('help_repeat'); ?>"></a></td>
            </tr>
            <tr>
                <td><?php echo $Language->get('text_image_position'); ?>:</td>
                <td>
                    <input class="style-panel" type="necoNumber" id="backgroundPositionX" name="Style[background-position-x]" value="" style="width:40px" />
                    <input class="style-panel" type="necoNumber" id="backgroundPositionY" name="Style[background-position-y]" value="" style="width:40px" />
                </td>
                <td><a class="style-icons help" title="<?php echo $Language->get('help_image_position'); ?>"></a></td>
            </tr>
            <tr>
                <td><?php echo $Language->get('text_image_attachment'); ?>:</td>
                <td>
                    <input class="style-panel" type="checkbox" id="backgroundAttachment" name="Style[background-attachment]" value="1" />
                </td>
                <td><a class="style-icons help" title="<?php echo $Language->get('help_image_attachment'); ?>"></a></td>
            </tr>
            <!--
            <tr>
                <td><a class="button" onclick="resetBackground()"><?php echo $Language->get('text_clean'); ?></a></td>
                <td><a class="button" onclick="setStyle()"><?php echo $Language->get('text_apply'); ?></a></td>
            </tr>
            -->
        </table>
    </div>
    <div style="display:none;">
    </div>
</div>