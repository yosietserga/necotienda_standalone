<?php

function memoizeRows($col_id) {
    static $columns_ready = array();
    if (in_array($col_id, $columns_ready))  return true;
    array_push($columns_ready, $col_id);
    return false;
}

function drawRow($row, $Language) {
    $tpl =
    '<li class="row widgetRow widgetBox" id="'. $row['row_id'] .'">'.
        '<header>'.
            '<span>'.
                '<small class="widgetRowMove">[mover]</small>'.
                '<small>'. $row['row_id'] .'</small>'.
                '<div class="submenu">'.
                    '<i class="fa fa-bars"></i>'.
                    '<div>'.
                        '<em>'.
                            '<a class="advanced" href="#'. $row['row_id'] .'_config">Settings</a>'.
                            '<div style="display:none;" id="'. $row['row_id'] .'_config">'.
                                '<form id="'. $row['row_id'] .'_config_form">'.

                                    '<div class="row">'.
                                        '<label for="'. $row['row_id'] .'_show_in_mobile">Show In Mobiles</label>'.
                                        '<input id="'. $row['row_id'] .'_show_in_mobile" name="show_in_mobile" type="checkbox" onchange="updateRowUI(\''. $row['row_id'] .'\')"'.
                           (isset($row['settings']['show_in_mobile']) && $row['settings']['show_in_mobile'] != 'off' ? ' checked="checked"' : '')
                            .'/>'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $row['row_id'] .'_show_in_desktop">Show In Desktops</label>'.
                                        '<input id="'. $row['row_id'] .'_show_in_desktop" name="show_in_desktop" type="checkbox" onchange="updateRowUI(\''. $row['row_id'] .'\')"'.
                                            (isset($row['settings']['show_in_desktop']) && $row['settings']['show_in_desktop']!= 'off' ? ' checked="checked"' : '')
                                        .'/>'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $row['row_id'] .'_async">Async / Ajax</label>'.
                                        '<input id="'. $row['row_id'] .'_async" name="async" type="checkbox" onchange="updateRowUI(\''. $row['row_id'] .'\')"'. (isset($row['settings']['async']) && $row['settings']['async']!= 'off' ? ' checked="checked"': '')
                                        .'/>'.
                                    '</div>'.

                                    '<input id="'. $row['row_id'] .'_position" name="position" type="hidden" onchange="updateRowUI(\''. $row['row_id'] .'\')" value="'. $row['settings']['position'] .'">'.
                                '</form>'.
                            '</div>'.
                        '</em>'.

                        '<em>'.
                            '<a onclick="removeRow(\'#'. $row['row_id'] .'\')">Delete</a>'.
                        '</em>'.
                    '</div>'.
                '</div>'.
            '</span>'.
        '</header>'.
        '<div class="widgetColsWrapper ui-sortable">';

        foreach ($row['columns'] as $k => $column) {
            if (memoizeRows($column['column_id'])) continue;
            $tpl .= drawColumn($column, $Language);
            unset($row['colums'][$key]);
        }

        $tpl .= '</div>'.
        '<div class="grid_3">'.
            '<button class="button" onclick="addColumn(this)">Add Column</button>'.
        '</div>'.
    '</li>';

    return $tpl;
}

function drawColumn($column, $Language) {

    $tpl =
    '<div class="grid_'. $column['settings']['grid_large'] .' widgetColumn widgetBox" id="'. $column['column_id'] .'">'.
        '<header>'.
            '<span>'.
                '<small class="colMove ui-sortable-handle">'.
                    '<i class="fa fa-arrows fa-lg"></i>'.
                '</small>'.
                '<small>'. $column['column_id'] .'</small>'.
                '<small class="submenu">'.
                    '<i class="fa fa-bars"></i>'.
                    '<div>'.
                        '<em>'.
                            '<a class="advanced" href="#'. $column['column_id'] .'_config">Settings</a>'.
                            '<div style="display:none;" id="'. $column['column_id'] .'_config">'.
                                '<form id="'. $column['column_id'] .'_config_form">'.

                                    '<div class="row">'.
                                        '<label for="'. $column['column_id'] .'_show_in_mobile">Show In Mobiles</label>'.
                                        '<input id="'. $column['column_id'] .'_show_in_mobile" name="show_in_mobile" type="checkbox" onchange="updateColUI(\''. $column['column_id'] .'\')" checked="">'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $column['column_id'] .'_show_in_desktop">Show In Desktops</label>'.
                                        '<input id="'. $column['column_id'] .'_show_in_desktop" name="show_in_desktop" type="checkbox" onchange="updateColUI(\''. $column['column_id'] .'\')"'.
                                        (isset($column['settings']['show_in_desktop']) ? ' checked="checked"' : '')
                            .' />'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $column['column_id'] .'_async">Async / Ajax</label>'.
                                        '<input id="'. $column['column_id'] .'_async" name="async" type="checkbox" onchange="updateColUI(\''. $column['column_id'] .'\')"'.
                                       (isset($column['settings']['async']) ? ' checked="checked"' : '')
                                        .' />'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $column['column_id'] .'_grid_large">Grid Large</label>'.
                                        '<select id="'. $column['column_id'] .'_grid_large" name="grid_large" onchange="updateColUI(\''. $column['column_id'] .'\')">'.
                                            '<option value="1"'. ($column['settings']['grid_large'] == '1' ? ' selected="selected"' : '') .'>large-1</option>'.
                                            '<option value="2"'. ($column['settings']['grid_large'] == '2' ? ' selected="selected"' : '') .'>large-2</option>'.
                                            '<option value="3"'. ($column['settings']['grid_large'] == '3' ? ' selected="selected"' : '') .'>large-3</option>'.
                                            '<option value="4"'. ($column['settings']['grid_large'] == '4' ? ' selected="selected"' : '') .'>large-4</option>'.
                                            '<option value="5"'. ($column['settings']['grid_large'] == '5' ? ' selected="selected"' : '') .'>large-5</option>'.
                                            '<option value="6"'. ($column['settings']['grid_large'] == '6' ? ' selected="selected"' : '') .'>large-6</option>'.
                                            '<option value="7"'. ($column['settings']['grid_large'] == '7' ? ' selected="selected"' : '') .'>large-7</option>'.
                                            '<option value="8"'. ($column['settings']['grid_large'] == '8' ? ' selected="selected"' : '') .'>large-8</option>'.
                                            '<option value="9"'. ($column['settings']['grid_large'] == '9' ? ' selected="selected"' : '') .'>large-9</option>'.
                                            '<option value="10"'. ($column['settings']['grid_large'] == '10' ? ' selected="selected"' : '') .'>large-10</option>'.
                                            '<option value="11"'. ($column['settings']['grid_large'] == '11' ? ' selected="selected"' : '') .'>large-11</option>'.
                                            '<option value="12"'. ($column['settings']['grid_large'] == '12' ? ' selected="selected"' : '') .'>large-12</option>'.
                                        '</select>'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $column['column_id'] .'_grid_medium">Grid Medium</label>'.
                                        '<select id="'. $column['column_id'] .'_grid_medium" name="grid_medium" onchange="updateColUI(\''. $column['column_id'] .'\')">'.
                                            '<option value="1"'. ($column['settings']['grid_medium'] == '1' ? ' selected="selected"' : '') .'>medium-1</option>'.
                                            '<option value="2"'. ($column['settings']['grid_medium'] == '2' ? ' selected="selected"' : '') .'>medium-2</option>'.
                                            '<option value="3"'. ($column['settings']['grid_medium'] == '3' ? ' selected="selected"' : '') .'>medium-3</option>'.
                                            '<option value="4"'. ($column['settings']['grid_medium'] == '4' ? ' selected="selected"' : '') .'>medium-4</option>'.
                                            '<option value="5"'. ($column['settings']['grid_medium'] == '5' ? ' selected="selected"' : '') .'>medium-5</option>'.
                                            '<option value="6"'. ($column['settings']['grid_medium'] == '6' ? ' selected="selected"' : '') .'>medium-6</option>'.
                                            '<option value="7"'. ($column['settings']['grid_medium'] == '7' ? ' selected="selected"' : '') .'>medium-7</option>'.
                                            '<option value="8"'. ($column['settings']['grid_medium'] == '8' ? ' selected="selected"' : '') .'>medium-8</option>'.
                                            '<option value="9"'. ($column['settings']['grid_medium'] == '9' ? ' selected="selected"' : '') .'>medium-9</option>'.
                                            '<option value="10"'. ($column['settings']['grid_medium'] == '10' ? ' selected="selected"' : '') .'>medium-10</option>'.
                                            '<option value="11"'. ($column['settings']['grid_medium'] == '11' ? ' selected="selected"' : '') .'>medium-11</option>'.
                                            '<option value="12"'. ($column['settings']['grid_medium'] == '12' ? ' selected="selected"' : '') .'>medium-12</option>'.
                                        '</select>'.
                                    '</div>'.

                                    '<div class="row">'.
                                        '<label for="'. $column['column_id'] .'_grid_small">Grid Small</label>'.
                                        '<select id="'. $column['column_id'] .'_grid_small" name="grid_small" onchange="updateColUI(\''. $column['column_id'] .'\')">'.
                                            '<option value="1"'. ($column['settings']['grid_small'] == '1' ? ' selected="selected"' : '') .'>small-1</option>'.
                                            '<option value="2"'. ($column['settings']['grid_small'] == '2' ? ' selected="selected"' : '') .'>small-2</option>'.
                                            '<option value="3"'. ($column['settings']['grid_small'] == '3' ? ' selected="selected"' : '') .'>small-3</option>'.
                                            '<option value="4"'. ($column['settings']['grid_small'] == '4' ? ' selected="selected"' : '') .'>small-4</option>'.
                                            '<option value="5"'. ($column['settings']['grid_small'] == '5' ? ' selected="selected"' : '') .'>small-5</option>'.
                                            '<option value="6"'. ($column['settings']['grid_small'] == '6' ? ' selected="selected"' : '') .'>small-6</option>'.
                                            '<option value="7"'. ($column['settings']['grid_small'] == '7' ? ' selected="selected"' : '') .'>small-7</option>'.
                                            '<option value="8"'. ($column['settings']['grid_small'] == '8' ? ' selected="selected"' : '') .'>small-8</option>'.
                                            '<option value="9"'. ($column['settings']['grid_small'] == '9' ? ' selected="selected"' : '') .'>small-9</option>'.
                                            '<option value="10"'. ($column['settings']['grid_small'] == '10' ? ' selected="selected"' : '') .'>small-10</option>'.
                                            '<option value="11"'. ($column['settings']['grid_small'] == '11' ? ' selected="selected"' : '') .'>small-11</option>'.
                                            '<option value="12"'. ($column['settings']['grid_small'] == '12' ? ' selected="selected"' : '') .'>small-12</option>'.
                                        '</select>'.
                                    '</div>'.

                                    '<input id="'. $column['column_id'] .'_position" name="position" type="hidden" onchange="updateColUI(\''. $column['column_id'] .'\')" value="'. $column['settings']['position'] .'">'.
                                '</form>'.
                            '</div>'.
                        '</em>'.
                        '<em>'.
                            '<a onclick="removeColumn(\'#'. $column['column_id'] .'\')">Delete</a>'.
                        '</em>'.
                    '</div>'.
                '</small>'.
            '</span>'.
        '</header>'.
        '<ul class="widgetWrapper ui-sortable" id="'. $column['column_id'] .'_widgets">';

        foreach ($column['widgets'] as $widget) {
            $tpl .=
            '<li class="widgetSet" id="'. $widget['name'] .'">'.
                '<b class="widgetTitle">'. ($Language->get('text_'. $widget['extension'])) .'</b><br />'.
                '<a class="advanced" href="#'. $widget['name'] .'_attributes">'. ($Language->get('Advanced')) .'</a><br />'.
                '<div id="'. $widget['name'] .'_attributes" class="attributes"></div>'.
                '<div style="float:right">'.
                    '<a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>'.
                    '<a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>'.
                    '</div>'.
            '</li>'.
            '<script type="text/javascript">'.
                '$(function(){ '.
                    'loadNtWidgets({ '.
                        'name: \''. $widget['name'] .'\', '.
                        'position: \''. $widget['position'] .'\', '.
                        'extension: \''. $widget['extension'] .'\', '.
                        'order: \''. (int)$widget['order'] .'\' '.
                    '}); '.
                '}); '.
            '</script> ';
        }

        $tpl .= '</ul>'.
    '</div>';

    return $tpl;
}