<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/customer.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $reset; ?>';" class="button"><span><?php echo $button_reset; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%;">
      <div id="vtabs" class="vtabs">
      <a  tab="#tab_header"><?php echo $tab_header; ?></a>
      <a  tab="#tab_products"><?php echo $tab_products; ?></a>
    </div>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab_header" class="vtabs_page">
            <h1><?php echo $tab_header; ?></h1>
            <h2><?php echo $busqueda; ?></h2>
            
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[a.searchButton][background-image]" value="<?php echo $_searchButton_image; ?>" id="searchButton_image" />
                  <img src="<?php echo $searchButton_image; ?>" id="image_searchButton" class="image" onclick="image_upload('searchButton_image', 'image_searchButton');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[a.searchButton][background-repeat]" id="searchButton_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($searchButton_background_repeat) && ($searchButton_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_searchButton_repeat) { ?>
                <span class="error"><?php echo $error_background_searchButton_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[a.searchButton][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($searchButton_background_position) && ($searchButton_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[a.searchButton][background]" id="searchButton_gradient"><?php echo $searchButton_background; ?></textarea>
                <?php if ($error_background_searchButton_gradient) { ?>
                <span class="error"><?php echo $error_background_searchButton_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="searchButtonA">
                    <input type="text" id="searchButton_a" name="Style[a.searchButton][color]" value="<?php echo !empty($searchButtona_color) ? $searchButtona_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($searchButtona_color) ? " style='background-color:".$searchButtona_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($searchButtona_color)) $css .= "color:$searchButtona_color;";?>
                    <?php if (!empty($searchButtona_font_family)) $css .= "font-family:$searchButtona_color;";?>
                    <?php if (!empty($searchButtona_font_size)) $css .= "font-size:$searchButtona_font_size;";?>
                    <?php if (!empty($searchButtona_font_weight)) $css .= "font-weight:$searchButtona_font_weight;";?>
                    <?php if (!empty($searchButtona_font_style)) $css .= "font-style:$searchButtona_font_style;";?>
                    <?php if (!empty($searchButtona_text_decoration)) $css .= "text-decoration:$searchButtona_text_decoration;";?>
                    <div id="searchButtonADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[a.searchButton][font-family]" onchange="demo(this,'font-family','searchButtonADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($searchButtona_font_family) && ($searchButtona_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[a.searchButton][font-size]" onchange="demo(this,'font-size','searchButtonADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($searchButtona_font_size) && ($searchButtona_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[a.searchButton][font-weight]" onchange="demo(this,'font-weight','searchButtonADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($searchButtona_font_weight) && ($searchButtona_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[a.searchButton][font-style]" onchange="demo(this,'font-style','searchButtonADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($searchButtona_font_style) && ($searchButtona_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_underline; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[a.searchButton][text-decoration]" onchange="demo(this,'text-decoration','searchButtonADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($searchButtona_text_decoration) && ($searchButtona_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2><?php echo $busqueda; ?> :Hover</h2>
        
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[a.searchButton:hover][background-image]" value="<?php echo $_searchButtonHover_image; ?>" id="searchButtonHover_image" />
                  <img src="<?php echo $searchButtonHover_image; ?>" id="image_searchButtonHover" class="image" onclick="image_upload('searchButtonHover_image', 'image_searchButtonHover');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[a.searchButton:hover][background-repeat]" id="searchButtonHover_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($searchButtonHover_background_repeat) && ($searchButtonHover_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_searchButtonHover_repeat) { ?>
                <span class="error"><?php echo $error_background_searchButtonHover_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[a.searchButton:hover][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($searchButtonHover_background_position) && ($searchButtonHover_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[a.searchButton:hover][background]" id="searchButtonHover_gradient"><?php echo $searchButtonHover_background; ?></textarea>
                <?php if ($error_background_searchButtonHover_gradient) { ?>
                <span class="error"><?php echo $error_background_searchButtonHover_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="searchButtonAHover">
                    <input type="text" id="searchButton_ahover" name="Style[a.searchButton:hover][color]" value="<?php echo !empty($searchButtonahover_color) ? $searchButtonahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($searchButtonahover_color) ? " style='background-color:".$searchButtonahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($searchButtonahover_color)) $css .= "color:$searchButtonahover_color;";?>
                    <?php if (!empty($searchButtonahover_font_family)) $css .= "font-family:$searchButtonahover_color;";?>
                    <?php if (!empty($searchButtonahover_font_size)) $css .= "font-size:$searchButtonahover_font_size;";?>
                    <?php if (!empty($searchButtonahover_font_weight)) $css .= "font-weight:$searchButtonahover_font_weight;";?>
                    <?php if (!empty($searchButtonahover_font_style)) $css .= "font-style:$searchButtonahover_font_style;";?>
                    <?php if (!empty($searchButtonahover_text_decoration)) $css .= "text-decoration:$searchButtonahover_text_decoration;";?>
                    <div id="searchButtonAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[a.searchButton:hover][font-family]" onchange="demo(this,'font-family','searchButtonAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($searchButtonahover_font_family) && ($searchButtonahover_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[a.searchButton:hover][font-size]" onchange="demo(this,'font-size','searchButtonAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($searchButtonahover_font_size) && ($searchButtonahover_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[a.searchButton:hover][font-weight]" onchange="demo(this,'font-weight','searchButtonAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($searchButtonahover_font_weight) && ($searchButtonahover_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[a.searchButton:hover][font-style]" onchange="demo(this,'font-style','searchButtonAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($searchButtonahover_font_style) && ($searchButtonahover_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[a.searchButton:hover][text-decoration]" onchange="demo(this,'text-decoration','searchButtonAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($searchButtonahover_text_decoration) && ($searchButtonahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2><?php echo $busqueda; ?> :Active</h2>
        
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[a.searchButtonActive:active:active][background-image]" value="<?php echo $_searchButtonActive_image; ?>" id="searchButtonActive_image" />
                  <img src="<?php echo $searchButtonActive_image; ?>" id="image_searchButtonActive" class="image" onclick="image_upload('searchButtonActive_image', 'image_searchButtonActive');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[a.searchButtonActive:active][background-repeat]" id="searchButtonActive_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($searchButtonActive_background_repeat) && ($searchButtonActive_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_searchButtonActive_repeat) { ?>
                <span class="error"><?php echo $error_background_searchButtonActive_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[a.searchButtonActive:active][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($searchButtonActive_background_position) && ($searchButtonActive_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[a.searchButtonActive:active][background]" id="searchButtonActive_gradient"><?php echo $searchButtonActive_background; ?></textarea>
                <?php if ($error_background_searchButtonActive_gradient) { ?>
                <span class="error"><?php echo $error_background_searchButtonActive_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="searchButtonAActive">
                    <input type="text" id="searchButton_aactive" name="Style[a.searchButton:active][color]" value="<?php echo !empty($searchButtonaactive_color) ? $searchButtonaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($searchButtonaactive_color) ? " style='background-color:".$searchButtonaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($searchButtonaactive_color)) $css .= "color:$searchButtonaactive_color;";?>
                    <?php if (!empty($searchButtonaactive_font_family)) $css .= "font-family:$searchButtonaactive_color;";?>
                    <?php if (!empty($searchButtonaactive_font_size)) $css .= "font-size:$searchButtonaactive_font_size;";?>
                    <?php if (!empty($searchButtonaactive_font_weight)) $css .= "font-weight:$searchButtonaactive_font_weight;";?>
                    <?php if (!empty($searchButtonaactive_font_style)) $css .= "font-style:$searchButtonaactive_font_style;";?>
                    <?php if (!empty($searchButtonaactive_text_decoration)) $css .= "text-decoration:$searchButtonaactive_text_decoration;";?>
                    <div id="searchButtonAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[a.searchButton:active][font-family]" onchange="demo(this,'font-family','searchButtonAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($searchButtonaactive_font_family) && ($searchButtonaactive_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[a.searchButton:active][font-size]" onchange="demo(this,'font-size','searchButtonAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($searchButtonaactive_font_size) && ($searchButtonaactive_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[a.searchButton:active][font-weight]" onchange="demo(this,'font-weight','searchButtonAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($searchButtonaactive_font_weight) && ($searchButtonaactive_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[a.searchButton:active][font-style]" onchange="demo(this,'font-style','searchButtonAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($searchButtonaactive_font_style) && ($searchButtonaactive_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[a.searchButton:active][text-decoration]" onchange="demo(this,'text-decoration','searchButtonAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($searchButtonaactive_text_decoration) && ($searchButtonaactive_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        </div>
        
        <div id="tab_products" class="vtabs_page">
            <h1><?php echo $tab_products; ?></h1>
            <h2>Bot&oacute;n Comprar</h2>
            
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.button_add_small][background-image]" value="<?php echo $_buttonAddSmall_image; ?>" id="buttonAddSmall_image" />
                  <img src="<?php echo $buttonAddSmall_image; ?>" id="image_buttonAddSmall" class="image" onclick="image_upload('buttonAddSmall_image', 'image_buttonAddSmall');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.button_add_small][background-repeat]" id="buttonAddSmall_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmall_background_repeat) && ($buttonAddSmall_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_buttonAddSmall_repeat) { ?>
                <span class="error"><?php echo $error_background_buttonAddSmall_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[.button_add_small][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmall_background_position) && ($buttonAddSmall_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.button_add_small][background]" id="buttonAddSmall_gradient"><?php echo $buttonAddSmall_background; ?></textarea>
                <?php if ($error_background_buttonAddSmall_gradient) { ?>
                <span class="error"><?php echo $error_background_buttonAddSmall_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="buttonAddSmallA">
                    <input type="text" id="buttonAddSmall_a" name="Style[.button_add_small][color]" value="<?php echo !empty($buttonAddSmalla_color) ? $buttonAddSmalla_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($buttonAddSmalla_color) ? " style='background-color:".$buttonAddSmalla_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($buttonAddSmalla_color)) $css .= "color:$buttonAddSmalla_color;";?>
                    <?php if (!empty($buttonAddSmalla_font_family)) $css .= "font-family:$buttonAddSmalla_color;";?>
                    <?php if (!empty($buttonAddSmalla_font_size)) $css .= "font-size:$buttonAddSmalla_font_size;";?>
                    <?php if (!empty($buttonAddSmalla_font_weight)) $css .= "font-weight:$buttonAddSmalla_font_weight;";?>
                    <?php if (!empty($buttonAddSmalla_font_style)) $css .= "font-style:$buttonAddSmalla_font_style;";?>
                    <?php if (!empty($buttonAddSmalla_text_decoration)) $css .= "text-decoration:$buttonAddSmalla_text_decoration;";?>
                    <div id="buttonAddSmallADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.button_add_small][font-family]" onchange="demo(this,'font-family','buttonAddSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmalla_font_family) && ($buttonAddSmalla_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[.button_add_small][font-size]" onchange="demo(this,'font-size','buttonAddSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmalla_font_size) && ($buttonAddSmalla_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[.button_add_small][font-weight]" onchange="demo(this,'font-weight','buttonAddSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmalla_font_weight) && ($buttonAddSmalla_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[.button_add_small][font-style]" onchange="demo(this,'font-style','buttonAddSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmalla_font_style) && ($buttonAddSmalla_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_underline; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.button_add_small][text-decoration]" onchange="demo(this,'text-decoration','buttonAddSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmalla_text_decoration) && ($buttonAddSmalla_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Bot&oacute;n Comprar :Hover</h2>
        
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.button_add_small:hover][background-image]" value="<?php echo $_buttonAddSmallHover_image; ?>" id="buttonAddSmallHover_image" />
                  <img src="<?php echo $buttonAddSmallHover_image; ?>" id="image_buttonAddSmallHover" class="image" onclick="image_upload('buttonAddSmallHover_image', 'image_buttonAddSmallHover');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.button_add_small:hover][background-repeat]" id="buttonAddSmallHover_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallHover_background_repeat) && ($buttonAddSmallHover_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_buttonAddSmallHover_repeat) { ?>
                <span class="error"><?php echo $error_background_buttonAddSmallHover_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[.button_add_small:hover][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallHover_background_position) && ($buttonAddSmallHover_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.button_add_small:hover][background]" id="buttonAddSmallHover_gradient"><?php echo $buttonAddSmallHover_background; ?></textarea>
                <?php if ($error_background_buttonAddSmallHover_gradient) { ?>
                <span class="error"><?php echo $error_background_buttonAddSmallHover_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="buttonAddSmallAHover">
                    <input type="text" id="buttonAddSmall_ahover" name="Style[.button_add_small:hover][color]" value="<?php echo !empty($buttonAddSmallahover_color) ? $buttonAddSmallahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($buttonAddSmallahover_color) ? " style='background-color:".$buttonAddSmallahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($buttonAddSmallahover_color)) $css .= "color:$buttonAddSmallahover_color;";?>
                    <?php if (!empty($buttonAddSmallahover_font_family)) $css .= "font-family:$buttonAddSmallahover_color;";?>
                    <?php if (!empty($buttonAddSmallahover_font_size)) $css .= "font-size:$buttonAddSmallahover_font_size;";?>
                    <?php if (!empty($buttonAddSmallahover_font_weight)) $css .= "font-weight:$buttonAddSmallahover_font_weight;";?>
                    <?php if (!empty($buttonAddSmallahover_font_style)) $css .= "font-style:$buttonAddSmallahover_font_style;";?>
                    <?php if (!empty($buttonAddSmallahover_text_decoration)) $css .= "text-decoration:$buttonAddSmallahover_text_decoration;";?>
                    <div id="buttonAddSmallAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.button_add_small:hover][font-family]" onchange="demo(this,'font-family','buttonAddSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallahover_font_family) && ($buttonAddSmallahover_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[.button_add_small:hover][font-size]" onchange="demo(this,'font-size','buttonAddSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallahover_font_size) && ($buttonAddSmallahover_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[.button_add_small:hover][font-weight]" onchange="demo(this,'font-weight','buttonAddSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallahover_font_weight) && ($buttonAddSmallahover_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[.button_add_small:hover][font-style]" onchange="demo(this,'font-style','buttonAddSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallahover_font_style) && ($buttonAddSmallahover_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.button_add_small:hover][text-decoration]" onchange="demo(this,'text-decoration','buttonAddSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallahover_text_decoration) && ($buttonAddSmallahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Bot&oacute;n Comprar :Active</h2>
        
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.button_add_small:active:active][background-image]" value="<?php echo $_buttonAddSmallActive_image; ?>" id="buttonAddSmallActive_image" />
                  <img src="<?php echo $buttonAddSmallActive_image; ?>" id="image_buttonAddSmallActive" class="image" onclick="image_upload('buttonAddSmallActive_image', 'image_buttonAddSmallActive');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.button_add_small:active][background-repeat]" id="buttonAddSmallActive_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallActive_background_repeat) && ($buttonAddSmallActive_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_buttonAddSmallActive_repeat) { ?>
                <span class="error"><?php echo $error_background_buttonAddSmallActive_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[.button_add_small:active][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallActive_background_position) && ($buttonAddSmallActive_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.button_add_small:active][background]" id="buttonAddSmallActive_gradient"><?php echo $buttonAddSmallActive_background; ?></textarea>
                <?php if ($error_background_buttonAddSmallActive_gradient) { ?>
                <span class="error"><?php echo $error_background_buttonAddSmallActive_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="buttonAddSmallAActive">
                    <input type="text" id="buttonAddSmall_aactive" name="Style[.button_add_small:active][color]" value="<?php echo !empty($buttonAddSmallaactive_color) ? $buttonAddSmallaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($buttonAddSmallaactive_color) ? " style='background-color:".$buttonAddSmallaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($buttonAddSmallaactive_color)) $css .= "color:$buttonAddSmallaactive_color;";?>
                    <?php if (!empty($buttonAddSmallaactive_font_family)) $css .= "font-family:$buttonAddSmallaactive_color;";?>
                    <?php if (!empty($buttonAddSmallaactive_font_size)) $css .= "font-size:$buttonAddSmallaactive_font_size;";?>
                    <?php if (!empty($buttonAddSmallaactive_font_weight)) $css .= "font-weight:$buttonAddSmallaactive_font_weight;";?>
                    <?php if (!empty($buttonAddSmallaactive_font_style)) $css .= "font-style:$buttonAddSmallaactive_font_style;";?>
                    <?php if (!empty($buttonAddSmallaactive_text_decoration)) $css .= "text-decoration:$buttonAddSmallaactive_text_decoration;";?>
                    <div id="buttonAddSmallAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.button_add_small:active][font-family]" onchange="demo(this,'font-family','buttonAddSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallaactive_font_family) && ($buttonAddSmallaactive_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[.button_add_small:active][font-size]" onchange="demo(this,'font-size','buttonAddSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallaactive_font_size) && ($buttonAddSmallaactive_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[.button_add_small:active][font-weight]" onchange="demo(this,'font-weight','buttonAddSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallaactive_font_weight) && ($buttonAddSmallaactive_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[.button_add_small:active][font-style]" onchange="demo(this,'font-style','buttonAddSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallaactive_font_style) && ($buttonAddSmallaactive_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.button_add_small:active][text-decoration]" onchange="demo(this,'text-decoration','buttonAddSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($buttonAddSmallaactive_text_decoration) && ($buttonAddSmallaactive_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
          
          
          
          
          
          
          
          
          
          
            <h2>Bot&oacute;n Ver</h2>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.button_see_small][background-image]" value="<?php echo $_buttonSeeSmall_image; ?>" id="buttonSeeSmall_image" />
                  <img src="<?php echo $buttonSeeSmall_image; ?>" id="image_buttonSeeSmall" class="image" onclick="image_upload('buttonSeeSmall_image', 'image_buttonSeeSmall');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.button_see_small][background-repeat]" id="buttonSeeSmall_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmall_background_repeat) && ($buttonSeeSmall_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_buttonSeeSmall_repeat) { ?>
                <span class="error"><?php echo $error_background_buttonSeeSmall_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[.button_see_small][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmall_background_position) && ($buttonSeeSmall_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.button_see_small][background]" id="buttonSeeSmall_gradient"><?php echo $buttonSeeSmall_background; ?></textarea>
                <?php if ($error_background_buttonSeeSmall_gradient) { ?>
                <span class="error"><?php echo $error_background_buttonSeeSmall_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="buttonSeeSmallA">
                    <input type="text" id="buttonSeeSmall_a" name="Style[.button_see_small][color]" value="<?php echo !empty($buttonSeeSmalla_color) ? $buttonSeeSmalla_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($buttonSeeSmalla_color) ? " style='background-color:".$buttonSeeSmalla_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($buttonSeeSmalla_color)) $css .= "color:$buttonSeeSmalla_color;";?>
                    <?php if (!empty($buttonSeeSmalla_font_family)) $css .= "font-family:$buttonSeeSmalla_color;";?>
                    <?php if (!empty($buttonSeeSmalla_font_size)) $css .= "font-size:$buttonSeeSmalla_font_size;";?>
                    <?php if (!empty($buttonSeeSmalla_font_weight)) $css .= "font-weight:$buttonSeeSmalla_font_weight;";?>
                    <?php if (!empty($buttonSeeSmalla_font_style)) $css .= "font-style:$buttonSeeSmalla_font_style;";?>
                    <?php if (!empty($buttonSeeSmalla_text_decoration)) $css .= "text-decoration:$buttonSeeSmalla_text_decoration;";?>
                    <div id="buttonSeeSmallADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.button_see_small][font-family]" onchange="demo(this,'font-family','buttonSeeSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmalla_font_family) && ($buttonSeeSmalla_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[.button_see_small][font-size]" onchange="demo(this,'font-size','buttonSeeSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmalla_font_size) && ($buttonSeeSmalla_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[.button_see_small][font-weight]" onchange="demo(this,'font-weight','buttonSeeSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmalla_font_weight) && ($buttonSeeSmalla_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[.button_see_small][font-style]" onchange="demo(this,'font-style','buttonSeeSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmalla_font_style) && ($buttonSeeSmalla_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_underline; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.button_see_small][text-decoration]" onchange="demo(this,'text-decoration','buttonSeeSmallADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmalla_text_decoration) && ($buttonSeeSmalla_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Bot&oacute;n Ver :Hover</h2>
        
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.button_see_small:hover][background-image]" value="<?php echo $_buttonSeeSmallHover_image; ?>" id="buttonSeeSmallHover_image" />
                  <img src="<?php echo $buttonSeeSmallHover_image; ?>" id="image_buttonSeeSmallHover" class="image" onclick="image_upload('buttonSeeSmallHover_image', 'image_buttonSeeSmallHover');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.button_see_small:hover][background-repeat]" id="buttonSeeSmallHover_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallHover_background_repeat) && ($buttonSeeSmallHover_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_buttonSeeSmallHover_repeat) { ?>
                <span class="error"><?php echo $error_background_buttonSeeSmallHover_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[.button_see_small:hover][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallHover_background_position) && ($buttonSeeSmallHover_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.button_see_small:hover][background]" id="buttonSeeSmallHover_gradient"><?php echo $buttonSeeSmallHover_background; ?></textarea>
                <?php if ($error_background_buttonSeeSmallHover_gradient) { ?>
                <span class="error"><?php echo $error_background_buttonSeeSmallHover_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="buttonSeeSmallAHover">
                    <input type="text" id="buttonSeeSmall_ahover" name="Style[.button_see_small:hover][color]" value="<?php echo !empty($buttonSeeSmallahover_color) ? $buttonSeeSmallahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($buttonSeeSmallahover_color) ? " style='background-color:".$buttonSeeSmallahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($buttonSeeSmallahover_color)) $css .= "color:$buttonSeeSmallahover_color;";?>
                    <?php if (!empty($buttonSeeSmallahover_font_family)) $css .= "font-family:$buttonSeeSmallahover_color;";?>
                    <?php if (!empty($buttonSeeSmallahover_font_size)) $css .= "font-size:$buttonSeeSmallahover_font_size;";?>
                    <?php if (!empty($buttonSeeSmallahover_font_weight)) $css .= "font-weight:$buttonSeeSmallahover_font_weight;";?>
                    <?php if (!empty($buttonSeeSmallahover_font_style)) $css .= "font-style:$buttonSeeSmallahover_font_style;";?>
                    <?php if (!empty($buttonSeeSmallahover_text_decoration)) $css .= "text-decoration:$buttonSeeSmallahover_text_decoration;";?>
                    <div id="buttonSeeSmallAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.button_see_small:hover][font-family]" onchange="demo(this,'font-family','buttonSeeSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallahover_font_family) && ($buttonSeeSmallahover_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[.button_see_small:hover][font-size]" onchange="demo(this,'font-size','buttonSeeSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallahover_font_size) && ($buttonSeeSmallahover_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[.button_see_small:hover][font-weight]" onchange="demo(this,'font-weight','buttonSeeSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallahover_font_weight) && ($buttonSeeSmallahover_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[.button_see_small:hover][font-style]" onchange="demo(this,'font-style','buttonSeeSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallahover_font_style) && ($buttonSeeSmallahover_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.button_see_small:hover][text-decoration]" onchange="demo(this,'text-decoration','buttonSeeSmallAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallahover_text_decoration) && ($buttonSeeSmallahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Bot&oacute;n Ver :Active</h2>
        
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.button_see_small:active][background-image]" value="<?php echo $_buttonSeeSmallActive_image; ?>" id="buttonSeeSmallActive_image" />
                  <img src="<?php echo $buttonSeeSmallActive_image; ?>" id="image_buttonSeeSmallActive" class="image" onclick="image_upload('buttonSeeSmallActive_image', 'image_buttonSeeSmallActive');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.button_see_small:active][background-repeat]" id="buttonSeeSmallActive_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallActive_background_repeat) && ($buttonSeeSmallActive_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_buttonSeeSmallActive_repeat) { ?>
                <span class="error"><?php echo $error_background_buttonSeeSmallActive_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[.button_see_small:active][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallActive_background_position) && ($buttonSeeSmallActive_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.button_see_small:active][background]" id="buttonSeeSmallActive_gradient"><?php echo $buttonSeeSmallActive_background; ?></textarea>
                <?php if ($error_background_buttonSeeSmallActive_gradient) { ?>
                <span class="error"><?php echo $error_background_buttonSeeSmallActive_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="buttonSeeSmallAActive">
                    <input type="text" id="buttonSeeSmall_aactive" name="Style[.button_see_small:active][color]" value="<?php echo !empty($buttonSeeSmallaactive_color) ? $buttonSeeSmallaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($buttonSeeSmallaactive_color) ? " style='background-color:".$buttonSeeSmallaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($buttonSeeSmallaactive_color)) $css .= "color:$buttonSeeSmallaactive_color;";?>
                    <?php if (!empty($buttonSeeSmallaactive_font_family)) $css .= "font-family:$buttonSeeSmallaactive_color;";?>
                    <?php if (!empty($buttonSeeSmallaactive_font_size)) $css .= "font-size:$buttonSeeSmallaactive_font_size;";?>
                    <?php if (!empty($buttonSeeSmallaactive_font_weight)) $css .= "font-weight:$buttonSeeSmallaactive_font_weight;";?>
                    <?php if (!empty($buttonSeeSmallaactive_font_style)) $css .= "font-style:$buttonSeeSmallaactive_font_style;";?>
                    <?php if (!empty($buttonSeeSmallaactive_text_decoration)) $css .= "text-decoration:$buttonSeeSmallaactive_text_decoration;";?>
                    <div id="buttonSeeSmallAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.button_see_small:active][font-family]" onchange="demo(this,'font-family','buttonSeeSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallaactive_font_family) && ($buttonSeeSmallaactive_font_family == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_size; ?></span><a title="<?php echo $help_size; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_size; ?>" name="Style[.button_see_small:active][font-size]" onchange="demo(this,'font-size','buttonSeeSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallaactive_font_size) && ($buttonSeeSmallaactive_font_size == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_weight; ?></span><a title="<?php echo $help_weight; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_weight; ?>" name="Style[.button_see_small:active][font-weight]" onchange="demo(this,'font-weight','buttonSeeSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallaactive_font_weight) && ($buttonSeeSmallaactive_font_weight == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_style; ?></span><a title="<?php echo $help_style; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_style; ?>" name="Style[.button_see_small:active][font-style]" onchange="demo(this,'font-style','buttonSeeSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallaactive_font_style) && ($buttonSeeSmallaactive_font_style == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.button_see_small:active][text-decoration]" onchange="demo(this,'text-decoration','buttonSeeSmallAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($buttonSeeSmallaactive_text_decoration) && ($buttonSeeSmallaactive_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        </div>
        
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$.tabs('.vtabs a');
</script> 

<script type="text/javascript" src="javascript/jquery/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="javascript/jquery/colorpicker/eye.js"></script>
<script type="text/javascript" src="javascript/jquery/colorpicker/utils.js"></script>
<script type="text/javascript" src="javascript/jquery/colorpicker/layout.js?ver=1.0.2"></script>
<script type="text/javascript">
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?r=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?r=common/filemanager/image&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<imgsrc="' + data + '" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');">');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
jQuery('#searchButtonA').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#searchButtonA span').css('backgroundColor', '#' + hex);
        $('#searchButtonADemo').css('color', '#' + hex);
        $("#searchButton_a").val('#'+hex);
    }
});
jQuery('#searchButtonAHover').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#searchButtonAHover span').css('backgroundColor', '#' + hex);
        $('#searchButtonAHoverDemo').css('color', '#' + hex);
        $("#searchButton_ahover").val('#'+hex);
    }
});
jQuery('#searchButtonAActive').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#searchButtonAActive span').css('backgroundColor', '#' + hex);
        $('#searchButtonAActiveDemo').css('color', '#' + hex);
        $("#searchButton_aactive").val('#'+hex);
    }
});
jQuery('#buttonAddSmallA').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#buttonAddSmallA span').css('backgroundColor', '#' + hex);
        $('#buttonAddSmallADemo').css('color', '#' + hex);
        $("#buttonAddSmall_a").val('#'+hex);
    }
});
jQuery('#buttonAddSmallAHover').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#buttonAddSmallAHover span').css('backgroundColor', '#' + hex);
        $('#buttonAddSmallAHoverDemo').css('color', '#' + hex);
        $("#buttonAddSmall_ahover").val('#'+hex);
    }
});
jQuery('#buttonAddSmallAActive').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#buttonAddSmallAActive span').css('backgroundColor', '#' + hex);
        $('#buttonAddSmallAActiveDemo').css('color', '#' + hex);
        $("#buttonAddSmall_aactive").val('#'+hex);
    }
});
jQuery('#buttonSeeSmallA').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#buttonSeeSmallA span').css('backgroundColor', '#' + hex);
        $('#buttonSeeSmallADemo').css('color', '#' + hex);
        $("#buttonSeeSmall_a").val('#'+hex);
    }
});
jQuery('#buttonSeeSmallAHover').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#buttonSeeSmallAHover span').css('backgroundColor', '#' + hex);
        $('#buttonSeeSmallAHoverDemo').css('color', '#' + hex);
        $("#buttonSeeSmall_ahover").val('#'+hex);
    }
});
jQuery('#buttonSeeSmallAActive').ColorPicker({
    color: '',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#buttonSeeSmallAActive span').css('backgroundColor', '#' + hex);
        $('#buttonSeeSmallAActiveDemo').css('color', '#' + hex);
        $("#buttonSeeSmall_aactive").val('#'+hex);
    }
});
function demo(element,selector,target) {
    jQuery('#' + target).css(selector,jQuery(element).val());
    
}
</script>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>