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
      <a  tab="#tab_information_module"><?php echo $tab_information_module; ?></a>
      <a  tab="#tab_cart_module"><?php echo $tab_cart_module; ?></a>
    </div>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab_general" class="vtabs_page">
        <h1><?php echo $tab_general; ?></h1>
        <h2>Enlaces</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyA">
                    <input type="text" id="body_a" name="Style[a, a:visited][color]" value="<?php echo !empty($a_color) ? $a_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($a_color) ? " style='background-color:".$a_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($a_color)) $css .= "color:$a_color;";?>
                    <?php if (!empty($a_font_family)) $css .= "font-family:$a_color;";?>
                    <?php if (!empty($a_font_size)) $css .= "font-size:$a_font_size;";?>
                    <?php if (!empty($a_font_weight)) $css .= "font-weight:$a_font_weight;";?>
                    <?php if (!empty($a_font_style)) $css .= "font-style:$a_font_style;";?>
                    <?php if (!empty($a_text_decoration)) $css .= "text-decoration:$a_text_decoration;";?>
                    <div id="bodyADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[a, a:visited][font-family]" onchange="demo(this,'font-family','bodyADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($a_font_family) && ($a_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[a, a:visited][font-size]" onchange="demo(this,'font-size','bodyADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($a_font_size) && ($a_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[a, a:visited][font-weight]" onchange="demo(this,'font-weight','bodyADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($a_font_weight) && ($a_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[a, a:visited][font-style]" onchange="demo(this,'font-style','bodyADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($a_font_style) && ($a_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[a, a:visited][text-decoration]" onchange="demo(this,'text-decoration','bodyADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($a_text_decoration) && ($a_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Hover</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyAHover">
                    <input type="text" id="body_ahover" name="Style[a:hover][color]" value="<?php echo !empty($ahover_color) ? $ahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($ahover_color) ? " style='background-color:".$ahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($ahover_color)) $css .= "color:$ahover_color;";?>
                    <?php if (!empty($ahover_font_family)) $css .= "font-family:$ahover_color;";?>
                    <?php if (!empty($ahover_font_size)) $css .= "font-size:$ahover_font_size;";?>
                    <?php if (!empty($ahover_font_weight)) $css .= "font-weight:$ahover_font_weight;";?>
                    <?php if (!empty($ahover_font_style)) $css .= "font-style:$ahover_font_style;";?>
                    <?php if (!empty($ahover_text_decoration)) $css .= "text-decoration:$ahover_text_decoration;";?>
                    <div id="bodyAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[a:hover][font-family]" onchange="demo(this,'font-family','bodyAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($ahover_font_family) && ($ahover_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[a:hover][font-size]" onchange="demo(this,'font-size','bodyAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($ahover_font_size) && ($ahover_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[a:hover][font-weight]" onchange="demo(this,'font-weight','bodyAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($ahover_font_weight) && ($ahover_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[a:hover][font-style]" onchange="demo(this,'font-style','bodyAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($ahover_font_style) && ($ahover_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[a:hover][text-decoration]" onchange="demo(this,'text-decoration','bodyAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($ahover_text_decoration) && ($ahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Active</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="bodyAActive">
                    <input type="text" id="body_aactive" name="Style[a:active][color]" value="<?php echo !empty($aactive_color) ? $aactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($aactive_color) ? " style='background-color:".$aactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($aactive_color)) $css .= "color:$aactive_color;";?>
                    <?php if (!empty($aactive_font_family)) $css .= "font-family:$aactive_color;";?>
                    <?php if (!empty($aactive_font_size)) $css .= "font-size:$aactive_font_size;";?>
                    <?php if (!empty($aactive_font_weight)) $css .= "font-weight:$aactive_font_weight;";?>
                    <?php if (!empty($aactive_font_style)) $css .= "font-style:$aactive_font_style;";?>
                    <?php if (!empty($aactive_text_decoration)) $css .= "text-decoration:$aactive_text_decoration;";?>
                    <div id="bodyAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[a:active][font-family]" onchange="demo(this,'font-family','bodyAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($aactive_font_family) && ($aactive_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[a:active][font-size]" onchange="demo(this,'font-size','bodyAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($aactive_font_size) && ($aactive_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[a:active][font-weight]" onchange="demo(this,'font-weight','bodyAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($aactive_font_weight) && ($aactive_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[a:active][font-style]" onchange="demo(this,'font-style','bodyAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($aactive_font_style) && ($aactive_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[a:active][text-decoration]" onchange="demo(this,'text-decoration','bodyAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($aactive_text_decoration) && ($aactive_text_decoration == $key)) { ?>
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
        
        <h2>Enlaces</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="linksA">
                    <input type="text" id="links_a" name="Style[#links a, #links a:visited][color]" value="<?php echo !empty($linksa_color) ? $linksa_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($linksa_color) ? " style='background-color:".$linksa_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($linksa_color)) $css .= "color:$linksa_color;";?>
                    <?php if (!empty($linksa_font_family)) $css .= "font-family:$linksa_color;";?>
                    <?php if (!empty($linksa_font_size)) $css .= "font-size:$linksa_font_size;";?>
                    <?php if (!empty($linksa_font_weight)) $css .= "font-weight:$linksa_font_weight;";?>
                    <?php if (!empty($linksa_font_style)) $css .= "font-style:$linksa_font_style;";?>
                    <?php if (!empty($linksa_text_decoration)) $css .= "text-decoration:$linksa_text_decoration;";?>
                    <div id="linksADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#links a, #links a:visited][font-family]" onchange="demo(this,'font-family','linksADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($linksa_font_family) && ($linksa_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#links a, #links a:visited][font-size]" onchange="demo(this,'font-size','linksADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($linksa_font_size) && ($linksa_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#links a, #links a:visited][font-weight]" onchange="demo(this,'font-weight','linksADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($linksa_font_weight) && ($linksa_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#links a, #links a:visited][font-style]" onchange="demo(this,'font-style','linksADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($linksa_font_style) && ($linksa_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#links a, #links a:visited][text-decoration]" onchange="demo(this,'text-decoration','linksADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($linksa_text_decoration) && ($linksa_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Hover</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="linksAHover">
                    <input type="text" id="links_ahover" name="Style[#links a:hover][color]" value="<?php echo !empty($linksahover_color) ? $linksahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($linksahover_color) ? " style='background-color:".$linksahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($linksahover_color)) $css .= "color:$linksahover_color;";?>
                    <?php if (!empty($linksahover_font_family)) $css .= "font-family:$linksahover_color;";?>
                    <?php if (!empty($linksahover_font_size)) $css .= "font-size:$linksahover_font_size;";?>
                    <?php if (!empty($linksahover_font_weight)) $css .= "font-weight:$linksahover_font_weight;";?>
                    <?php if (!empty($linksahover_font_style)) $css .= "font-style:$linksahover_font_style;";?>
                    <?php if (!empty($linksahover_text_decoration)) $css .= "text-decoration:$linksahover_text_decoration;";?>
                    <div id="linksAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#links a:hover][font-family]" onchange="demo(this,'font-family','linksAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($linksahover_font_family) && ($linksahover_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#links a:hover][font-size]" onchange="demo(this,'font-size','linksAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($linksahover_font_size) && ($linksahover_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#links a:hover][font-weight]" onchange="demo(this,'font-weight','linksAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($linksahover_font_weight) && ($linksahover_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#links a:hover][font-style]" onchange="demo(this,'font-style','linksAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($linksahover_font_style) && ($linksahover_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#links a:hover][text-decoration]" onchange="demo(this,'text-decoration','linksAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($linksahover_text_decoration) && ($linksahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Active</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="linksAActive">
                    <input type="text" id="links_aactive" name="Style[#links a:active][color]" value="<?php echo !empty($linksaactive_color) ? $linksaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($linksaactive_color) ? " style='background-color:".$linksaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($linksaactive_color)) $css .= "color:$linksaactive_color;";?>
                    <?php if (!empty($linksaactive_font_family)) $css .= "font-family:$linksaactive_color;";?>
                    <?php if (!empty($linksaactive_font_size)) $css .= "font-size:$linksaactive_font_size;";?>
                    <?php if (!empty($linksaactive_font_weight)) $css .= "font-weight:$linksaactive_font_weight;";?>
                    <?php if (!empty($linksaactive_font_style)) $css .= "font-style:$linksaactive_font_style;";?>
                    <?php if (!empty($linksaactive_text_decoration)) $css .= "text-decoration:$linksaactive_text_decoration;";?>
                    <div id="linksAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#links a:active][font-family]" onchange="demo(this,'font-family','linksAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($linksaactive_font_family) && ($linksaactive_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#links a:active][font-size]" onchange="demo(this,'font-size','linksAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($linksaactive_font_size) && ($linksaactive_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#links a:active][font-weight]" onchange="demo(this,'font-weight','linksAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($linksaactive_font_weight) && ($linksaactive_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#links a:active][font-style]" onchange="demo(this,'font-style','linksAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($linksaactive_font_style) && ($linksaactive_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#links a:active][text-decoration]" onchange="demo(this,'text-decoration','linksAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($linksaactive_text_decoration) && ($linksaactive_text_decoration == $key)) { ?>
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
          
        <h2>Enlaces</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="footerA">
                    <input type="text" id="footer_a" name="Style[#footer a][color]" value="<?php echo !empty($footera_color) ? $footera_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($footera_color) ? " style='background-color:".$footera_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($footera_color)) $css .= "color:$footera_color;";?>
                    <?php if (!empty($footera_font_family)) $css .= "font-family:$footera_color;";?>
                    <?php if (!empty($footera_font_size)) $css .= "font-size:$footera_font_size;";?>
                    <?php if (!empty($footera_font_weight)) $css .= "font-weight:$footera_font_weight;";?>
                    <?php if (!empty($footera_font_style)) $css .= "font-style:$footera_font_style;";?>
                    <?php if (!empty($footera_text_decoration)) $css .= "text-decoration:$footera_text_decoration;";?>
                    <div id="footerADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#footer a][font-family]" onchange="demo(this,'font-family','footerADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($footera_font_family) && ($footera_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#footer a][font-size]" onchange="demo(this,'font-size','footerADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($footera_font_size) && ($footera_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#footer a][font-weight]" onchange="demo(this,'font-weight','footerADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($footera_font_weight) && ($footera_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#footer a][font-style]" onchange="demo(this,'font-style','footerADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($footera_font_style) && ($footera_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#footer a][text-decoration]" onchange="demo(this,'text-decoration','footerADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($footera_text_decoration) && ($footera_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Hover</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="footerAHover">
                    <input type="text" id="footer_ahover" name="Style[#footer a:hover][color]" value="<?php echo !empty($footerahover_color) ? $footerahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($footerahover_color) ? " style='background-color:".$footerahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($footerahover_color)) $css .= "color:$footerahover_color;";?>
                    <?php if (!empty($footerahover_font_family)) $css .= "font-family:$footerahover_color;";?>
                    <?php if (!empty($footerahover_font_size)) $css .= "font-size:$footerahover_font_size;";?>
                    <?php if (!empty($footerahover_font_weight)) $css .= "font-weight:$footerahover_font_weight;";?>
                    <?php if (!empty($footerahover_font_style)) $css .= "font-style:$footerahover_font_style;";?>
                    <?php if (!empty($footerahover_text_decoration)) $css .= "text-decoration:$footerahover_text_decoration;";?>
                    <div id="footerAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#footer a:hover][font-family]" onchange="demo(this,'font-family','footerAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($footerahover_font_family) && ($footerahover_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#footer a:hover][font-size]" onchange="demo(this,'font-size','footerAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($footerahover_font_size) && ($footerahover_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#footer a:hover][font-weight]" onchange="demo(this,'font-weight','footerAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($footerahover_font_weight) && ($footerahover_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#footer a:hover][font-style]" onchange="demo(this,'font-style','footerAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($footerahover_font_style) && ($footerahover_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#footer a:hover][text-decoration]" onchange="demo(this,'text-decoration','footerAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($footerahover_text_decoration) && ($footerahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Active</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="footerAActive">
                    <input type="text" id="footer_aactive" name="Style[#footer a:active][color]" value="<?php echo !empty($footeraactive_color) ? $footeraactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($footeraactive_color) ? " style='background-color:".$footeraactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($footeraactive_color)) $css .= "color:$footeraactive_color;";?>
                    <?php if (!empty($footeraactive_font_family)) $css .= "font-family:$footeraactive_color;";?>
                    <?php if (!empty($footeraactive_font_size)) $css .= "font-size:$footeraactive_font_size;";?>
                    <?php if (!empty($footeraactive_font_weight)) $css .= "font-weight:$footeraactive_font_weight;";?>
                    <?php if (!empty($footeraactive_font_style)) $css .= "font-style:$footeraactive_font_style;";?>
                    <?php if (!empty($footeraactive_text_decoration)) $css .= "text-decoration:$footeraactive_text_decoration;";?>
                    <div id="footerAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[#footer a:active][font-family]" onchange="demo(this,'font-family','footerAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($footeraactive_font_family) && ($footeraactive_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[#footer a:active][font-size]" onchange="demo(this,'font-size','footerAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($footeraactive_font_size) && ($footeraactive_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[#footer a:active][font-weight]" onchange="demo(this,'font-weight','footerAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($footeraactive_font_weight) && ($footeraactive_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[#footer a:active][font-style]" onchange="demo(this,'font-style','footerAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($footeraactive_font_style) && ($footeraactive_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[#footer a:active][text-decoration]" onchange="demo(this,'text-decoration','footerAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($footeraactive_text_decoration) && ($footeraactive_text_decoration == $key)) { ?>
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
            
        <h2>Enlaces</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="categoryModuleA">
                    <input type="text" id="categoryModule_a" name="Style[.categoryModule a][color]" value="<?php echo !empty($categoryModulea_color) ? $categoryModulea_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($categoryModulea_color) ? " style='background-color:".$categoryModulea_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($categoryModulea_color)) $css .= "color:$categoryModulea_color;";?>
                    <?php if (!empty($categoryModulea_font_family)) $css .= "font-family:$categoryModulea_color;";?>
                    <?php if (!empty($categoryModulea_font_size)) $css .= "font-size:$categoryModulea_font_size;";?>
                    <?php if (!empty($categoryModulea_font_weight)) $css .= "font-weight:$categoryModulea_font_weight;";?>
                    <?php if (!empty($categoryModulea_font_style)) $css .= "font-style:$categoryModulea_font_style;";?>
                    <?php if (!empty($categoryModulea_text_decoration)) $css .= "text-decoration:$categoryModulea_text_decoration;";?>
                    <div id="categoryModuleADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.categoryModule a][font-family]" onchange="demo(this,'font-family','categoryModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($categoryModulea_font_family) && ($categoryModulea_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.categoryModule a][font-size]" onchange="demo(this,'font-size','categoryModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($categoryModulea_font_size) && ($categoryModulea_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.categoryModule a][font-weight]" onchange="demo(this,'font-weight','categoryModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($categoryModulea_font_weight) && ($categoryModulea_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.categoryModule a][font-style]" onchange="demo(this,'font-style','categoryModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($categoryModulea_font_style) && ($categoryModulea_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.categoryModule a][text-decoration]" onchange="demo(this,'text-decoration','categoryModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($categoryModulea_text_decoration) && ($categoryModulea_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Hover</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="categoryModuleAHover">
                    <input type="text" id="categoryModule_ahover" name="Style[.categoryModule a:hover][color]" value="<?php echo !empty($categoryModuleahover_color) ? $categoryModuleahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($categoryModuleahover_color) ? " style='background-color:".$categoryModuleahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($categoryModuleahover_color)) $css .= "color:$categoryModuleahover_color;";?>
                    <?php if (!empty($categoryModuleahover_font_family)) $css .= "font-family:$categoryModuleahover_color;";?>
                    <?php if (!empty($categoryModuleahover_font_size)) $css .= "font-size:$categoryModuleahover_font_size;";?>
                    <?php if (!empty($categoryModuleahover_font_weight)) $css .= "font-weight:$categoryModuleahover_font_weight;";?>
                    <?php if (!empty($categoryModuleahover_font_style)) $css .= "font-style:$categoryModuleahover_font_style;";?>
                    <?php if (!empty($categoryModuleahover_text_decoration)) $css .= "text-decoration:$categoryModuleahover_text_decoration;";?>
                    <div id="categoryModuleAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.categoryModule a:hover][font-family]" onchange="demo(this,'font-family','categoryModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($categoryModuleahover_font_family) && ($categoryModuleahover_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.categoryModule a:hover][font-size]" onchange="demo(this,'font-size','categoryModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($categoryModuleahover_font_size) && ($categoryModuleahover_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.categoryModule a:hover][font-weight]" onchange="demo(this,'font-weight','categoryModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($categoryModuleahover_font_weight) && ($categoryModuleahover_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.categoryModule a:hover][font-style]" onchange="demo(this,'font-style','categoryModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($categoryModuleahover_font_style) && ($categoryModuleahover_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.categoryModule a:hover][text-decoration]" onchange="demo(this,'text-decoration','categoryModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($categoryModuleahover_text_decoration) && ($categoryModuleahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Active</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="categoryModuleAActive">
                    <input type="text" id="categoryModule_aactive" name="Style[.categoryModule a:active][color]" value="<?php echo !empty($categoryModuleaactive_color) ? $categoryModuleaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($categoryModuleaactive_color) ? " style='background-color:".$categoryModuleaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($categoryModuleaactive_color)) $css .= "color:$categoryModuleaactive_color;";?>
                    <?php if (!empty($categoryModuleaactive_font_family)) $css .= "font-family:$categoryModuleaactive_color;";?>
                    <?php if (!empty($categoryModuleaactive_font_size)) $css .= "font-size:$categoryModuleaactive_font_size;";?>
                    <?php if (!empty($categoryModuleaactive_font_weight)) $css .= "font-weight:$categoryModuleaactive_font_weight;";?>
                    <?php if (!empty($categoryModuleaactive_font_style)) $css .= "font-style:$categoryModuleaactive_font_style;";?>
                    <?php if (!empty($categoryModuleaactive_text_decoration)) $css .= "text-decoration:$categoryModuleaactive_text_decoration;";?>
                    <div id="categoryModuleAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.categoryModule a:active][font-family]" onchange="demo(this,'font-family','categoryModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($categoryModuleaactive_font_family) && ($categoryModuleaactive_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.categoryModule a:active][font-size]" onchange="demo(this,'font-size','categoryModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($categoryModuleaactive_font_size) && ($categoryModuleaactive_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.categoryModule a:active][font-weight]" onchange="demo(this,'font-weight','categoryModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($categoryModuleaactive_font_weight) && ($categoryModuleaactive_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.categoryModule a:active][font-style]" onchange="demo(this,'font-style','categoryModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($categoryModuleaactive_font_style) && ($categoryModuleaactive_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.categoryModule a:active][text-decoration]" onchange="demo(this,'text-decoration','categoryModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($categoryModuleaactive_text_decoration) && ($categoryModuleaactive_text_decoration == $key)) { ?>
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
            
        <h2>Enlaces</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="informationModuleA">
                    <input type="text" id="informationModule_a" name="Style[.informationModule a][color]" value="<?php echo !empty($informationModulea_color) ? $informationModulea_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($informationModulea_color) ? " style='background-color:".$informationModulea_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($informationModulea_color)) $css .= "color:$informationModulea_color;";?>
                    <?php if (!empty($informationModulea_font_family)) $css .= "font-family:$informationModulea_color;";?>
                    <?php if (!empty($informationModulea_font_size)) $css .= "font-size:$informationModulea_font_size;";?>
                    <?php if (!empty($informationModulea_font_weight)) $css .= "font-weight:$informationModulea_font_weight;";?>
                    <?php if (!empty($informationModulea_font_style)) $css .= "font-style:$informationModulea_font_style;";?>
                    <?php if (!empty($informationModulea_text_decoration)) $css .= "text-decoration:$informationModulea_text_decoration;";?>
                    <div id="informationModuleADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.informationModule a][font-family]" onchange="demo(this,'font-family','informationModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($informationModulea_font_family) && ($informationModulea_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.informationModule a][font-size]" onchange="demo(this,'font-size','informationModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($informationModulea_font_size) && ($informationModulea_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.informationModule a][font-weight]" onchange="demo(this,'font-weight','informationModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($informationModulea_font_weight) && ($informationModulea_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.informationModule a][font-style]" onchange="demo(this,'font-style','informationModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($informationModulea_font_style) && ($informationModulea_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.informationModule a][text-decoration]" onchange="demo(this,'text-decoration','informationModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($informationModulea_text_decoration) && ($informationModulea_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Hover</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="informationModuleAHover">
                    <input type="text" id="informationModule_ahover" name="Style[.informationModule a:hover][color]" value="<?php echo !empty($informationModuleahover_color) ? $informationModuleahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($informationModuleahover_color) ? " style='background-color:".$informationModuleahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($informationModuleahover_color)) $css .= "color:$informationModuleahover_color;";?>
                    <?php if (!empty($informationModuleahover_font_family)) $css .= "font-family:$informationModuleahover_color;";?>
                    <?php if (!empty($informationModuleahover_font_size)) $css .= "font-size:$informationModuleahover_font_size;";?>
                    <?php if (!empty($informationModuleahover_font_weight)) $css .= "font-weight:$informationModuleahover_font_weight;";?>
                    <?php if (!empty($informationModuleahover_font_style)) $css .= "font-style:$informationModuleahover_font_style;";?>
                    <?php if (!empty($informationModuleahover_text_decoration)) $css .= "text-decoration:$informationModuleahover_text_decoration;";?>
                    <div id="informationModuleAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.informationModule a:hover][font-family]" onchange="demo(this,'font-family','informationModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($informationModuleahover_font_family) && ($informationModuleahover_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.informationModule a:hover][font-size]" onchange="demo(this,'font-size','informationModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($informationModuleahover_font_size) && ($informationModuleahover_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.informationModule a:hover][font-weight]" onchange="demo(this,'font-weight','informationModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($informationModuleahover_font_weight) && ($informationModuleahover_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.informationModule a:hover][font-style]" onchange="demo(this,'font-style','informationModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($informationModuleahover_font_style) && ($informationModuleahover_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.informationModule a:hover][text-decoration]" onchange="demo(this,'text-decoration','informationModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($informationModuleahover_text_decoration) && ($informationModuleahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Active</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="informationModuleAActive">
                    <input type="text" id="informationModule_aactive" name="Style[.informationModule a:active][color]" value="<?php echo !empty($informationModuleaactive_color) ? $informationModuleaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($informationModuleaactive_color) ? " style='background-color:".$informationModuleaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($informationModuleaactive_color)) $css .= "color:$informationModuleaactive_color;";?>
                    <?php if (!empty($informationModuleaactive_font_family)) $css .= "font-family:$informationModuleaactive_color;";?>
                    <?php if (!empty($informationModuleaactive_font_size)) $css .= "font-size:$informationModuleaactive_font_size;";?>
                    <?php if (!empty($informationModuleaactive_font_weight)) $css .= "font-weight:$informationModuleaactive_font_weight;";?>
                    <?php if (!empty($informationModuleaactive_font_style)) $css .= "font-style:$informationModuleaactive_font_style;";?>
                    <?php if (!empty($informationModuleaactive_text_decoration)) $css .= "text-decoration:$informationModuleaactive_text_decoration;";?>
                    <div id="informationModuleAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.informationModule a:active][font-family]" onchange="demo(this,'font-family','informationModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($informationModuleaactive_font_family) && ($informationModuleaactive_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.informationModule a:active][font-size]" onchange="demo(this,'font-size','informationModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($informationModuleaactive_font_size) && ($informationModuleaactive_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.informationModule a:active][font-weight]" onchange="demo(this,'font-weight','informationModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($informationModuleaactive_font_weight) && ($informationModuleaactive_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.informationModule a:active][font-style]" onchange="demo(this,'font-style','informationModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($informationModuleaactive_font_style) && ($informationModuleaactive_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.informationModule a:active][text-decoration]" onchange="demo(this,'text-decoration','informationModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($informationModuleaactive_text_decoration) && ($informationModuleaactive_text_decoration == $key)) { ?>
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
            
        <h2>Enlaces</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="cartModuleA">
                    <input type="text" id="cartModule_a" name="Style[.cartModule a][color]" value="<?php echo !empty($cartModulea_color) ? $cartModulea_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($cartModulea_color) ? " style='background-color:".$cartModulea_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($cartModulea_color)) $css .= "color:$cartModulea_color;";?>
                    <?php if (!empty($cartModulea_font_family)) $css .= "font-family:$cartModulea_color;";?>
                    <?php if (!empty($cartModulea_font_size)) $css .= "font-size:$cartModulea_font_size;";?>
                    <?php if (!empty($cartModulea_font_weight)) $css .= "font-weight:$cartModulea_font_weight;";?>
                    <?php if (!empty($cartModulea_font_style)) $css .= "font-style:$cartModulea_font_style;";?>
                    <?php if (!empty($cartModulea_text_decoration)) $css .= "text-decoration:$cartModulea_text_decoration;";?>
                    <div id="cartModuleADemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.cartModule a][font-family]" onchange="demo(this,'font-family','cartModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($cartModulea_font_family) && ($cartModulea_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.cartModule a][font-size]" onchange="demo(this,'font-size','cartModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($cartModulea_font_size) && ($cartModulea_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.cartModule a][font-weight]" onchange="demo(this,'font-weight','cartModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($cartModulea_font_weight) && ($cartModulea_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.cartModule a][font-style]" onchange="demo(this,'font-style','cartModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($cartModulea_font_style) && ($cartModulea_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.cartModule a][text-decoration]" onchange="demo(this,'text-decoration','cartModuleADemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($cartModulea_text_decoration) && ($cartModulea_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Hover</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="cartModuleAHover">
                    <input type="text" id="cartModule_ahover" name="Style[.cartModule a:hover][color]" value="<?php echo !empty($cartModuleahover_color) ? $cartModuleahover_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($cartModuleahover_color) ? " style='background-color:".$cartModuleahover_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($cartModuleahover_color)) $css .= "color:$cartModuleahover_color;";?>
                    <?php if (!empty($cartModuleahover_font_family)) $css .= "font-family:$cartModuleahover_color;";?>
                    <?php if (!empty($cartModuleahover_font_size)) $css .= "font-size:$cartModuleahover_font_size;";?>
                    <?php if (!empty($cartModuleahover_font_weight)) $css .= "font-weight:$cartModuleahover_font_weight;";?>
                    <?php if (!empty($cartModuleahover_font_style)) $css .= "font-style:$cartModuleahover_font_style;";?>
                    <?php if (!empty($cartModuleahover_text_decoration)) $css .= "text-decoration:$cartModuleahover_text_decoration;";?>
                    <div id="cartModuleAHoverDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.cartModule a:hover][font-family]" onchange="demo(this,'font-family','cartModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($cartModuleahover_font_family) && ($cartModuleahover_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.cartModule a:hover][font-size]" onchange="demo(this,'font-size','cartModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($cartModuleahover_font_size) && ($cartModuleahover_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.cartModule a:hover][font-weight]" onchange="demo(this,'font-weight','cartModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($cartModuleahover_font_weight) && ($cartModuleahover_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.cartModule a:hover][font-style]" onchange="demo(this,'font-style','cartModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($cartModuleahover_font_style) && ($cartModuleahover_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.cartModule a:hover][text-decoration]" onchange="demo(this,'text-decoration','cartModuleAHoverDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($cartModuleahover_text_decoration) && ($cartModuleahover_text_decoration == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          
        <h2>Enlaces :Active</h2>
          <table class="form">
            <tr>
              <td><span class="entry"><?php echo $entry_color; ?></span><a title="<?php echo $help_color; ?>"> (?)</a></td>
              <td>
                <div class="styleField" id="cartModuleAActive">
                    <input type="text" id="cartModule_aactive" name="Style[.cartModule a:active][color]" value="<?php echo !empty($cartModuleaactive_color) ? $cartModuleaactive_color : ""; ?>" />
                    <span class="colopickerpreview" <?php echo !empty($cartModuleaactive_color) ? " style='background-color:".$cartModuleaactive_color."' " : ""; ?>></span>
                </div>
              </td>
              <td rowspan="6">
                    <?php $css = ""; ?>
                    <?php if (!empty($cartModuleaactive_color)) $css .= "color:$cartModuleaactive_color;";?>
                    <?php if (!empty($cartModuleaactive_font_family)) $css .= "font-family:$cartModuleaactive_color;";?>
                    <?php if (!empty($cartModuleaactive_font_size)) $css .= "font-size:$cartModuleaactive_font_size;";?>
                    <?php if (!empty($cartModuleaactive_font_weight)) $css .= "font-weight:$cartModuleaactive_font_weight;";?>
                    <?php if (!empty($cartModuleaactive_font_style)) $css .= "font-style:$cartModuleaactive_font_style;";?>
                    <?php if (!empty($cartModuleaactive_text_decoration)) $css .= "text-decoration:$cartModuleaactive_text_decoration;";?>
                    <div id="cartModuleAActiveDemo" <?php echo !empty($css) ? " style='$css' " : ""; ?>>Demostraci&oacute;n</div>
              </td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_family; ?></span><a title="<?php echo $help_family; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_family; ?>" name="Style[.cartModule a:active][font-family]" onchange="demo(this,'font-family','cartModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($families as $key => $value) { ?>
                        <?php if (!empty($cartModuleaactive_font_family) && ($cartModuleaactive_font_family == $key)) { ?>
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
                <select title="<?php echo $help_size; ?>" name="Style[.cartModule a:active][font-size]" onchange="demo(this,'font-size','cartModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($sizes as $key => $value) { ?>
                        <?php if (!empty($cartModuleaactive_font_size) && ($cartModuleaactive_font_size == $key)) { ?>
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
                <select title="<?php echo $help_weight; ?>" name="Style[.cartModule a:active][font-weight]" onchange="demo(this,'font-weight','cartModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($bold as $key => $value) { ?>
                        <?php if (!empty($cartModuleaactive_font_weight) && ($cartModuleaactive_font_weight == $key)) { ?>
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
                <select title="<?php echo $help_style; ?>" name="Style[.cartModule a:active][font-style]" onchange="demo(this,'font-style','cartModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($italic as $key => $value) { ?>
                        <?php if (!empty($cartModuleaactive_font_style) && ($cartModuleaactive_font_style == $key)) { ?>
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
                <select title="<?php echo $help_decoration; ?>" name="Style[.cartModule a:active][text-decoration]" onchange="demo(this,'text-decoration','cartModuleAActiveDemo')">
                        <option value="">Seleccionar</option>
                    <?php foreach ($underline as $key => $value) { ?>
                        <?php if (!empty($cartModuleaactive_text_decoration) && ($cartModuleaactive_text_decoration == $key)) { ?>
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
jQuery('#bodyA').ColorPicker({
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
        $('#bodyA span').css('backgroundColor', '#' + hex);
        $('#bodyADemo').css('color', '#' + hex);
        $("#body_a").val('#'+hex);
    }
});
jQuery('#bodyAHover').ColorPicker({
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
        $('#bodyAHover span').css('backgroundColor', '#' + hex);
        $('#bodyAHoverDemo').css('color', '#' + hex);
        $("#body_ahover").val('#'+hex);
    }
});
jQuery('#bodyAActive').ColorPicker({
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
        $('#bodyAActive span').css('backgroundColor', '#' + hex);
        $('#bodyAActiveDemo').css('color', '#' + hex);
        $("#body_aactive").val('#'+hex);
    }
});
jQuery('#linksA').ColorPicker({
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
        $('#linksA span').css('backgroundColor', '#' + hex);
        $('#linksADemo').css('color', '#' + hex);
        $("#links_a").val('#'+hex);
    }
});
jQuery('#linksAHover').ColorPicker({
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
        $('#linksAHover span').css('backgroundColor', '#' + hex);
        $('#linksAHoverDemo').css('color', '#' + hex);
        $("#links_ahover").val('#'+hex);
    }
});
jQuery('#linksAActive').ColorPicker({
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
        $('#linksAActive span').css('backgroundColor', '#' + hex);
        $('#linksAActiveDemo').css('color', '#' + hex);
        $("#links_aactive").val('#'+hex);
    }
});
jQuery('#footerA').ColorPicker({
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
        $('#footerA span').css('backgroundColor', '#' + hex);
        $('#footerADemo').css('color', '#' + hex);
        $("#footer_a").val('#'+hex);
    }
});
jQuery('#footerAHover').ColorPicker({
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
        $('#footerAHover span').css('backgroundColor', '#' + hex);
        $('#footerAHoverDemo').css('color', '#' + hex);
        $("#footer_ahover").val('#'+hex);
    }
});
jQuery('#footerAActive').ColorPicker({
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
        $('#footerAActive span').css('backgroundColor', '#' + hex);
        $('#footerAActiveDemo').css('color', '#' + hex);
        $("#footer_aactive").val('#'+hex);
    }
});
jQuery('#categoryModuleA').ColorPicker({
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
        $('#categoryModuleA span').css('backgroundColor', '#' + hex);
        $('#categoryModuleADemo').css('color', '#' + hex);
        $("#categoryModule_a").val('#'+hex);
    }
});
jQuery('#categoryModuleAHover').ColorPicker({
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
        $('#categoryModuleAHover span').css('backgroundColor', '#' + hex);
        $('#categoryModuleAHoverDemo').css('color', '#' + hex);
        $("#categoryModule_ahover").val('#'+hex);
    }
});
jQuery('#categoryModuleAActive').ColorPicker({
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
        $('#categoryModuleAActive span').css('backgroundColor', '#' + hex);
        $('#categoryModuleAActiveDemo').css('color', '#' + hex);
        $("#categoryModule_aactive").val('#'+hex);
    }
});
jQuery('#informationModuleA').ColorPicker({
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
        $('#informationModuleA span').css('backgroundColor', '#' + hex);
        $('#informationModuleADemo').css('color', '#' + hex);
        $("#informationModule_a").val('#'+hex);
    }
});
jQuery('#informationModuleAHover').ColorPicker({
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
        $('#informationModuleAHover span').css('backgroundColor', '#' + hex);
        $('#informationModuleAHoverDemo').css('color', '#' + hex);
        $("#informationModule_ahover").val('#'+hex);
    }
});
jQuery('#informationModuleAActive').ColorPicker({
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
        $('#informationModuleAActive span').css('backgroundColor', '#' + hex);
        $('#informationModuleAActiveDemo').css('color', '#' + hex);
        $("#informationModule_aactive").val('#'+hex);
    }
});
jQuery('#cartModuleA').ColorPicker({
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
        $('#cartModuleA span').css('backgroundColor', '#' + hex);
        $('#cartModuleADemo').css('color', '#' + hex);
        $("#cartModule_a").val('#'+hex);
    }
});
jQuery('#cartModuleAHover').ColorPicker({
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
        $('#cartModuleAHover span').css('backgroundColor', '#' + hex);
        $('#cartModuleAHoverDemo').css('color', '#' + hex);
        $("#cartModule_ahover").val('#'+hex);
    }
});
jQuery('#cartModuleAActive').ColorPicker({
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
        $('#cartModuleAActive span').css('backgroundColor', '#' + hex);
        $('#cartModuleAActiveDemo').css('color', '#' + hex);
        $("#cartModule_aactive").val('#'+hex);
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