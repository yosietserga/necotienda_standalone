<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/customer.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $reset; ?>';" class="button"><span><?php echo $button_reset; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%;">
      <div id="vtabs" class="vtabs">
      <a  tab="#tab_general"><?php echo $tab_general; ?></a>
      <a  tab="#tab_header"><?php echo $tab_header; ?></a>
      <a  tab="#tab_nav"><?php echo $tab_nav; ?></a>
      <a  tab="#tab_maincontent"><?php echo $tab_maincontent; ?></a>
      <a  tab="#tab_column_left"><?php echo $tab_column_left; ?></a>
      <a  tab="#tab_column_right"><?php echo $tab_column_right; ?></a>
      <a  tab="#tab_content"><?php echo $tab_content; ?></a>
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
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[body][background-image]" value="<?php echo $_body_image; ?>" id="body_image" />
                  <img alt="<?php echo $body_image; ?>" src="<?php echo $body_image; ?>" id="image_body" class="image" onclick="image_upload('body_image', 'image_body');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[body][background-repeat]" id="general_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($body_background_repeat) && ($body_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_general_repeat) { ?>
                <span class="error"><?php echo $error_background_general_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[body][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($body_background_position) && ($body_background_position == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_attachment; ?></span><a title="<?php echo $help_attachment; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_attachment; ?>" name="Style[body][background-attachment]" id="general_attachment">
                    <?php foreach ($attachments as $key => $value) { ?>
                        <?php if (!empty($body_background_attachment) && ($body_background_attachment == $key)) { ?>
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
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[body][background]" id="general_gradient"><?php echo $body_background; ?></textarea>
                <?php if ($error_background_general_gradient) { ?>
                <span class="error"><?php echo $error_background_general_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_header" class="vtabs_page">
            <h1><?php echo $tab_header; ?></h1>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#header][background-image]" value="<?php echo $_header_image; ?>" id="header_image" />
                  <img src="<?php echo $header_image; ?>" id="image_header" class="image" onclick="image_upload('header_image', 'image_header');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#header][background-repeat]" id="header_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($header_background_repeat) && ($header_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_header_repeat) { ?>
                <span class="error"><?php echo $error_background_header_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[#header][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($header_background_position) && ($header_background_position == $key)) { ?>
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
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#header][background]" id="header_gradient"><?php echo $header_background; ?></textarea>
                <?php if ($error_background_header_gradient) { ?>
                <span class="error"><?php echo $error_background_header_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_nav" class="vtabs_page">
            <h2><?php echo $tab_nav; ?></h2>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#nav][background-image]" value="<?php echo $_nav_image; ?>" id="nav_image" />
                  <img src="<?php echo $nav_image; ?>" id="image_nav" class="image" onclick="image_upload('nav_image', 'image_nav');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#nav][background-repeat]" id="nav_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($nav_background_repeat) && ($nav_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_nav_repeat) { ?>
                <span class="error"><?php echo $error_background_nav_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[#nav][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($nav_background_position) && ($nav_background_position == $key)) { ?>
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
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#nav][background]" id="nav_gradient"><?php echo $nav_background; ?></textarea>
                <?php if ($error_background_nav_gradient) { ?>
                <span class="error"><?php echo $error_background_nav_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_maincontent" class="vtabs_page">
            <h1><?php echo $tab_maincontent; ?></h1>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#maincontent][background-image]" value="<?php echo $_maincontent_image; ?>" id="maincontent_image" />
                  <img src="<?php echo $maincontent_image; ?>" id="image_maincontent" class="image" onclick="image_upload('maincontent_image', 'image_maincontent');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#maincontent][background-repeat]" id="maincontent_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($maincontent_background_repeat) && ($maincontent_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_maincontent_repeat) { ?>
                <span class="error"><?php echo $error_background_maincontent_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[#maincontent][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($maincontent_background_position) && ($maincontent_background_position == $key)) { ?>
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
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#maincontent][background]" id="maincontent_gradient"><?php echo $maincontent_background; ?></textarea>
                <?php if ($error_background_maincontent_gradient) { ?>
                <span class="error"><?php echo $error_background_maincontent_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_column_left" class="vtabs_page">
            <h1><?php echo $tab_column_left; ?></h1>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#column_left][background-image]" value="<?php echo $_column_left_image; ?>" id="column_left_image" />
                  <img src="<?php echo $column_left_image; ?>" id="image_column_left" class="image" onclick="image_upload('column_left_image', 'image_column_left');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#column_left][background-repeat]" id="column_left_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($column_left_background_repeat) && ($column_left_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_column_left_repeat) { ?>
                <span class="error"><?php echo $error_background_column_left_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#column_left][background]" id="column_left_gradient"><?php echo $column_left_background; ?></textarea>
                <?php if ($error_background_column_left_gradient) { ?>
                <span class="error"><?php echo $error_background_column_left_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_column_right" class="vtabs_page">
            <h1><?php echo $tab_column_right; ?></h1>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#column_right][background-image]" value="<?php echo $_column_right_image; ?>" id="column_right_image" />
                  <img src="<?php echo $column_right_image; ?>" id="image_column_right" class="image" onclick="image_upload('column_right_image', 'image_column_right');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#column_right][background-repeat]" id="column_right_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($column_right_background_repeat) && ($column_right_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_column_right_repeat) { ?>
                <span class="error"><?php echo $error_background_column_right_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#column_right][background]" id="column_right_gradient"><?php echo $column_right_background; ?></textarea>
                <?php if ($error_background_column_right_gradient) { ?>
                <span class="error"><?php echo $error_background_column_right_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_content" class="vtabs_page">
            <h1><?php echo $tab_content; ?></h1>
          <table class="form">
          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#content][background-image]" value="<?php echo $_content_image; ?>" id="content_image" />
                  <img src="<?php echo $content_image; ?>" id="image_content" class="image" onclick="image_upload('content_image', 'image_content');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#content][background-repeat]" id="content_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($content_background_repeat) && ($content_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_content_repeat) { ?>
                <span class="error"><?php echo $error_background_content_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[#content][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($content_background_position) && ($content_background_position == $key)) { ?>
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
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#content][background]" id="content_gradient"><?php echo $content_background; ?></textarea>
                <?php if ($error_background_content_gradient) { ?>
                <span class="error"><?php echo $error_background_content_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_footer" class="vtabs_page">
            <h1><?php echo $tab_footer; ?></h1>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[#footer][background-image]" value="<?php echo $_footer_image; ?>" id="footer_image" />
                  <img src="<?php echo $footer_image; ?>" id="image_footer" class="image" onclick="image_upload('footer_image', 'image_footer');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[#footer][background-repeat]" id="footer_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($footer_background_repeat) && ($footer_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_footer_repeat) { ?>
                <span class="error"><?php echo $error_background_footer_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_position; ?></span><a title="<?php echo $help_position; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_position; ?>" name="Style[#footer][background-position]" id="general_position">
                    <?php foreach ($positions as $key => $value) { ?>
                        <?php if (!empty($footer_background_position) && ($footer_background_position == $key)) { ?>
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
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[#footer][background]" id="footer_gradient"><?php echo $footer_background; ?></textarea>
                <?php if ($error_background_footer_gradient) { ?>
                <span class="error"><?php echo $error_background_footer_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_category_module" class="vtabs_page">
            <h1><?php echo $tab_category_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.categoryModule .header][background-image]" value="<?php echo $_categoryModuleHeader_image; ?>" id="categoryModuleHeader_image" />
                  <img src="<?php echo $categoryModuleHeader_image; ?>" id="image_categoryModuleHeader" class="image" onclick="image_upload('categoryModuleHeader_image', 'image_categoryModuleHeader');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.categoryModule .header][background-repeat]" id="category_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($categoryModuleHeader_background_repeat) && ($categoryModuleHeader_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_category_module_repeat) { ?>
                <span class="error"><?php echo $error_background_category_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.categoryModule .header][background]" id="category_module_gradient"><?php echo $categoryModuleHeader_background; ?></textarea>
                <?php if ($error_background_category_module_gradient) { ?>
                <span class="error"><?php echo $error_background_category_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
            <h2><?php echo $tab_content; ?></h2>
          <table class="form">          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.categoryModule .content][background-image]" value="<?php echo $_categoryModuleContent_image; ?>" id="categoryModuleContent_image" />
                  <img src="<?php echo $categoryModuleContent_image; ?>" id="image_categoryModuleContent" class="image" onclick="image_upload('categoryModuleContent_image', 'image_categoryModuleContent');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.categoryModule .content][background-repeat]" id="category_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($categoryModuleContent_background_repeat) && ($categoryModuleContent_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_category_module_repeat) { ?>
                <span class="error"><?php echo $error_background_category_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.categoryModule .content][background]" id="category_module_gradient"><?php echo $categoryModuleContent_background; ?></textarea>
                <?php if ($error_background_category_module_gradient) { ?>
                <span class="error"><?php echo $error_background_category_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_manufacturer_module" class="vtabs_page">
            <h1><?php echo $tab_manufacturer_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">          
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.manufacturerModule .header][background-image]" value="<?php echo $_manufacturerModuleHeader_image; ?>" id="manufacturerModuleHeader_image" />
                  <img src="<?php echo $manufacturerModuleHeader_image; ?>" id="image_manufacturerModuleHeader" class="image" onclick="image_upload('manufacturerModuleHeader_image', 'image_manufacturerModuleHeader');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.manufacturerModule .header][background-repeat]" id="manufacturer_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($manufacturerModuleHeader_background_repeat) && ($manufacturerModuleHeader_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_manufacturer_module_repeat) { ?>
                <span class="error"><?php echo $error_background_manufacturer_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.manufacturerModule .header][background]" id="manufacturer_module_gradient"><?php echo $manufacturerModuleHeader_background; ?></textarea>
                <?php if ($error_background_manufacturer_module_gradient) { ?>
                <span class="error"><?php echo $error_background_manufacturer_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
            <h2><?php echo $tab_content; ?></h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.manufacturerModule .content][background-image]" value="<?php echo $_manufacturerModuleContent_image; ?>" id="manufacturerModuleContent_image" />
                  <img src="<?php echo $manufacturerModuleContent_image; ?>" id="image_manufacturerModuleContent" class="image" onclick="image_upload('manufacturerModuleContent_image', 'image_manufacturerModuleContent');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.manufacturerModule .content][background-repeat]" id="manufacturer_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($manufacturerModuleContent_background_repeat) && ($manufacturerModuleContent_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_manufacturer_module_repeat) { ?>
                <span class="error"><?php echo $error_background_manufacturer_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.manufacturerModule .content][background]" id="manufacturer_module_gradient"><?php echo $manufacturerModuleContent_background; ?></textarea>
                <?php if ($error_background_manufacturer_module_gradient) { ?>
                <span class="error"><?php echo $error_background_manufacturer_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_information_module" class="vtabs_page">
            <h1><?php echo $tab_information_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.informationModule .header][background-image]" value="<?php echo $_informationModuleHeader_image; ?>" id="informationModuleHeader_image" />
                  <img src="<?php echo $informationModuleHeader_image; ?>" id="image_informationModuleHeader" class="image" onclick="image_upload('informationModuleHeader_image', 'image_informationModuleHeader');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.informationModule .header][background-repeat]" id="information_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($informationModuleHeader_background_repeat) && ($informationModuleHeader_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_information_module_repeat) { ?>
                <span class="error"><?php echo $error_background_information_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.informationModule .header][background]" id="information_module_gradient"><?php echo $informationModuleHeader_background; ?></textarea>
                <?php if ($error_background_information_module_gradient) { ?>
                <span class="error"><?php echo $error_background_information_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
            <h2><?php echo $tab_content; ?></h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.informationModule .content][background-image]" value="<?php echo $_informationModuleContent_image; ?>" id="informationModuleContent_image" />
                  <img src="<?php echo $informationModuleContent_image; ?>" id="image_informationModuleContent" class="image" onclick="image_upload('informationModuleContent_image', 'image_informationModuleContent');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.informationModule .content][background-repeat]" id="information_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($informationModuleContent_background_repeat) && ($informationModuleContent_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_information_module_repeat) { ?>
                <span class="error"><?php echo $error_background_information_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.informationModule .content][background]" id="information_module_gradient"><?php echo $informationModuleContent_background; ?></textarea>
                <?php if ($error_background_information_module_gradient) { ?>
                <span class="error"><?php echo $error_background_information_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_cart_module" class="vtabs_page">
            <h1><?php echo $tab_cart_module; ?></h1>
            <h2><?php echo $tab_header; ?></h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.cartModule .header][background-image]" value="<?php echo $_cartModuleHeader_image; ?>" id="cartModuleHeader_image" />
                  <img src="<?php echo $cartModuleHeader_image; ?>" id="image_cartModuleHeader" class="image" onclick="image_upload('cartModuleHeader_image', 'image_cartModuleHeader');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.cartModule .header][background-repeat]" id="cart_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($cartModuleHeader_background_repeat) && ($cartModuleHeader_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_cart_module_repeat) { ?>
                <span class="error"><?php echo $error_background_cart_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.cartModule .header][background]" id="cart_module_gradient"><?php echo $cartModuleHeader_background; ?></textarea>
                <?php if ($error_background_cart_module_gradient) { ?>
                <span class="error"><?php echo $error_background_cart_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
            <h2><?php echo $tab_content; ?></h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.cartModule .content][background-image]" value="<?php echo $_cartModuleContent_image; ?>" id="cartModuleContent_image" />
                  <img src="<?php echo $cartModuleContent_image; ?>" id="image_cartModuleContent" class="image" onclick="image_upload('cartModuleContent_image', 'image_cartModuleContent');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.cartModule .content][background-repeat]" id="cart_module_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($cartModuleContent_background_repeat) && ($cartModuleContent_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_cart_module_repeat) { ?>
                <span class="error"><?php echo $error_background_cart_module_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.cartModule .content][background]" id="cart_module_gradient"><?php echo $cartModuleContent_background; ?></textarea>
                <?php if ($error_background_cart_module_gradient) { ?>
                <span class="error"><?php echo $error_background_cart_module_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        
        <div id="tab_products" class="vtabs_page">
            <h1><?php echo $tab_products; ?></h1>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.product_preview][background-image]" value="<?php echo $_productPreview_image; ?>" id="products_image" />
                  <img src="<?php echo $productPreview_image; ?>" id="image_products" class="image" onclick="image_upload('products_image', 'image_products');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.product_preview][background-repeat]" id="products_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($productView_background_repeat) && ($productView_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_products_repeat) { ?>
                <span class="error"><?php echo $error_background_products_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.product_preview][background]" id="products_gradient"><?php echo $productPreview_background; ?></textarea>
                <?php if ($error_background_products_gradient) { ?>
                <span class="error"><?php echo $error_background_products_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
            <h2>Vista Listado Even</h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.list_view .even][background-image]" value="<?php echo $_listViewEven_image; ?>" id="listViewEven_image" />
                  <img src="<?php echo $listViewEven_image; ?>" id="image_listViewEven" class="image" onclick="image_upload('listViewEven_image', 'image_listViewEven');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.list_view .even][background-repeat]" id="products_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($listViewEven_background_repeat) && ($listViewEven_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_products_repeat) { ?>
                <span class="error"><?php echo $error_background_products_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.list_view .even][background]" id="products_gradient"><?php echo $listViewEven_background; ?></textarea>
                <?php if ($error_background_products_gradient) { ?>
                <span class="error"><?php echo $error_background_products_gradient; ?></span>
                <?php } ?></td>
            </tr>
          </table>
            <h2>Vista Listado Odd</h2>
          <table class="form">
            <tr>
                <td><?php echo $entry_image; ?><a title="<?php echo $help_image; ?>"> (?)</a></td>
                <td><input   type="hidden" name="Style[.list_view .odd][background-image]" value="<?php echo $_listViewOdd_image; ?>" id="listViewOdd_image" />
                  <img src="<?php echo $listViewOdd_image; ?>" id="image_listViewOdd" class="image" onclick="image_upload('listViewOdd_image', 'image_listViewOdd');">
                </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_repeat; ?></span><a title="<?php echo $help_repeat; ?>"> (?)</a></td>
              <td>
                <select title="<?php echo $help_repeat; ?>" name="Style[.list_view .odd][background-repeat]" id="products_repeat">
                    <?php foreach ($repeats as $key => $value) { ?>
                        <?php if (!empty($listViewOdd_background_repeat) && ($listViewOdd_background_repeat == $key)) { ?>
                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if ($error_background_products_repeat) { ?>
                <span class="error"><?php echo $error_background_products_repeat; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_gradient; ?></span><a title="<?php echo $help_gradient; ?>"> (?)</a></td>
              <td><textarea cols="40" rows="10" title="<?php echo $help_gradient; ?>" name="Style[.list_view .odd][background]" id="products_gradient"><?php echo $listViewOdd_background; ?></textarea>
                <?php if ($error_background_products_gradient) { ?>
                <span class="error"><?php echo $error_background_products_gradient; ?></span>
                <?php } ?></td>
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