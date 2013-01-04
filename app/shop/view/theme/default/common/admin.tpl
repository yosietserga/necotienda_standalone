    <div id="adminTopNav">
            <ul>
                <li>
                    <a href="#" title="Clientes Nuevos">
                        <span>Editar</span>
                        <?php if ($new_customers) { ?><span class="numberTop"><?php echo (int)$new_customers; ?></span><?php } ?>
                    </a>
                </li>
                <li class="dd">
                    <span>Crear &darr;</span>
                    <ul class="menu_body">
                        <li><a href="<?php echo $create_product; ?>" title="Crear Producto">Producto</a></li>
                        <li><a href="<?php echo $create_page; ?>" title="Crear Producto">P&aacute;gina</a></li>
                        <li><a href="<?php echo $create_post; ?>" title="Crear Producto">Art&iacute;culo</a></li>
                        <li><a href="<?php echo $create_manufacturer; ?>" title="Crear Producto">Fabricante</a></li>
                        <li><a href="<?php echo $create_product_category; ?>" title="Crear Producto">Categor&iacute;a de Productos</a></li>
                        <li><a href="<?php echo $create_post_category; ?>" title="Crear Producto">Categor&iacute;a de Art&iacute;los</a></li>
                    </ul>
                </li>
            </ul>
    </div>
    
    <input type="hidden" id="selector" name="selector" value="" />

    <div class="panel-lateral" id="style">
        <a class="label style" onclick="slidePanel('style')"></a>
        
        <select onchange="drawPanels(this.value);">
            <option value="html,body">General</option>
            <option value="#header">Cabecera</option>
            <option value="#nav">Men&uacute; Principal</option>
            <option value="#column_left">Col. Izquierda</option>
            <option value="#column_right">Col. Derecha</option>
            <option value="#footer">Pie de P&aacute;gina</option>
        </select>
        
        <a class="style-icons nuevo" onclick="newStyle()"></a>
        <a class="style-icons save" onclick="saveStyle()"></a>
        <a class="style-icons clean" onclick="cleanStyle()"></a>
        <a class="style-icons copy" onclick="copyStyle()"></a>
        <a class="style-icons paste" onclick="pasteStyle()"></a>
        <a class="style-icons print" onclick="printStyle()"></a>
        
        <h3>Selector: <span id="el"></span></h3>
        <div class="panelWrapper">
            <h3>Fondo (Background)</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="bg-colorpicker"></div></td>
                        <td>
                            <input class="style-panel" type="text" id="bgColor" name="Background[background-color]" value="" />
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Imagen:</td>
                        <td><input class="style-panel" type="url" id="bgImage" name="Background[background-image]" value="" /></td>
                    </tr>
                    <tr>
                        <td>Repetir la imagen:</td>
                        <td>
                            <select class="style-panel" id="bgRepeat" name="Background[background-repeat]">
                                <option value="">Ninguno</option>
                                <option value="repeat">Repetir</option>
                                <option value="repeat-x">De Izquierda a Derecha</option>
                                <option value="repeat-y">De Arriba a Abajo</option>
                                <option value="no-repeat">No Repetir</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Posici&oacute;n de la imagen (x,y):</td>
                        <td>
                            <input class="style-panel" type="number" id="bgPositionX" name="Background[background-position-x]" value="" style="width:40px" />px&nbsp;
                            <input class="style-panel" type="number" id="bgPositionY" name="Background[background-position-y]" value="" style="width:40px" />px
                        </td>
                    </tr>
                    <tr>
                        <td>Anclar imagen:</td>
                        <td>
                            <input class="style-panel" type="checkbox" id="bgAttachment" name="Background[background-attachment]" value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td><a class="button" onclick="resetBackground()">Limpiar</a></td>
                        <td><a class="button" onclick="setStyle()">Aplicar</a></td>
                    </tr>
                </table>
            </div>
            
            <h3>T&iacute;tulos &lt;h1&gt;</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="title-colorpicker"></div></td>
                        <td>
                            <input class="style-panel" type="text" id="titleColor" name="Title[color]" value="" />
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo de letra:</td>
                        <td>
                            <select class="style-panel" id="titleFamily" name="Title[font-familiy]">
                                <option value="">Ninguno</option>
                                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                <option value="Georgia, 'Times New Roman', Times, serif">Georgia</option>
                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                <option value="Arial, Helvetica, sans-serif">Arial</option>
                                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                <option value="'Trebuchet MS', Arial, Helvetica, sans-serif">Trebuchet MS</option>
                                <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode</option>
                                <option value="'MS Serif', 'New York', serif">MS Serif</option>
                                <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                <option value="'Comic Sans MS', cursive">Comic Sans MS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tama&ntilde;o:</td>
                        <td>
                            <select class="style-panel" id="titleSize" name="Title[font-size]">
                                <option value="">Ninguno</option>
                                <option value="8px">8</option>
                                <option value="9px">9</option>
                                <option value="10px">10</option>
                                <option value="11px">11</option>
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="18px">18</option>
                                <option value="22px">22</option>
                                <option value="24px">24</option>
                                <option value="28px">28</option>
                                <option value="32px">32</option>
                                <option value="36px">36</option>
                                <option value="40px">40</option>
                                <option value="44px">44</option>
                                <option value="48px">48</option>
                                <option value="54px">54</option>
                                <option value="60px">60</option>
                                <option value="72px">72</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Letras:</td>
                        <td>
                            <div id="letterSpacingTitleSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="titleLetterSpacing" name="Title[letter-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Palabras:</td>
                        <td>
                            <div id="wordSpacingTitleSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="titleWordSpacing" name="Title[word-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de L&iacute;neas:</td>
                        <td>
                            <div id="lineHeightTitleSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="titleLineHeight" name="Title[line-height]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        
                        <a id="fontWeightTitle" class="bold style-icons" onclick="setWeight(this,'bold','boldOn','titleWeight')"></a>
                        <input class="style-panel" type="hidden" id="titleWeight" name="Title[font-weight]" value="" />
                            
                        <a id="fontStyleTitle" class="italic style-icons" onclick="setItalic(this,'italic','italicOn','titleStyle')"></a>
                        <input class="style-panel" type="hidden" id="titleStyle" name="Title[font-style]" value="" />
                            
                        <a id="underlineTitle" class="underline style-icons" onclick="setDecoration(this,'Title','underline','underlineOn','titleDecoration')"></a>
                        <a id="lineThroughTitle" class="line-through style-icons" onclick="setDecoration(this,'Title','line-through','line-throughOn','titleDecoration')"></a>
                        <input class="style-panel" type="hidden" id="titleDecoration" name="Title[text-decoration]" value="" />
                            
                        <a id="upperTitle" class="uppercase style-icons" onclick="setTransform(this,'Title','uppercase','uppercaseOn','titleTransform')"></a>
                        <a id="lowerTitle" class="lowercase style-icons" onclick="setTransform(this,'Title','lowercase','lowercaseOn','titleTransform')"></a>
                        <input class="style-panel" type="hidden" id="titleTransform" name="Title[text-transform]" value="" />
                        
                        <a id="alignLeftTitle" class="align-left style-icons" onclick="setAlign(this,'Title','left','align-leftOn','titleAlign')"></a>
                        <a id="alignCenterTitle" class="align-center style-icons" onclick="setAlign(this,'Title','center','align-centerOn','titleAlign')"></a>
                        <a id="alignRightTitle" class="align-right style-icons" onclick="setAlign(this,'Title','right','align-rightOn','titleAlign')"></a>
                        <a id="alignJustifyTitle" class="align-justify style-icons" onclick="setAlign(this,'Title','justify','align-justifyOn','titleAlign')"></a>
                        <input class="style-panel" type="hidden" id="titleAlign" name="Title[text-align]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><a class="button" onclick="resetTitle()">Limpiar</a></td>
                        <td><a class="button" onclick="setStyle()">Aplicar</a></td>
                    </tr>
                </table>
            </div>
            
            <h3>Sub-T&iacute;tulos &lt;[h2-h6]&gt;</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="subtitle-colorpicker"></div></td>
                        <td>
                            <input class="style-panel" type="text" id="subtitleColor" name="Subtitle[color]" value="" />
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo de letra:</td>
                        <td>
                            <select class="style-panel" id="subtitleFamily" name="Subtitle[font-familiy]">
                                <option value="">Ninguno</option>
                                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                <option value="Georgia, 'Times New Roman', Times, serif">Georgia</option>
                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                <option value="Arial, Helvetica, sans-serif">Arial</option>
                                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                <option value="'Trebuchet MS', Arial, Helvetica, sans-serif">Trebuchet MS</option>
                                <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode</option>
                                <option value="'MS Serif', 'New York', serif">MS Serif</option>
                                <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                <option value="'Comic Sans MS', cursive">Comic Sans MS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tama&ntilde;o:</td>
                        <td>
                            <select class="style-panel" id="subtitleSize" name="Subtitle[font-size]">
                                <option value="">Ninguno</option>
                                <option value="8px">8</option>
                                <option value="9px">9</option>
                                <option value="10px">10</option>
                                <option value="11px">11</option>
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="18px">18</option>
                                <option value="22px">22</option>
                                <option value="24px">24</option>
                                <option value="28px">28</option>
                                <option value="32px">32</option>
                                <option value="36px">36</option>
                                <option value="40px">40</option>
                                <option value="44px">44</option>
                                <option value="48px">48</option>
                                <option value="54px">54</option>
                                <option value="60px">60</option>
                                <option value="72px">72</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Letras:</td>
                        <td>
                            <div id="letterSpacingSubtitleSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="subtitleLetterSpacing" name="Subtitle[letter-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Palabras:</td>
                        <td>
                            <div id="wordSpacingSubtitleSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="subtitleWordSpacing" name="Subtitle[word-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de L&iacute;neas:</td>
                        <td>
                            <div id="lineHeightSubtitleSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="subtitleLineHeight" name="Subtitle[line-height]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        
                        <a id="fontWeightSubtitle" class="bold style-icons" onclick="setWeight(this,'bold','boldOn','subtitleWeight')"></a>
                        <input class="style-panel" type="hidden" id="subtitleWeight" name="Subtitle[font-weight]" value="" />
                            
                        <a id="fontStyleSubtitle" class="italic style-icons" onclick="setItalic(this,'italic','italicOn','subtitleStyle')"></a>
                        <input class="style-panel" type="hidden" id="subtitleStyle" name="Subtitle[font-style]" value="" />
                            
                        <a id="underlineSubtitle" class="underline style-icons" onclick="setDecoration(this,'Subtitle','underline','underlineOn','subtitleDecoration')"></a>
                        <a id="lineThroughSubtitle" class="line-through style-icons" onclick="setDecoration(this,'Subtitle','line-through','line-throughOn','subtitleDecoration')"></a>
                        <input class="style-panel" type="hidden" id="subtitleDecoration" name="Subtitle[text-decoration]" value="" />
                            
                        <a id="upperSubtitle" class="uppercase style-icons" onclick="setTransform(this,'Subtitle','uppercase','uppercaseOn','subtitleTransform')"></a>
                        <a id="lowerSubtitle" class="lowercase style-icons" onclick="setTransform(this,'Subtitle','lowercase','lowercaseOn','subtitleTransform')"></a>
                        <input class="style-panel" type="hidden" id="subtitleTransform" name="Subtitle[text-transform]" value="" />
                        
                        <a id="alignLeftSubtitle" class="align-left style-icons" onclick="setAlign(this,'Subtitle','left','align-leftOn','subtitleAlign')"></a>
                        <a id="alignCenterSubtitle" class="align-center style-icons" onclick="setAlign(this,'Subtitle','center','align-centerOn','subtitleAlign')"></a>
                        <a id="alignRightSubtitle" class="align-right style-icons" onclick="setAlign(this,'Subtitle','right','align-rightOn','subtitleAlign')"></a>
                        <a id="alignJustifySubtitle" class="align-justify style-icons" onclick="setAlign(this,'Subtitle','justify','align-justifyOn','subtitleAlign')"></a>
                        <input class="style-panel" type="hidden" id="subtitleAlign" name="Subtitle[text-align]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><a class="button" onclick="resetSubtitle()">Limpiar</a></td>
                        <td><a class="button" onclick="setStyle()">Aplicar</a></td>
                    </tr>
                </table>
            </div>
            
            <h3>P&aacute;rrafos &lt;p&gt;</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="p-colorpicker"></div></td>
                        <td>
                            <input class="style-panel" type="text" id="pColor" name="P[color]" value="" />
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo de letra:</td>
                        <td>
                            <select class="style-panel" id="pFamily" name="P[font-familiy]">
                                <option value="">Ninguno</option>
                                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                <option value="Georgia, 'Times New Roman', Times, serif">Georgia</option>
                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                <option value="Arial, Helvetica, sans-serif">Arial</option>
                                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                <option value="'Trebuchet MS', Arial, Helvetica, sans-serif">Trebuchet MS</option>
                                <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode</option>
                                <option value="'MS Serif', 'New York', serif">MS Serif</option>
                                <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                <option value="'Comic Sans MS', cursive">Comic Sans MS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tama&ntilde;o:</td>
                        <td>
                            <select class="style-panel" id="pSize" name="P[font-size]">
                                <option value="">Ninguno</option>
                                <option value="8px">8</option>
                                <option value="9px">9</option>
                                <option value="10px">10</option>
                                <option value="11px">11</option>
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="18px">18</option>
                                <option value="22px">22</option>
                                <option value="24px">24</option>
                                <option value="28px">28</option>
                                <option value="32px">32</option>
                                <option value="36px">36</option>
                                <option value="40px">40</option>
                                <option value="44px">44</option>
                                <option value="48px">48</option>
                                <option value="54px">54</option>
                                <option value="60px">60</option>
                                <option value="72px">72</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Letras:</td>
                        <td>
                            <div id="letterSpacingPSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="pLetterSpacing" name="P[letter-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Palabras:</td>
                        <td>
                            <div id="wordSpacingPSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="pWordSpacing" name="P[word-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de L&iacute;neas:</td>
                        <td>
                            <div id="lineHeightPSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="pLineHeight" name="P[line-height]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        
                        <a id="fontWeightP" class="bold style-icons" onclick="setWeight(this,'bold','boldOn','pWeight')"></a>
                        <input class="style-panel" type="hidden" id="pWeight" name="P[font-weight]" value="" />
                            
                        <a id="fontStyleP" class="italic style-icons" onclick="setItalic(this,'italic','italicOn','pStyle')"></a>
                        <input class="style-panel" type="hidden" id="pStyle" name="P[font-style]" value="" />
                            
                        <a id="underlineP" class="underline style-icons" onclick="setDecoration(this,'P','underline','underlineOn','pDecoration')"></a>
                        <a id="lineThroughP" class="line-through style-icons" onclick="setDecoration(this,'P','line-through','line-throughOn','pDecoration')"></a>
                        <input class="style-panel" type="hidden" id="pDecoration" name="P[text-decoration]" value="" />
                            
                        <a id="upperP" class="uppercase style-icons" onclick="setTransform(this,'P','uppercase','uppercaseOn','pTransform')"></a>
                        <a id="lowerP" class="lowercase style-icons" onclick="setTransform(this,'P','lowercase','lowercaseOn','pTransform')"></a>
                        <input class="style-panel" type="hidden" id="pTransform" name="P[text-transform]" value="" />
                        
                        <a id="alignLeftP" class="align-left style-icons" onclick="setAlign(this,'P','left','align-leftOn','pAlign')"></a>
                        <a id="alignCenterP" class="align-center style-icons" onclick="setAlign(this,'P','center','align-centerOn','pAlign')"></a>
                        <a id="alignRightP" class="align-right style-icons" onclick="setAlign(this,'P','right','align-rightOn','pAlign')"></a>
                        <a id="alignJustifyP" class="align-justify style-icons" onclick="setAlign(this,'P','justify','align-justifyOn','pAlign')"></a>
                        <input class="style-panel" type="hidden" id="pAlign" name="P[text-align]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><a class="button" onclick="resetP()">Limpiar</a></td>
                        <td><a class="button" onclick="setStyle()">Aplicar</a></td>
                    </tr>
                </table>
            </div>
            
            <h3>&Eacute;nfasis &lt;b&gt;</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="b-colorpicker"></div></td>
                        <td>
                            <input class="style-panel" type="text" id="bColor" name="B[color]" value="" />
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo de letra:</td>
                        <td>
                            <select class="style-panel" id="bFamily" name="B[font-familiy]">
                                <option value="">Ninguno</option>
                                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                <option value="Georgia, 'Times New Roman', Times, serif">Georgia</option>
                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                <option value="Arial, Helvetica, sans-serif">Arial</option>
                                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                <option value="'Trebuchet MS', Arial, Helvetica, sans-serif">Trebuchet MS</option>
                                <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode</option>
                                <option value="'MS Serif', 'New York', serif">MS Serif</option>
                                <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                <option value="'Comic Sans MS', cursive">Comic Sans MS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tama&ntilde;o:</td>
                        <td>
                            <select class="style-panel" id="bSize" name="B[font-size]">
                                <option value="">Ninguno</option>
                                <option value="8px">8</option>
                                <option value="9px">9</option>
                                <option value="10px">10</option>
                                <option value="11px">11</option>
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="18px">18</option>
                                <option value="22px">22</option>
                                <option value="24px">24</option>
                                <option value="28px">28</option>
                                <option value="32px">32</option>
                                <option value="36px">36</option>
                                <option value="40px">40</option>
                                <option value="44px">44</option>
                                <option value="48px">48</option>
                                <option value="54px">54</option>
                                <option value="60px">60</option>
                                <option value="72px">72</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Letras:</td>
                        <td>
                            <div id="letterSpacingBSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="bLetterSpacing" name="B[letter-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Palabras:</td>
                        <td>
                            <div id="wordSpacingBSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="bWordSpacing" name="B[word-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de L&iacute;neas:</td>
                        <td>
                            <div id="lineHeightBSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="bLineHeight" name="B[line-height]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        
                        <a id="fontWeightB" class="bold style-icons" onclick="setWeight(this,'bold','boldOn','bWeight')"></a>
                        <input class="style-panel" type="hidden" id="bWeight" name="B[font-weight]" value="" />
                            
                        <a id="fontStyleB" class="italic style-icons" onclick="setItalic(this,'italic','italicOn','bStyle')"></a>
                        <input class="style-panel" type="hidden" id="bStyle" name="B[font-style]" value="" />
                            
                        <a id="underlineB" class="underline style-icons" onclick="setDecoration(this,'B','underline','underlineOn','bDecoration')"></a>
                        <a id="lineThroughB" class="line-through style-icons" onclick="setDecoration(this,'B','line-through','line-throughOn','bDecoration')"></a>
                        <input class="style-panel" type="hidden" id="bDecoration" name="B[text-decoration]" value="" />
                            
                        <a id="upperB" class="uppercase style-icons" onclick="setTransform(this,'B','uppercase','uppercaseOn','bTransform')"></a>
                        <a id="lowerB" class="lowercase style-icons" onclick="setTransform(this,'B','lowercase','lowercaseOn','bTransform')"></a>
                        <input class="style-panel" type="hidden" id="bTransform" name="B[text-transform]" value="" />
                        
                        <a id="alignLeftB" class="align-left style-icons" onclick="setAlign(this,'B','left','align-leftOn','bAlign')"></a>
                        <a id="alignCenterB" class="align-center style-icons" onclick="setAlign(this,'B','center','align-centerOn','bAlign')"></a>
                        <a id="alignRightB" class="align-right style-icons" onclick="setAlign(this,'B','right','align-rightOn','bAlign')"></a>
                        <a id="alignJustifyB" class="align-justify style-icons" onclick="setAlign(this,'B','justify','align-justifyOn','bAlign')"></a>
                        <input class="style-panel" type="hidden" id="bAlign" name="B[text-align]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><a class="button" onclick="resetB()">Limpiar</a></td>
                        <td><a class="button" onclick="setStyle()">Aplicar</a></td>
                    </tr>
                </table>
            </div>
            
            <h3>Enlaces &lt;a&gt;</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="a-colorpicker"></div></td>
                        <td><input class="style-panel" type="text" id="aColor" name="A[color]" value="" /></td>
                    </tr>
                    <tr>
                        <td>Tipo de letra:</td>
                        <td>
                            <select class="style-panel" id="aFamily" name="A[font-familiy]">
                                <option value="">Ninguno</option>
                                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                <option value="Georgia, 'Times New Roman', Times, serif">Georgia</option>
                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                <option value="Arial, Helvetica, sans-serif">Arial</option>
                                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                <option value="'Trebuchet MS', Arial, Helvetica, sans-serif">Trebuchet MS</option>
                                <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode</option>
                                <option value="'MS Serif', 'New York', serif">MS Serif</option>
                                <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                <option value="'Comic Sans MS', cursive">Comic Sans MS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tama&ntilde;o:</td>
                        <td>
                            <select class="style-panel" id="aSize" name="A[font-size]">
                                <option value="">Ninguno</option>
                                <option value="8px">8</option>
                                <option value="9px">9</option>
                                <option value="10px">10</option>
                                <option value="11px">11</option>
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="18px">18</option>
                                <option value="22px">22</option>
                                <option value="24px">24</option>
                                <option value="28px">28</option>
                                <option value="32px">32</option>
                                <option value="36px">36</option>
                                <option value="40px">40</option>
                                <option value="44px">44</option>
                                <option value="48px">48</option>
                                <option value="54px">54</option>
                                <option value="60px">60</option>
                                <option value="72px">72</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Letras:</td>
                        <td>
                            <div id="letterSpacingASlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="aLetterSpacing" name="A[letter-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de Palabras:</td>
                        <td>
                            <div id="wordSpacingASlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="aWordSpacing" name="A[word-spacing]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Espacio de L&iacute;neas:</td>
                        <td>
                            <div id="lineHeightASlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="aLineHeight" name="A[line-height]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        
                        <a id="fontWeightA" class="bold style-icons" onclick="setWeight(this,'bold','boldOn','aWeight')"></a>
                        <input class="style-panel" type="hidden" id="aWeight" name="A[font-weight]" value="" />
                            
                        <a id="fontStyleA" class="italic style-icons" onclick="setItalic(this,'italic','italicOn','aStyle')"></a>
                        <input class="style-panel" type="hidden" id="aStyle" name="A[font-style]" value="" />
                            
                        <a id="underlineA" class="underline style-icons" onclick="setDecoration(this,'A','underline','underlineOn','aDecoration')"></a>
                        <a id="lineThroughA" class="line-through style-icons" onclick="setDecoration(this,'A','line-through','line-throughOn','aDecoration')"></a>
                        <input class="style-panel" type="hidden" id="aDecoration" name="A[text-decoration]" value="" />
                            
                        <a id="upperA" class="uppercase style-icons" onclick="setTransform(this,'A','uppercase','uppercaseOn','aTransform')"></a>
                        <a id="lowerA" class="lowercase style-icons" onclick="setTransform(this,'A','lowercase','lowercaseOn','aTransform')"></a>
                        <input class="style-panel" type="hidden" id="aTransform" name="A[text-transform]" value="" />
                        
                        <a id="alignLeftA" class="align-left style-icons" onclick="setAlign(this,'A','left','align-leftOn','aAlign')"></a>
                        <a id="alignCenterA" class="align-center style-icons" onclick="setAlign(this,'A','center','align-centerOn','aAlign')"></a>
                        <a id="alignRightA" class="align-right style-icons" onclick="setAlign(this,'A','right','align-rightOn','aAlign')"></a>
                        <a id="alignJustifyA" class="align-justify style-icons" onclick="setAlign(this,'A','justify','align-justifyOn','aAlign')"></a>
                        <input class="style-panel" type="hidden" id="aAlign" name="A[text-align]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><a class="button" onclick="resetA()">Limpiar</a></td>
                        <td><a class="button" onclick="setStyle()">Aplicar</a></td>
                    </tr>
                </table>
            </div>
            
            <h3>Bordes</h3>
            <div>
                <a onclick="showAdvanced(this)">Opciones Avanzadas</a>
                <input class="style-panel advanced" type="hidden" id="borderAdvanced" value="" />
                <div>
                    <table>
                        <tr>
                            <td colspan="2"><b>B&aacute;sico</b></td>
                        </tr>
                        <tr>
                            <td>Color:<div id="border-colorpicker"></div></td>
                            <td><input class="style-panel" type="text" id="borderColor" name="Border[color]" value="" /></td>
                        </tr>
                        <tr>
                            <td>L&iacute;nea:</td>
                            <td>
                                <select class="style-panel" id="borderStyle" name="Border[border-style]">
                                    <option value="">Ninguno</option>
                                    <option value="solid">Continua</option>
                                    <option value="dashed">Cortada</option>
                                    <option value="dotted">Punteada</option>
                                    <option value="double">Doble</option>
                                    <option value="groove">Continua</option>
                                    <option value="ridge">Continua</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Grosor:</td>
                            <td>
                                <div id="borderWidthSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderWidth" name="Border[border-width]" value="" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="display: none;">
                    <table>
                        <tr>
                            <td colspan="2"><b>Avanzado</b></td>
                        </tr>
                        <tr>
                            <td>Color Borde Superior:<div id="border_top_colorpicker"></div></td>
                            <td><input class="style-panel" type="text" id="borderTopColor" name="Border[border-top-color]" value="" /></td>
                        </tr>
                        <tr>
                            <td>L&iacute;nea Borde Superior:</td>
                            <td>
                                <select class="style-panel" id="borderTopStyle" name="Border[border-top-style]">
                                    <option value="">Ninguno</option>
                                    <option value="solid">Continua</option>
                                    <option value="dashed">Cortada</option>
                                    <option value="dotted">Punteada</option>
                                    <option value="double">Doble</option>
                                    <option value="groove">Continua</option>
                                    <option value="ridge">Continua</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Grosor Borde Superior:</td>
                            <td>
                                <div id="borderTopWidthSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderTopWidth" name="Border[border-top-width]" value="" />
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr /></td></tr>
                        <tr>
                            <td>Color Borde Derecho:<div id="border-right-colorpicker"></div></td>
                            <td><input class="style-panel" type="text" id="borderRightColor" name="Border[border-right-color]" value="" /></td>
                        </tr>
                        <tr>
                            <td>L&iacute;nea Borde Derecho:</td>
                            <td>
                                <select class="style-panel" id="borderRightStyle" name="Border[border-right-style]">
                                    <option value="">Ninguno</option>
                                    <option value="solid">Continua</option>
                                    <option value="dashed">Cortada</option>
                                    <option value="dotted">Punteada</option>
                                    <option value="double">Doble</option>
                                    <option value="groove">Continua</option>
                                    <option value="ridge">Continua</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Grosor Borde Derecho:</td>
                            <td>
                                <div id="borderRightWidthSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderRightWidth" name="Border[border-right-width]" value="" />
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr /></td></tr>
                        <tr>
                            <td>Color Borde Inferior:<div id="border-bottom-colorpicker"></div></td>
                            <td><input class="style-panel" type="text" id="borderBottomColor" name="Border[border-bottom-color]" value="" /></td>
                        </tr>
                        <tr>
                            <td>L&iacute;nea Borde Inferior:</td>
                            <td>
                                <select class="style-panel" id="borderBottomStyle" name="Border[border-bottom-style]">
                                    <option value="">Ninguno</option>
                                    <option value="solid">Continua</option>
                                    <option value="dashed">Cortada</option>
                                    <option value="dotted">Punteada</option>
                                    <option value="double">Doble</option>
                                    <option value="groove">Continua</option>
                                    <option value="ridge">Continua</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Grosor Borde Inferior:</td>
                            <td>
                                <div id="borderBottomWidthSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderBottomWidth" name="Border[border-bottom-width]" value="" />
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr /></td></tr>
                        <tr>
                            <td>Color Borde Izquierdo:<div id="border-left-colorpicker"></div></td>
                            <td><input class="style-panel" type="text" id="borderLeftColor" name="Border[border-left-color]" value="" /></td>
                        </tr>
                        <tr>
                            <td>L&iacute;nea Borde Izquierdo:</td>
                            <td>
                                <select class="style-panel" id="borderLeftStyle" name="Border[border-left-style]">
                                    <option value="">Ninguno</option>
                                    <option value="solid">Continua</option>
                                    <option value="dashed">Cortada</option>
                                    <option value="dotted">Punteada</option>
                                    <option value="double">Doble</option>
                                    <option value="groove">Continua</option>
                                    <option value="ridge">Continua</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Grosor Borde Izquierdo:</td>
                            <td>
                                <div id="borderLeftWidthSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderLeftWidth" name="Border[border-left-width]" value="" />
                            </td>
                        </tr>
                    </table>   
                </div>
            </div>
            
            <h3>Redondeo (border-radius)</h3>
            <div>
                <a onclick="showAdvanced(this)">Opciones Avanzadas</a>
                <input class="style-panel advanced" type="hidden" id="borderRadiusAdvanced" value="" />
                <div>
                    <table>
                        <tr>
                            <td colspan="2"><b>B&aacute;sico</b></td>
                        </tr>
                        <tr>
                            <td>Redondeo:</td>
                            <td>
                                <div id="borderRadiusSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderRadius" name="Border[border-radius]" value="" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="display:none;">
                    <table>
                        <tr>
                            <td colspan="2"><b>Avanzado</b></td>
                        </tr>
                        <tr>
                            <td>Superior Izquierdo:</td>
                            <td>
                                <div id="borderRadiusTopLeftSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderRadiusTopLeft" name="Border[border-radius-topleft]" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Superior Derecho:</td>
                            <td>
                                <div id="borderRadiusTopRightSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderRadiusTopRight" name="Border[border-radius-topright]" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Inferior Derecho:</td>
                            <td>
                                <div id="borderRadiusBottomRightSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderRadiusBottomRight" name="Border[border-radius-bottomright]" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Inferior Izquierdo:</td>
                            <td>
                                <div id="borderRadiusBottomLeftSlider" style="width: 180px;display:block"></div>
                                <input class="style-panel" type="hidden" id="borderRadiusBottomLeft" name="Border[border-radius-bottomleft]" value="" />
                            </td>
                        </tr>
                    </table>   
                </div>
            </div>
            
            <h3>Sombras</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:<div id="box-colorpicker"></div></td>
                        <td><input class="style-panel" type="text" id="boxColor" name="Box[color]" value="" /></td>
                    </tr>
                    <tr>
                        <td>Sombra Interna:</td>
                        <td><input class="style-panel" type="checkbox" id="boxShadowInset" name="Box[box-shadow-inset]" value="1" /></td>
                    </tr>
                    <tr>
                        <td>Distancia Horizontal:</td>
                        <td>
                            <div id="boxShadowXSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="boxShadowX" name="Box[box-shadow-x]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Distancia Vertical:</td>
                        <td>
                            <div id="boxShadowYSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="boxShadowY" name="Box[box-shadow-y]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Desenfoque (blur):</td>
                        <td>
                            <div id="boxShadowBlurSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="boxShadowBlur" name="Box[box-shadow-blur]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>Difusi&oacute;n (spread):</td>
                        <td>
                            <div id="boxShadowSpreadSlider" style="width: 180px;display:block"></div>
                            <input class="style-panel" type="hidden" id="boxShadowSpread" name="Box[box-shadow-spread]" value="" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <h3>M&aacute;rgenes</h3>
            <div>
                <table>
                    <tr>
                        <td>Color:</td>
                        <td>
                            <input class="style-panel" type="text" id="aColor" name="A[color]" value="" />
                            
                        </td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
    
    <div class="panel-lateral" id="tools">
        <a class="label tools" onclick="slidePanel('tools')"></a>
        <div class="panelWrapper">
            
            
            <h3>CSS</h3>
            <div>
                <p>Pasos para generar degradados:</p>
                <ol>
                    <li>Ingresa a <a href="http://csstypeset.com/" target="_blank">CSS Type Set</a>.</li>
                    <li>Crea las combinaciones de colores y efectos que desees.</li>
                    <li>Copia el c&oacute;digo CSS generado.</li>
                    <li>P&eacute;galo en campo de texto y listo.</li>
                </ol>
                <textarea id="cssFont" name="Font[css]"></textarea>
            </div>
        </div>
    </div>
    
    <div id="admin-bottom-menu">BOTTOM</div>