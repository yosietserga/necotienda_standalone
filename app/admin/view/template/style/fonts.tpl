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
      <a  tab="#tab_general"><?php echo $tab_general; ?></a>
      <a  tab="#tab_header"><?php echo $tab_header; ?></a>
      <a  tab="#tab_footer"><?php echo $tab_footer; ?></a>
      <a  tab="#tab_category_module"><?php echo $tab_category_module; ?></a>
      <a  tab="#tab_manufacturer_module"><?php echo $tab_manufacturer_module; ?></a>
      <a  tab="#tab_information_module"><?php echo $tab_information_module; ?></a>
      <a  tab="#tab_cart_module"><?php echo $tab_cart_module; ?></a>
      <a  tab="#tab_products"><?php echo $tab_products; ?></a>
    </div>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab_general" class="vtabs_page">
        <h1><?php echo $tab_general; ?></h1>
        <h2><?php echo $titles; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyH1">
                    <input type="text" id="body_h1" name="Style[h1][color]" value="<?php echo !empty($h1_color) ? $h1_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($h1_color) ? " style='background-color:".$h1_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($h1_color)) $css .= "color:$h1_color;";?>
                    <?php if (!empty($h1_font_family)) $css .= "font-family:$h1_color;";?>
                    <?php if (!empty($h1_font_size)) $css .= "font-size:$h1_font_size;";?>
                    <?php if (!empty($h1_font_weight)) $css .= "font-weight:$h1_font_weight;";?>
                    <?php if (!empty($h1_font_style)) $css .= "font-style:$h1_font_style;";?>
                    <?php if (!empty($h1_text_decoration)) $css .= "text-decoration:$h1_text_decoration;";?>
                    <div id="bodyH1Demo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[h1][font-family]" onchange="demo(this,'font-family','bodyH1Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($h1_font_family) && ($h1_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[h1][font-size]" onchange="demo(this,'font-size','bodyH1Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($h1_font_size) && ($h1_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[h1][font-weight]" onchange="demo(this,'font-weight','bodyH1Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($h1_font_weight) && ($h1_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[h1][font-style]" onchange="demo(this,'font-style','bodyH1Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($h1_font_style) && ($h1_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[h1][text-decoration]" onchange="demo(this,'text-decoration','bodyH1Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($h1_text_decoration) && ($h1_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2><?php echo $subtitles; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyH2">
                    <input type="text" id="body_h2" name="Style[h2][color]" value="<?php echo !empty($h2_color) ? $h2_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($h2_color) ? " style='background-color:".$h2_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($h2_color)) $css .= "color:$h2_color;";?>
                    <?php if (!empty($h2_font_family)) $css .= "font-family:$h2_color;";?>
                    <?php if (!empty($h2_font_size)) $css .= "font-size:$h2_font_size;";?>
                    <?php if (!empty($h2_font_weight)) $css .= "font-weight:$h2_font_weight;";?>
                    <?php if (!empty($h2_font_style)) $css .= "font-style:$h2_font_style;";?>
                    <?php if (!empty($h2_text_decoration)) $css .= "text-decoration:$h2_text_decoration;";?>
                    <div id="bodyH2Demo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[h2][font-family]" onchange="demo(this,'font-family','bodyH2Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($h2_font_family) && ($h2_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[h2][font-size]" onchange="demo(this,'font-size','bodyH2Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($h2_font_size) && ($h2_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[h2][font-weight]" onchange="demo(this,'font-weight','bodyH2Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($h2_font_weight) && ($h2_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[h2][font-style]" onchange="demo(this,'font-style','bodyH2Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($h2_font_style) && ($h2_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[h2][text-decoration]" onchange="demo(this,'text-decoration','bodyH2Demo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($h2_text_decoration) && ($h2_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2><?php echo $parrafos; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyP">
                    <input type="text" id="body_p" name="Style[p][color]" value="<?php echo !empty($p_color) ? $p_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($p_color) ? " style='background-color:".$p_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($p_color)) $css .= "color:$p_color;";?>
                    <?php if (!empty($p_font_family)) $css .= "font-family:$p_color;";?>
                    <?php if (!empty($p_font_size)) $css .= "font-size:$p_font_size;";?>
                    <?php if (!empty($p_font_weight)) $css .= "font-weight:$p_font_weight;";?>
                    <?php if (!empty($p_font_style)) $css .= "font-style:$p_font_style;";?>
                    <?php if (!empty($p_text_decoration)) $css .= "text-decoration:$p_text_decoration;";?>
                    <div id="bodyPDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[p][font-family]" onchange="demo(this,'font-family','bodyPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($p_font_family) && ($p_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[p][font-size]" onchange="demo(this,'font-size','bodyPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($p_font_size) && ($p_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[p][font-weight]" onchange="demo(this,'font-weight','bodyPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($p_font_weight) && ($p_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[p][font-style]" onchange="demo(this,'font-style','bodyPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($p_font_style) && ($p_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[p][text-decoration]" onchange="demo(this,'text-decoration','bodyPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($p_text_decoration) && ($p_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2><?php echo $enfasis; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyB">
                    <input type="text" id="body_b" name="Style[b][color]" value="<?php echo !empty($b_color) ? $b_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($b_color) ? " style='background-color:".$b_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($b_color)) $css .= "color:$b_color;";?>
                    <?php if (!empty($b_font_family)) $css .= "font-family:$b_color;";?>
                    <?php if (!empty($b_font_size)) $css .= "font-size:$b_font_size;";?>
                    <?php if (!empty($b_font_weight)) $css .= "font-weight:$b_font_weight;";?>
                    <?php if (!empty($b_font_style)) $css .= "font-style:$b_font_style;";?>
                    <?php if (!empty($b_text_decoration)) $css .= "text-decoration:$b_text_decoration;";?>
                    <div id="bodyBDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[b][font-family]" onchange="demo(this,'font-family','bodyBDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($b_font_family) && ($b_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[b][font-size]" onchange="demo(this,'font-size','bodyBDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($b_font_size) && ($b_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[b][font-weight]" onchange="demo(this,'font-weight','bodyBDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($b_font_weight) && ($b_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[b][font-style]" onchange="demo(this,'font-style','bodyBDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($b_font_style) && ($b_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[b][text-decoration]" onchange="demo(this,'text-decoration','bodyBDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($b_text_decoration) && ($b_text_decoration == $key)) { ?>
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
        
        <div id="tab_header" class="vtabs_page">
        <h1><?php echo $tab_header; ?></h1>
        <h2><?php echo $busqueda; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="headerSearch">
                    <input type="text" id="headerSearch_input" name="Style[.searchInput][color]" value="<?php echo !empty($search_color) ? $search_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($search_color) ? " style='background-color:".$search_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($search_color)) $css .= "color:$search_color;";?>
                    <?php if (!empty($search_font_family)) $css .= "font-family:$search_color;";?>
                    <?php if (!empty($search_font_size)) $css .= "font-size:$search_font_size;";?>
                    <?php if (!empty($search_font_weight)) $css .= "font-weight:$search_font_weight;";?>
                    <?php if (!empty($search_font_style)) $css .= "font-style:$search_font_style;";?>
                    <?php if (!empty($search_text_decoration)) $css .= "text-decoration:$search_text_decoration;";?>
                    <div id="headerSearchDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.searchInput][font-family]" onchange="demo(this,'font-family','headerSearchDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($search_font_family) && ($search_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.searchInput][font-size]" onchange="demo(this,'font-size','headerSearchDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($search_font_size) && ($search_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.searchInput][font-weight]" onchange="demo(this,'font-weight','headerSearchDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($search_font_weight) && ($search_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.searchInput][font-style]" onchange="demo(this,'font-style','headerSearchDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($search_font_style) && ($search_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.searchInput][text-decoration]" onchange="demo(this,'text-decoration','headerSearchDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($search_text_decoration) && ($search_text_decoration == $key)) { ?>
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
        
        <div id="tab_footer" class="vtabs_page">
            <h1><?php echo $tab_footer; ?></h1>
            
        <h2><?php echo $parrafos; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="footerP">
                    <input type="text" id="footer_p" name="Style[#footer p][color]" value="<?php echo !empty($footerP_color) ? $footerP_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($footerP_color) ? " style='background-color:".$footerP_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($footerP_color)) $css .= "color:$footerP_color;";?>
                    <?php if (!empty($footerP_font_family)) $css .= "font-family:$footerP_color;";?>
                    <?php if (!empty($footerP_font_size)) $css .= "font-size:$footerP_font_size;";?>
                    <?php if (!empty($footerP_font_weight)) $css .= "font-weight:$footerP_font_weight;";?>
                    <?php if (!empty($footerP_font_style)) $css .= "font-style:$footerP_font_style;";?>
                    <?php if (!empty($footerP_text_decoration)) $css .= "text-decoration:$footerP_text_decoration;";?>
                    <div id="footerPDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#footer p][font-family]" onchange="demo(this,'font-family','footerPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($footerP_font_family) && ($footerP_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#footer p][font-size]" onchange="demo(this,'font-size','footerPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($footerP_font_size) && ($footerP_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#footer p][font-weight]" onchange="demo(this,'font-weight','footerPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($footerP_font_weight) && ($footerP_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#footer p][font-style]" onchange="demo(this,'font-style','footerPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($footerP_font_style) && ($footerP_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#footer p][text-decoration]" onchange="demo(this,'text-decoration','footerPDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($footerP_text_decoration) && ($footerP_text_decoration == $key)) { ?>
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
        
        <div id="tab_category_module" class="vtabs_page">
            <h1><?php echo $tab_category_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="categoryModuleHeader">
                    <input type="text" id="categoryModule_header" name="Style[.categoryModule .header][color]" value="<?php echo !empty($categoryModuleHeader_color) ? $categoryModuleHeader_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($categoryModuleHeader_color) ? " style='background-color:".$categoryModuleHeader_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($categoryModuleHeader_color)) $css .= "color:$categoryModuleHeader_color;";?>
                    <?php if (!empty($categoryModuleHeader_font_family)) $css .= "font-family:$categoryModuleHeader_color;";?>
                    <?php if (!empty($categoryModuleHeader_font_size)) $css .= "font-size:$categoryModuleHeader_font_size;";?>
                    <?php if (!empty($categoryModuleHeader_font_weight)) $css .= "font-weight:$categoryModuleHeader_font_weight;";?>
                    <?php if (!empty($categoryModuleHeader_font_style)) $css .= "font-style:$categoryModuleHeader_font_style;";?>
                    <?php if (!empty($categoryModuleHeader_text_decoration)) $css .= "text-decoration:$categoryModuleHeader_text_decoration;";?>
                    <div id="categoryModuleHeaderDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.categoryModule .header][text-decoration]" onchange="demo(this,'text-decoration','categoryModuleHeaderDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($categoryModuleHeader_text_decoration) && ($categoryModuleHeader_text_decoration == $key)) { ?>
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
        
        <div id="tab_manufacturer_module" class="vtabs_page">
            <h1><?php echo $tab_manufacturer_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="manufacturerModuleHeader">
                    <input type="text" id="manufacturerModule_header" name="Style[.manufacturerModule .header][color]" value="<?php echo !empty($manufacturerModuleHeader_color) ? $manufacturerModuleHeader_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($manufacturerModuleHeader_color) ? " style='background-color:".$manufacturerModuleHeader_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($manufacturerModuleHeader_color)) $css .= "color:$manufacturerModuleHeader_color;";?>
                    <?php if (!empty($manufacturerModuleHeader_font_family)) $css .= "font-family:$manufacturerModuleHeader_color;";?>
                    <?php if (!empty($manufacturerModuleHeader_font_size)) $css .= "font-size:$manufacturerModuleHeader_font_size;";?>
                    <?php if (!empty($manufacturerModuleHeader_font_weight)) $css .= "font-weight:$manufacturerModuleHeader_font_weight;";?>
                    <?php if (!empty($manufacturerModuleHeader_font_style)) $css .= "font-style:$manufacturerModuleHeader_font_style;";?>
                    <?php if (!empty($manufacturerModuleHeader_text_decoration)) $css .= "text-decoration:$manufacturerModuleHeader_text_decoration;";?>
                    <div id="manufacturerModuleHeaderDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.manufacturerModule .header][text-decoration]" onchange="demo(this,'text-decoration','manufacturerModuleHeaderDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($manufacturerModuleHeader_text_decoration) && ($manufacturerModuleHeader_text_decoration == $key)) { ?>
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
        
        <div id="tab_information_module" class="vtabs_page">
            <h1><?php echo $tab_information_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="informationModuleHeader">
                    <input type="text" id="informationModule_header" name="Style[.informationModule .header][color]" value="<?php echo !empty($informationModuleHeader_color) ? $informationModuleHeader_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($informationModuleHeader_color) ? " style='background-color:".$informationModuleHeader_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($informationModuleHeader_color)) $css .= "color:$informationModuleHeader_color;";?>
                    <?php if (!empty($informationModuleHeader_font_family)) $css .= "font-family:$informationModuleHeader_color;";?>
                    <?php if (!empty($informationModuleHeader_font_size)) $css .= "font-size:$informationModuleHeader_font_size;";?>
                    <?php if (!empty($informationModuleHeader_font_weight)) $css .= "font-weight:$informationModuleHeader_font_weight;";?>
                    <?php if (!empty($informationModuleHeader_font_style)) $css .= "font-style:$informationModuleHeader_font_style;";?>
                    <?php if (!empty($informationModuleHeader_text_decoration)) $css .= "text-decoration:$informationModuleHeader_text_decoration;";?>
                    <div id="informationModuleHeaderDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.informationModule .header][text-decoration]" onchange="demo(this,'text-decoration','informationModuleHeaderDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($informationModuleHeader_text_decoration) && ($informationModuleHeader_text_decoration == $key)) { ?>
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
        
        <div id="tab_cart_module" class="vtabs_page">
            <h1><?php echo $tab_cart_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="cartModuleHeader">
                    <input type="text" id="cartModule_header" name="Style[.cartModule .header][color]" value="<?php echo !empty($cartModuleHeader_color) ? $cartModuleHeader_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($cartModuleHeader_color) ? " style='background-color:".$cartModuleHeader_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($cartModuleHeader_color)) $css .= "color:$cartModuleHeader_color;";?>
                    <?php if (!empty($cartModuleHeader_font_family)) $css .= "font-family:$cartModuleHeader_color;";?>
                    <?php if (!empty($cartModuleHeader_font_size)) $css .= "font-size:$cartModuleHeader_font_size;";?>
                    <?php if (!empty($cartModuleHeader_font_weight)) $css .= "font-weight:$cartModuleHeader_font_weight;";?>
                    <?php if (!empty($cartModuleHeader_font_style)) $css .= "font-style:$cartModuleHeader_font_style;";?>
                    <?php if (!empty($cartModuleHeader_text_decoration)) $css .= "text-decoration:$cartModuleHeader_text_decoration;";?>
                    <div id="cartModuleHeaderDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_decoration; ?></span><a title="<?php echo $help_decoration; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_decoration; ?>" name="Style[.cartModule .header][text-decoration]" onchange="demo(this,'text-decoration','cartModuleHeaderDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($cartModuleHeader_text_decoration) && ($cartModuleHeader_text_decoration == $key)) { ?>
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
            
        <h2>GRID - Nombre del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="gridViewName">
                    <input type="text" id="gridView_name" name="Style[.grid_view .name][color]" value="<?php echo !empty($gridViewName_color) ? $gridViewName_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($gridViewName_color) ? " style='background-color:".$gridViewName_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($gridViewName_color)) $css .= "color:$gridViewName_color;";?>
                    <?php if (!empty($gridViewName_font_family)) $css .= "font-family:$gridViewName_color;";?>
                    <?php if (!empty($gridViewName_font_size)) $css .= "font-size:$gridViewName_font_size;";?>
                    <?php if (!empty($gridViewName_font_weight)) $css .= "font-weight:$gridViewName_font_weight;";?>
                    <?php if (!empty($gridViewName_font_style)) $css .= "font-style:$gridViewName_font_style;";?>
                    <?php if (!empty($gridViewName_text_decoration)) $css .= "text-decoration:$gridViewName_text_decoration;";?>
                    <div id="gridViewNameDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.grid_view .name][font-family]" onchange="demo(this,'font-family','gridViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($gridViewName_font_family) && ($gridViewName_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.grid_view .name][font-size]" onchange="demo(this,'font-size','gridViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($gridViewName_font_size) && ($gridViewName_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.grid_view .name][font-weight]" onchange="demo(this,'font-weight','gridViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($gridViewName_font_weight) && ($gridViewName_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.grid_view .name][font-style]" onchange="demo(this,'font-style','gridViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($gridViewName_font_style) && ($gridViewName_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.grid_view .name][text-decoration]" onchange="demo(this,'text-decoration','gridViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($gridViewName_text_decoration) && ($gridViewName_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>GRID - Modelo del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="gridViewModel">
                    <input type="text" id="gridView_model" name="Style[.grid_view .model][color]" value="<?php echo !empty($gridViewModel_color) ? $gridViewModel_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($gridViewModel_color) ? " style='background-color:".$gridViewModel_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($gridViewModel_color)) $css .= "color:$gridViewModel_color;";?>
                    <?php if (!empty($gridViewModel_font_family)) $css .= "font-family:$gridViewModel_color;";?>
                    <?php if (!empty($gridViewModel_font_size)) $css .= "font-size:$gridViewModel_font_size;";?>
                    <?php if (!empty($gridViewModel_font_weight)) $css .= "font-weight:$gridViewModel_font_weight;";?>
                    <?php if (!empty($gridViewModel_font_style)) $css .= "font-style:$gridViewModel_font_style;";?>
                    <?php if (!empty($gridViewModel_text_decoration)) $css .= "text-decoration:$gridViewModel_text_decoration;";?>
                    <div id="gridViewModelDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.grid_view .model][font-family]" onchange="demo(this,'font-family','gridViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($gridViewModel_font_family) && ($gridViewModel_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.grid_view .model][font-size]" onchange="demo(this,'font-size','gridViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($gridViewModel_font_size) && ($gridViewModel_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.grid_view .model][font-weight]" onchange="demo(this,'font-weight','gridViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($gridViewModel_font_weight) && ($gridViewModel_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.grid_view .model][font-style]" onchange="demo(this,'font-style','gridViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($gridViewModel_font_style) && ($gridViewModel_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.grid_view .model][text-decoration]" onchange="demo(this,'text-decoration','gridViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($gridViewModel_text_decoration) && ($gridViewModel_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>GRID - Precio del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="gridViewPrice">
                    <input type="text" id="gridView_price" name="Style[.grid_view .price][color]" value="<?php echo !empty($gridViewPrice_color) ? $gridViewPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($gridViewPrice_color) ? " style='background-color:".$gridViewPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($gridViewPrice_color)) $css .= "color:$gridViewPrice_color;";?>
                    <?php if (!empty($gridViewPrice_font_family)) $css .= "font-family:$gridViewPrice_color;";?>
                    <?php if (!empty($gridViewPrice_font_size)) $css .= "font-size:$gridViewPrice_font_size;";?>
                    <?php if (!empty($gridViewPrice_font_weight)) $css .= "font-weight:$gridViewPrice_font_weight;";?>
                    <?php if (!empty($gridViewPrice_font_style)) $css .= "font-style:$gridViewPrice_font_style;";?>
                    <?php if (!empty($gridViewPrice_text_decoration)) $css .= "text-decoration:$gridViewPrice_text_decoration;";?>
                    <div id="gridViewPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.grid_view .price][font-family]" onchange="demo(this,'font-family','gridViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($gridViewPrice_font_family) && ($gridViewPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.grid_view .price][font-size]" onchange="demo(this,'font-size','gridViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($gridViewPrice_font_size) && ($gridViewPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.grid_view .price][font-weight]" onchange="demo(this,'font-weight','gridViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($gridViewPrice_font_weight) && ($gridViewPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.grid_view .price][font-style]" onchange="demo(this,'font-style','gridViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($gridViewPrice_font_style) && ($gridViewPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.grid_view .price][text-decoration]" onchange="demo(this,'text-decoration','gridViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($gridViewPrice_text_decoration) && ($gridViewPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>GRID - Precio Nuevo</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="gridViewNewPrice">
                    <input type="text" id="gridView_new_price" name="Style[.grid_view .new_price][color]" value="<?php echo !empty($gridViewNewPrice_color) ? $gridViewNewPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($gridViewNewPrice_color) ? " style='background-color:".$gridViewNewPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($gridViewNewPrice_color)) $css .= "color:$gridViewNewPrice_color;";?>
                    <?php if (!empty($gridViewNewPrice_font_family)) $css .= "font-family:$gridViewNewPrice_color;";?>
                    <?php if (!empty($gridViewNewPrice_font_size)) $css .= "font-size:$gridViewNewPrice_font_size;";?>
                    <?php if (!empty($gridViewNewPrice_font_weight)) $css .= "font-weight:$gridViewNewPrice_font_weight;";?>
                    <?php if (!empty($gridViewNewPrice_font_style)) $css .= "font-style:$gridViewNewPrice_font_style;";?>
                    <?php if (!empty($gridViewNewPrice_text_decoration)) $css .= "text-decoration:$gridViewNewPrice_text_decoration;";?>
                    <div id="gridViewNewPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.grid_view .new_price][font-family]" onchange="demo(this,'font-family','gridViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($gridViewNewPrice_font_family) && ($gridViewNewPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.grid_view .new_price][font-size]" onchange="demo(this,'font-size','gridViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($gridViewNewPrice_font_size) && ($gridViewNewPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.grid_view .new_price][font-weight]" onchange="demo(this,'font-weight','gridViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($gridViewNewPrice_font_weight) && ($gridViewNewPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.grid_view .new_price][font-style]" onchange="demo(this,'font-style','gridViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($gridViewNewPrice_font_style) && ($gridViewNewPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.grid_view .new_price][text-decoration]" onchange="demo(this,'text-decoration','gridViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($gridViewNewPrice_text_decoration) && ($gridViewNewPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>GRID - Precio Viejo</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="gridViewOldPrice">
                    <input type="text" id="gridView_old_price" name="Style[.grid_view .old_price][color]" value="<?php echo !empty($gridViewOldPrice_color) ? $gridViewOldPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($gridViewOldPrice_color) ? " style='background-color:".$gridViewOldPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($gridViewOldPrice_color)) $css .= "color:$gridViewOldPrice_color;";?>
                    <?php if (!empty($gridViewOldPrice_font_family)) $css .= "font-family:$gridViewOldPrice_color;";?>
                    <?php if (!empty($gridViewOldPrice_font_size)) $css .= "font-size:$gridViewOldPrice_font_size;";?>
                    <?php if (!empty($gridViewOldPrice_font_weight)) $css .= "font-weight:$gridViewOldPrice_font_weight;";?>
                    <?php if (!empty($gridViewOldPrice_font_style)) $css .= "font-style:$gridViewOldPrice_font_style;";?>
                    <?php if (!empty($gridViewOldPrice_text_decoration)) $css .= "text-decoration:$gridViewOldPrice_text_decoration;";?>
                    <div id="gridViewOldPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.grid_view .old_price][font-family]" onchange="demo(this,'font-family','gridViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($gridViewOldPrice_font_family) && ($gridViewOldPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.grid_view .old_price][font-size]" onchange="demo(this,'font-size','gridViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($gridViewOldPrice_font_size) && ($gridViewOldPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.grid_view .old_price][font-weight]" onchange="demo(this,'font-weight','gridViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($gridViewOldPrice_font_weight) && ($gridViewOldPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.grid_view .old_price][font-style]" onchange="demo(this,'font-style','gridViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($gridViewOldPrice_font_style) && ($gridViewOldPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.grid_view .old_price][text-decoration]" onchange="demo(this,'text-decoration','gridViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($gridViewOldPrice_text_decoration) && ($gridViewOldPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>LIST - Nombre del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="listViewName">
                    <input type="text" id="listView_name" name="Style[.list_view .name][color]" value="<?php echo !empty($listViewName_color) ? $listViewName_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($listViewName_color) ? " style='background-color:".$listViewName_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($listViewName_color)) $css .= "color:$listViewName_color;";?>
                    <?php if (!empty($listViewName_font_family)) $css .= "font-family:$listViewName_color;";?>
                    <?php if (!empty($listViewName_font_size)) $css .= "font-size:$listViewName_font_size;";?>
                    <?php if (!empty($listViewName_font_weight)) $css .= "font-weight:$listViewName_font_weight;";?>
                    <?php if (!empty($listViewName_font_style)) $css .= "font-style:$listViewName_font_style;";?>
                    <?php if (!empty($listViewName_text_decoration)) $css .= "text-decoration:$listViewName_text_decoration;";?>
                    <div id="listViewNameDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.list_view .name][font-family]" onchange="demo(this,'font-family','listViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($listViewName_font_family) && ($listViewName_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.list_view .name][font-size]" onchange="demo(this,'font-size','listViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($listViewName_font_size) && ($listViewName_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.list_view .name][font-weight]" onchange="demo(this,'font-weight','listViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($listViewName_font_weight) && ($listViewName_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.list_view .name][font-style]" onchange="demo(this,'font-style','listViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($listViewName_font_style) && ($listViewName_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.list_view .name][text-decoration]" onchange="demo(this,'text-decoration','listViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($listViewName_text_decoration) && ($listViewName_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>LIST - Modelo del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="listViewModel">
                    <input type="text" id="listView_model" name="Style[.list_view .model][color]" value="<?php echo !empty($listViewModel_color) ? $listViewModel_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($listViewModel_color) ? " style='background-color:".$listViewModel_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($listViewModel_color)) $css .= "color:$listViewModel_color;";?>
                    <?php if (!empty($listViewModel_font_family)) $css .= "font-family:$listViewModel_color;";?>
                    <?php if (!empty($listViewModel_font_size)) $css .= "font-size:$listViewModel_font_size;";?>
                    <?php if (!empty($listViewModel_font_weight)) $css .= "font-weight:$listViewModel_font_weight;";?>
                    <?php if (!empty($listViewModel_font_style)) $css .= "font-style:$listViewModel_font_style;";?>
                    <?php if (!empty($listViewModel_text_decoration)) $css .= "text-decoration:$listViewModel_text_decoration;";?>
                    <div id="listViewModelDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.list_view .model][font-family]" onchange="demo(this,'font-family','listViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($listViewModel_font_family) && ($listViewModel_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.list_view .model][font-size]" onchange="demo(this,'font-size','listViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($listViewModel_font_size) && ($listViewModel_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.list_view .model][font-weight]" onchange="demo(this,'font-weight','listViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($listViewModel_font_weight) && ($listViewModel_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.list_view .model][font-style]" onchange="demo(this,'font-style','listViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($listViewModel_font_style) && ($listViewModel_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.list_view .model][text-decoration]" onchange="demo(this,'text-decoration','listViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($listViewModel_text_decoration) && ($listViewModel_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>LIST - Precio del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="listViewPrice">
                    <input type="text" id="listView_price" name="Style[.list_view .price][color]" value="<?php echo !empty($listViewPrice_color) ? $listViewPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($listViewPrice_color) ? " style='background-color:".$listViewPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($listViewPrice_color)) $css .= "color:$listViewPrice_color;";?>
                    <?php if (!empty($listViewPrice_font_family)) $css .= "font-family:$listViewPrice_color;";?>
                    <?php if (!empty($listViewPrice_font_size)) $css .= "font-size:$listViewPrice_font_size;";?>
                    <?php if (!empty($listViewPrice_font_weight)) $css .= "font-weight:$listViewPrice_font_weight;";?>
                    <?php if (!empty($listViewPrice_font_style)) $css .= "font-style:$listViewPrice_font_style;";?>
                    <?php if (!empty($listViewPrice_text_decoration)) $css .= "text-decoration:$listViewPrice_text_decoration;";?>
                    <div id="listViewPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.list_view .price][font-family]" onchange="demo(this,'font-family','listViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($listViewPrice_font_family) && ($listViewPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.list_view .price][font-size]" onchange="demo(this,'font-size','listViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($listViewPrice_font_size) && ($listViewPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.list_view .price][font-weight]" onchange="demo(this,'font-weight','listViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($listViewPrice_font_weight) && ($listViewPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.list_view .price][font-style]" onchange="demo(this,'font-style','listViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($listViewPrice_font_style) && ($listViewPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.list_view .price][text-decoration]" onchange="demo(this,'text-decoration','listViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($listViewPrice_text_decoration) && ($listViewPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>LIST - Precio Nuevo</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="listViewNewPrice">
                    <input type="text" id="listView_new_price" name="Style[.list_view .new_price][color]" value="<?php echo !empty($listViewNewPrice_color) ? $listViewNewPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($listViewNewPrice_color) ? " style='background-color:".$listViewNewPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($listViewNewPrice_color)) $css .= "color:$listViewNewPrice_color;";?>
                    <?php if (!empty($listViewNewPrice_font_family)) $css .= "font-family:$listViewNewPrice_color;";?>
                    <?php if (!empty($listViewNewPrice_font_size)) $css .= "font-size:$listViewNewPrice_font_size;";?>
                    <?php if (!empty($listViewNewPrice_font_weight)) $css .= "font-weight:$listViewNewPrice_font_weight;";?>
                    <?php if (!empty($listViewNewPrice_font_style)) $css .= "font-style:$listViewNewPrice_font_style;";?>
                    <?php if (!empty($listViewNewPrice_text_decoration)) $css .= "text-decoration:$listViewNewPrice_text_decoration;";?>
                    <div id="listViewNewPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.list_view .new_price][font-family]" onchange="demo(this,'font-family','listViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($listViewNewPrice_font_family) && ($listViewNewPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.list_view .new_price][font-size]" onchange="demo(this,'font-size','listViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($listViewNewPrice_font_size) && ($listViewNewPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.list_view .new_price][font-weight]" onchange="demo(this,'font-weight','listViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($listViewNewPrice_font_weight) && ($listViewNewPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.list_view .new_price][font-style]" onchange="demo(this,'font-style','listViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($listViewNewPrice_font_style) && ($listViewNewPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.list_view .new_price][text-decoration]" onchange="demo(this,'text-decoration','listViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($listViewNewPrice_text_decoration) && ($listViewNewPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>LIST - Precio Viejo</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="listViewOldPrice">
                    <input type="text" id="listView_old_price" name="Style[.list_view .old_price][color]" value="<?php echo !empty($listViewOldPrice_color) ? $listViewOldPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($listViewOldPrice_color) ? " style='background-color:".$listViewOldPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($listViewOldPrice_color)) $css .= "color:$listViewOldPrice_color;";?>
                    <?php if (!empty($listViewOldPrice_font_family)) $css .= "font-family:$listViewOldPrice_color;";?>
                    <?php if (!empty($listViewOldPrice_font_size)) $css .= "font-size:$listViewOldPrice_font_size;";?>
                    <?php if (!empty($listViewOldPrice_font_weight)) $css .= "font-weight:$listViewOldPrice_font_weight;";?>
                    <?php if (!empty($listViewOldPrice_font_style)) $css .= "font-style:$listViewOldPrice_font_style;";?>
                    <?php if (!empty($listViewOldPrice_text_decoration)) $css .= "text-decoration:$listViewOldPrice_text_decoration;";?>
                    <div id="listViewOldPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.list_view .old_price][font-family]" onchange="demo(this,'font-family','listViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($listViewOldPrice_font_family) && ($listViewOldPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.list_view .old_price][font-size]" onchange="demo(this,'font-size','listViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($listViewOldPrice_font_size) && ($listViewOldPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.list_view .old_price][font-weight]" onchange="demo(this,'font-weight','listViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($listViewOldPrice_font_weight) && ($listViewOldPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.list_view .old_price][font-style]" onchange="demo(this,'font-style','listViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($listViewOldPrice_font_style) && ($listViewOldPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.list_view .old_price][text-decoration]" onchange="demo(this,'text-decoration','listViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($listViewOldPrice_text_decoration) && ($listViewOldPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>OVERVIEW - Nombre del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="overViewName">
                    <input type="text" id="overView_name" name="Style[#overview .name][color]" value="<?php echo !empty($overViewName_color) ? $overViewName_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($overViewName_color) ? " style='background-color:".$overViewName_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($overViewName_color)) $css .= "color:$overViewName_color;";?>
                    <?php if (!empty($overViewName_font_family)) $css .= "font-family:$overViewName_color;";?>
                    <?php if (!empty($overViewName_font_size)) $css .= "font-size:$overViewName_font_size;";?>
                    <?php if (!empty($overViewName_font_weight)) $css .= "font-weight:$overViewName_font_weight;";?>
                    <?php if (!empty($overViewName_font_style)) $css .= "font-style:$overViewName_font_style;";?>
                    <?php if (!empty($overViewName_text_decoration)) $css .= "text-decoration:$overViewName_text_decoration;";?>
                    <div id="overViewNameDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#overview .name][font-family]" onchange="demo(this,'font-family','overViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($overViewName_font_family) && ($overViewName_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#overview .name][font-size]" onchange="demo(this,'font-size','overViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($overViewName_font_size) && ($overViewName_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#overview .name][font-weight]" onchange="demo(this,'font-weight','overViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($overViewName_font_weight) && ($overViewName_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#overview .name][font-style]" onchange="demo(this,'font-style','overViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($overViewName_font_style) && ($overViewName_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#overview .name][text-decoration]" onchange="demo(this,'text-decoration','overViewNameDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($overViewName_text_decoration) && ($overViewName_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>OVERVIEW - Modelo del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="overViewModel">
                    <input type="text" id="overView_model" name="Style[#overview .model][color]" value="<?php echo !empty($overViewModel_color) ? $overViewModel_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($overViewModel_color) ? " style='background-color:".$overViewModel_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($overViewModel_color)) $css .= "color:$overViewModel_color;";?>
                    <?php if (!empty($overViewModel_font_family)) $css .= "font-family:$overViewModel_color;";?>
                    <?php if (!empty($overViewModel_font_size)) $css .= "font-size:$overViewModel_font_size;";?>
                    <?php if (!empty($overViewModel_font_weight)) $css .= "font-weight:$overViewModel_font_weight;";?>
                    <?php if (!empty($overViewModel_font_style)) $css .= "font-style:$overViewModel_font_style;";?>
                    <?php if (!empty($overViewModel_text_decoration)) $css .= "text-decoration:$overViewModel_text_decoration;";?>
                    <div id="overViewModelDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#overview .model][font-family]" onchange="demo(this,'font-family','overViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($overViewModel_font_family) && ($overViewModel_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#overview .model][font-size]" onchange="demo(this,'font-size','overViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($overViewModel_font_size) && ($overViewModel_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#overview .model][font-weight]" onchange="demo(this,'font-weight','overViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($overViewModel_font_weight) && ($overViewModel_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#overview .model][font-style]" onchange="demo(this,'font-style','overViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($overViewModel_font_style) && ($overViewModel_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#overview .model][text-decoration]" onchange="demo(this,'text-decoration','overViewModelDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($overViewModel_text_decoration) && ($overViewModel_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>OVERVIEW - Precio del Producto</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="overViewPrice">
                    <input type="text" id="overView_price" name="Style[#overview .price][color]" value="<?php echo !empty($overViewPrice_color) ? $overViewPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($overViewPrice_color) ? " style='background-color:".$overViewPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($overViewPrice_color)) $css .= "color:$overViewPrice_color;";?>
                    <?php if (!empty($overViewPrice_font_family)) $css .= "font-family:$overViewPrice_color;";?>
                    <?php if (!empty($overViewPrice_font_size)) $css .= "font-size:$overViewPrice_font_size;";?>
                    <?php if (!empty($overViewPrice_font_weight)) $css .= "font-weight:$overViewPrice_font_weight;";?>
                    <?php if (!empty($overViewPrice_font_style)) $css .= "font-style:$overViewPrice_font_style;";?>
                    <?php if (!empty($overViewPrice_text_decoration)) $css .= "text-decoration:$overViewPrice_text_decoration;";?>
                    <div id="overViewPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#overview .price][font-family]" onchange="demo(this,'font-family','overViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($overViewPrice_font_family) && ($overViewPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#overview .price][font-size]" onchange="demo(this,'font-size','overViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($overViewPrice_font_size) && ($overViewPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#overview .price][font-weight]" onchange="demo(this,'font-weight','overViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($overViewPrice_font_weight) && ($overViewPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#overview .price][font-style]" onchange="demo(this,'font-style','overViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($overViewPrice_font_style) && ($overViewPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#overview .price][text-decoration]" onchange="demo(this,'text-decoration','overViewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($overViewPrice_text_decoration) && ($overViewPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>OVERVIEW - Precio Nuevo</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="overViewNewPrice">
                    <input type="text" id="overView_new_price" name="Style[#overview .new_price][color]" value="<?php echo !empty($overViewNewPrice_color) ? $overViewNewPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($overViewNewPrice_color) ? " style='background-color:".$overViewNewPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($overViewNewPrice_color)) $css .= "color:$overViewNewPrice_color;";?>
                    <?php if (!empty($overViewNewPrice_font_family)) $css .= "font-family:$overViewNewPrice_color;";?>
                    <?php if (!empty($overViewNewPrice_font_size)) $css .= "font-size:$overViewNewPrice_font_size;";?>
                    <?php if (!empty($overViewNewPrice_font_weight)) $css .= "font-weight:$overViewNewPrice_font_weight;";?>
                    <?php if (!empty($overViewNewPrice_font_style)) $css .= "font-style:$overViewNewPrice_font_style;";?>
                    <?php if (!empty($overViewNewPrice_text_decoration)) $css .= "text-decoration:$overViewNewPrice_text_decoration;";?>
                    <div id="overViewNewPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#overview .new_price][font-family]" onchange="demo(this,'font-family','overViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($overViewNewPrice_font_family) && ($overViewNewPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#overview .new_price][font-size]" onchange="demo(this,'font-size','overViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($overViewNewPrice_font_size) && ($overViewNewPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#overview .new_price][font-weight]" onchange="demo(this,'font-weight','overViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($overViewNewPrice_font_weight) && ($overViewNewPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#overview .new_price][font-style]" onchange="demo(this,'font-style','overViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($overViewNewPrice_font_style) && ($overViewNewPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#overview .new_price][text-decoration]" onchange="demo(this,'text-decoration','overViewNewPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($overViewNewPrice_text_decoration) && ($overViewNewPrice_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        <h2>OVERVIEW - Precio Viejo</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="overViewOldPrice">
                    <input type="text" id="overView_old_price" name="Style[#overview .old_price][color]" value="<?php echo !empty($overViewOldPrice_color) ? $overViewOldPrice_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($overViewOldPrice_color) ? " style='background-color:".$overViewOldPrice_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($overViewOldPrice_color)) $css .= "color:$overViewOldPrice_color;";?>
                    <?php if (!empty($overViewOldPrice_font_family)) $css .= "font-family:$overViewOldPrice_color;";?>
                    <?php if (!empty($overViewOldPrice_font_size)) $css .= "font-size:$overViewOldPrice_font_size;";?>
                    <?php if (!empty($overViewOldPrice_font_weight)) $css .= "font-weight:$overViewOldPrice_font_weight;";?>
                    <?php if (!empty($overViewOldPrice_font_style)) $css .= "font-style:$overViewOldPrice_font_style;";?>
                    <?php if (!empty($overViewOldPrice_text_decoration)) $css .= "text-decoration:$overViewOldPrice_text_decoration;";?>
                    <div id="overViewOldPriceDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#overview .old_price][font-family]" onchange="demo(this,'font-family','overViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($overViewOldPrice_font_family) && ($overViewOldPrice_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#overview .old_price][font-size]" onchange="demo(this,'font-size','overViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($overViewOldPrice_font_size) && ($overViewOldPrice_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#overview .old_price][font-weight]" onchange="demo(this,'font-weight','overViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($overViewOldPrice_font_weight) && ($overViewOldPrice_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#overview .old_price][font-style]" onchange="demo(this,'font-style','overViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($overViewOldPrice_font_style) && ($overViewOldPrice_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#overview .old_price][text-decoration]" onchange="demo(this,'text-decoration','overViewOldPriceDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($overViewOldPrice_text_decoration) && ($overViewOldPrice_text_decoration == $key)) { ?>
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
<script>
jQuery('#bodyH1').ColorPicker({
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
        $('#bodyH1 span').css('backgroundColor', '#' + hex);
        $('#bodyH1Demo').css('color', '#' + hex);
        $("#body_h1").val('#'+hex);
    }
});
jQuery('#bodyH2').ColorPicker({
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
        $('#bodyH2 span').css('backgroundColor', '#' + hex);
        $('#bodyH2Demo').css('color', '#' + hex);
        $("#body_h2").val('#'+hex);
    }
});
jQuery('#bodyP').ColorPicker({
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
        $('#bodyP span').css('backgroundColor', '#' + hex);
        $('#bodyPDemo').css('color', '#' + hex);
        $("#body_p").val('#'+hex);
    }
});
jQuery('#bodyB').ColorPicker({
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
        $('#bodyB span').css('backgroundColor', '#' + hex);
        $('#bodyBDemo').css('color', '#' + hex);
        $("#body_b").val('#'+hex);
    }
});
jQuery('#headerSearch').ColorPicker({
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
        $('#headerSearch span').css('backgroundColor', '#' + hex);
        $('#headerSearchDemo').css('color', '#' + hex);
        $("#headerSearch_input").val('#'+hex);
    }
});
jQuery('#footerP').ColorPicker({
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
        $('#footerP span').css('backgroundColor', '#' + hex);
        $('#footerPDemo').css('color', '#' + hex);
        $("#footer_p").val('#'+hex);
    }
});
jQuery('#categoryModuleHeader').ColorPicker({
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
        $('#categoryModuleHeader span').css('backgroundColor', '#' + hex);
        $('#categoryModuleHeaderDemo').css('color', '#' + hex);
        $("#categoryModule_header").val('#'+hex);
    }
});
jQuery('#cartModuleHeader').ColorPicker({
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
        $('#cartModuleHeader span').css('backgroundColor', '#' + hex);
        $('#cartModuleHeaderDemo').css('color', '#' + hex);
        $("#cartModule_header").val('#'+hex);
    }
});
jQuery('#informationModuleHeader').ColorPicker({
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
        $('#informationModuleHeader span').css('backgroundColor', '#' + hex);
        $('#informationModuleHeaderDemo').css('color', '#' + hex);
        $("#informationModule_header").val('#'+hex);
    }
});
jQuery('#manufacturerModuleHeader').ColorPicker({
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
        $('#manufacturerModuleHeader span').css('backgroundColor', '#' + hex);
        $('#manufacturerModuleHeaderDemo').css('color', '#' + hex);
        $("#manufacturerModule_header").val('#'+hex);
    }
});
jQuery('#listViewName').ColorPicker({
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
        $('#listViewName span').css('backgroundColor', '#' + hex);
        $('#listViewNameDemo').css('color', '#' + hex);
        $("#listView_name").val('#'+hex);
    }
});
jQuery('#listViewModel').ColorPicker({
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
        $('#listViewModel span').css('backgroundColor', '#' + hex);
        $('#listViewModelDemo').css('color', '#' + hex);
        $("#listView_model").val('#'+hex);
    }
});
jQuery('#listViewPrice').ColorPicker({
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
        $('#listViewPrice span').css('backgroundColor', '#' + hex);
        $('#listViewPriceDemo').css('color', '#' + hex);
        $("#listView_price").val('#'+hex);
    }
});
jQuery('#listViewNewPrice').ColorPicker({
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
        $('#listViewNewPrice span').css('backgroundColor', '#' + hex);
        $('#listViewNewPriceDemo').css('color', '#' + hex);
        $("#listView_new_price").val('#'+hex);
    }
});
jQuery('#listViewOldPrice').ColorPicker({
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
        $('#listViewOldPrice span').css('backgroundColor', '#' + hex);
        $('#listViewOldPriceDemo').css('color', '#' + hex);
        $("#listView_old_price").val('#'+hex);
    }
});
jQuery('#gridViewName').ColorPicker({
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
        $('#gridViewName span').css('backgroundColor', '#' + hex);
        $('#gridViewNameDemo').css('color', '#' + hex);
        $("#gridView_name").val('#'+hex);
    }
});
jQuery('#gridViewModel').ColorPicker({
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
        $('#gridViewModel span').css('backgroundColor', '#' + hex);
        $('#gridViewModelDemo').css('color', '#' + hex);
        $("#gridView_model").val('#'+hex);
    }
});
jQuery('#gridViewPrice').ColorPicker({
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
        $('#gridViewPrice span').css('backgroundColor', '#' + hex);
        $('#gridViewPriceDemo').css('color', '#' + hex);
        $("#gridView_price").val('#'+hex);
    }
});
jQuery('#gridViewNewPrice').ColorPicker({
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
        $('#gridViewNewPrice span').css('backgroundColor', '#' + hex);
        $('#gridViewNewPriceDemo').css('color', '#' + hex);
        $("#gridView_new_price").val('#'+hex);
    }
});
jQuery('#gridViewOldPrice').ColorPicker({
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
        $('#gridViewOldPrice span').css('backgroundColor', '#' + hex);
        $('#gridViewOldPriceDemo').css('color', '#' + hex);
        $("#gridView_old_price").val('#'+hex);
    }
});
jQuery('#overViewName').ColorPicker({
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
        $('#overViewName span').css('backgroundColor', '#' + hex);
        $('#overViewNameDemo').css('color', '#' + hex);
        $("#overView_name").val('#'+hex);
    }
});
jQuery('#overViewModel').ColorPicker({
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
        $('#overViewModel span').css('backgroundColor', '#' + hex);
        $('#overViewModelDemo').css('color', '#' + hex);
        $("#overView_model").val('#'+hex);
    }
});
jQuery('#overViewPrice').ColorPicker({
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
        $('#overViewPrice span').css('backgroundColor', '#' + hex);
        $('#overViewPriceDemo').css('color', '#' + hex);
        $("#overView_price").val('#'+hex);
    }
});
jQuery('#overViewNewPrice').ColorPicker({
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
        $('#overViewNewPrice span').css('backgroundColor', '#' + hex);
        $('#overViewNewPriceDemo').css('color', '#' + hex);
        $("#overView_new_price").val('#'+hex);
    }
});
jQuery('#overViewOldPrice').ColorPicker({
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
        $('#overViewOldPrice span').css('backgroundColor', '#' + hex);
        $('#overViewOldPriceDemo').css('color', '#' + hex);
        $("#overView_old_price").val('#'+hex);
    }
});
function demo(element,selector,target) {
    jQuery('#' + target).css(selector,jQuery(element).val());
    
}
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('input[type=text]').css({'width':'250px'});
	jQuery('select').css({'width':'250px'});
});
</script> 
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>