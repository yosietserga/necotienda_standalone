<div class="container_16">
    <footer id="footer">
    
        <div class="grid_4">
            <h2>La Empresa</h2>
            <ul>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Sobre Nosotros</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Sucursales</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Marcas Distribuidas</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Condiciones de Garant&iacute;as</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Pol&iacute;ticas de Privacidad</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">T&eacute;rminos y Condiciones de Uso</a></li>
            </ul>
        </div>
        
        <div class="grid_4">
            <h2>Productos</h2>
            <ul>
                <li><a href="<?php echo HTTP_HOME; ?>caminadoras">Caminadoras</a></li>
                <li><a href="<?php echo HTTP_HOME; ?>elipticas">El&iacute;pticas</a></li>
                <li><a href="<?php echo HTTP_HOME; ?>multifuerzas">Multifuerzas</a></li>
                <li><a href="<?php echo HTTP_HOME; ?>bicicletas">Bicicletas</a></li>
                <li><a href="<?php echo HTTP_HOME; ?>abdominales">Abdominales</a></li>
                <li><a href="<?php echo HTTP_HOME; ?>accesorios">Accesorios</a></li>
            </ul>
        </div>
        
        <div class="grid_4">
            <h2>Soporte</h2>
            <ul>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Consejos de Mantenimientos</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Centros de Servicios</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Manuales y Documentaciones</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Consejos Nutricionales</a></li>
            </ul>
        </div>
        
        <div class="grid_4">
            <h2>Contactos</h2>
            <ul>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Formulario de Contacto</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Tiendas y Sucursales</a></li>
                <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>">Redes Sociales</a></li>
            </ul>
        </div>
        
        <div class="clear">&nbsp;</div>
        
        <div class="grid_16">
            <p>
                <a href="<?php echo str_replace('&', '&amp;', $home); ?>">Inicio</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $about_us); ?>">Nosotros</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $special); ?>">Ofertas</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $faq); ?>">Preguntas Frecuentes</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $jobs); ?>">Empleos</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $contact); ?>">Contacto</a>
            </p>
        </div>
        
        <div class="clear">&nbsp;</div>
        
        <div class="grid_16"><p><?php echo $text_powered_by; ?></p></div>
        
    </footer>
</div>

<?php if (count($javascripts) > 0) { ?>
    <?php foreach ($javascripts as $js) { ?>
        <?php if (empty($js)) continue; ?>
<script type="text/javascript" src="<?php echo $js; ?>"></script> 
    <?php } ?>
<?php } ?>

<?php if ($scripts) echo $scripts; ?>

<script type="text/javascript">
$(function() {
    $("#footer li").on('mouseover',function(e){
        $(this).animate({marginLeft:'10px'},500);
    }).on('mouseout',function(e){
        $(this).animate({marginLeft:'0px'},500);
    });
});
</script>

<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
  
<script>
/* TODO: indicio para reconocer todas los shortcodes y reemplazarlos por el codigo correspondiente al estilo de wordpress */
$(function(){
    pattern = /\{%(.*?)\%}/g;
    /* {%algo_que_decir%} */
    reg = new RegExp(pattern);
    var matches = $('body').html().match(pattern);
    console.log(matches);
});
</script>
</body></html>