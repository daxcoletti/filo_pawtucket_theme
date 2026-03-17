<?php
    $t_project_name = $this->request->config->get('app_display_name');
?>
<footer class="footer-institucional">
    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-col">
                <div class="footer-logo">
                    <img src="<?php echo $this->request->getThemeUrlPath(); ?>/assets/pawtucket/graphics/logo-footer.png" alt="Facultad de Filosofía y Letras" class="img-fluid">
                </div>
            </div>
            
            <div class="col-md-4 footer-col">
                <h4>Enlaces Rápidos</h4>
                <ul class="list-unstyled">
                    <li><a href="<?php echo caNavUrl($this->request, '', 'Splash', 'Show'); ?>"><?php echo _("Inicio"); ?></a></li>
                    <li><a href="<?php echo caNavUrl($this->request, 'items', 'Browse', 'Index'); ?>"><?php echo _("Catálogo"); ?></a></li>
                    <li><a href="<?php echo caNavUrl($this->request, '', 'Contact', 'form'); ?>"><?php echo _("Contacto"); ?></a></li>
                </ul>
            </div>
            
            <div class="col-md-4 footer-col">
                <h4>Contacto</h4>
                <p>
                    Puán 480, C.A.B.A.<br>
                    Teléfono: +54 11 5287-2600<br>
                    Email: <a href="mailto:info@filo.uba.ar">info@filo.uba.ar</a>
                </p>
            </div>
        </div>
        
        <div class="row footer-bottom-line">
            <div class="col-12">
                <hr>
                <p class="text-center">
                    &copy; <?php echo date("Y"); ?> <?php echo $t_project_name; ?> - Facultad de Filosofía y Letras (UBA)
                </p>
            </div>
        </div>
    </div>
</footer>
