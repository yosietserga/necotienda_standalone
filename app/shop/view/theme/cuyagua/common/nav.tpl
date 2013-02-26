<div class="container_16">
    <div class="bgNav">
        <nav id="nav">
            <div class="grid_16">
                <ul>
                    <li><a href="<?php echo str_replace('&', '&amp;', $home); ?>" title="Inicio">Inicio</a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $about_us); ?>" title="Nosotros">Nosotros</a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $special); ?>" title="Ofertas">Ofertas</a></li>
                    <?php if (!$logged) { ?>
                    <li><a href="<?php echo str_replace('&', '&amp;', $account); ?>" title="Accede a tu cuenta y disfruta de más opciones">Acceder</a></li>
                    <?php } else { ?>
                    <li><a href="<?php echo str_replace('&', '&amp;', $account); ?>" title="<?php echo $text_account; ?>">Mi Cuenta</a></li>
                    <?php } ?>
                    <li><a href="<?php echo str_replace('&', '&amp;', $contact); ?>" title="Contacto">Contacto</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>