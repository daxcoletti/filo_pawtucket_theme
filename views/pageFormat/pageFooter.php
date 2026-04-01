<?php
/* ----------------------------------------------------------------------
 * Repositorio Digital — Facultad de Filosofía y Letras, UBA
 * https://filo.uba.ar
 * ---------------------------------------------------------------------- */
?>
		<div style="clear:both; height:1px;"><!-- empty --></div>

<?php
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->

	<!-- ============================================================
	     FOOTER ESTILO FILO UBA
	     ============================================================ -->
	<footer id="footer">
		<div class="container">
			<div class="footerInner">
				<div class="row" style="padding-bottom:20px;">

					<!-- Logo y descripción -->
					<div class="col-sm-4" style="margin-bottom:20px;">
						<div style="margin-bottom:15px;">
							<?php print caNavLink($this->request, '<img src="/themes/filo/assets/pawtucket/graphics/filo_logo_footer.svg" style="height:55px; width:auto;" alt="FFyL UBA" />', "", "", "", ""); ?>
						</div>
						<p style="color:#8899bb; font-size:13px; line-height:1.7em;">
							<strong style="color:#fff;">Archivo de la Facultad de Filosofía y Letras</strong><br>
							Universidad de Buenos Aires<br>
							Puán 480<br>
							Caballito, Ciudad Autónoma de Buenos Aires, Argentina
						</p>
						<div class="social" style="margin-top:15px;">
							<a href="https://www.facebook.com/filosofiayletrasuba" target="_blank" style="color:#c8e6e4; font-size:20px; margin-right:12px;"><i class="fa fa-facebook-square"></i></a>
							<a href="https://x.com/filo_uba" target="_blank" style="color:#c8e6e4; font-size:20px; margin-right:12px;"><i class="fa fa-twitter"></i></a>
							<a href="https://www.instagram.com/filo.uba" target="_blank" style="color:#c8e6e4; font-size:20px; margin-right:12px;"><i class="fa fa-instagram"></i></a>
							<a href="https://www.youtube.com/@FFyL" target="_blank" style="color:#c8e6e4; font-size:20px; margin-right:12px;"><i class="fa fa-youtube-play"></i></a>
						</div>
					</div>

					<!-- Colección / Sitio -->
					<div class="col-sm-4" style="margin-bottom:20px;">
						<h6 style="color:#2db5a3; text-transform:uppercase; font-size:11px; letter-spacing:2px; border-bottom:1px solid #252d4a; padding-bottom:8px; margin-bottom:12px;"><?php print _t('Colección'); ?></h6>
						<ul style="list-style:none; padding:0; margin:0;">
							<li style="margin-bottom:6px;">
								<a href="<?php print caNavUrl($this->request, 'FindingAid', 'Collection', 'Index'); ?>" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-angle-right" style="margin-right:6px; color:#2db5a3;"></i><?php print _t('Fondos y Colecciones'); ?>
								</a>
							</li>
							<li style="margin-bottom:6px;">
								<a href="<?php print caNavUrl($this->request, '', 'Browse', 'Index'); ?>" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-angle-right" style="margin-right:6px; color:#2db5a3;"></i><?php print _t('Explorar'); ?>
								</a>
							</li>
							<li style="margin-bottom:6px;">
								<a href="<?php print caNavUrl($this->request, '', 'Search', 'advanced/objects'); ?>" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-angle-right" style="margin-right:6px; color:#2db5a3;"></i><?php print _t('Búsqueda Avanzada'); ?>
								</a>
							</li>
							<li style="margin-bottom:6px;">
								<a href="<?php print caNavUrl($this->request, '', 'Gallery', 'Index'); ?>" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-angle-right" style="margin-right:6px; color:#2db5a3;"></i><?php print _t('Galerías'); ?>
								</a>
							</li>
						</ul>
					</div>

					<!-- Información de contacto -->
					<div class="col-sm-4" style="margin-bottom:20px;">
						<h6 style="color:#2db5a3; text-transform:uppercase; font-size:11px; letter-spacing:2px; border-bottom:1px solid #252d4a; padding-bottom:8px; margin-bottom:12px;"><?php print _t('Contacto'); ?></h6>
						<ul style="list-style:none; padding:0; margin:0;">
							<li style="margin-bottom:8px; color:#8899bb; font-size:13px;">
								<i class="fa fa-map-marker" style="margin-right:8px; color:#2db5a3;"></i><?php print _t('Puán 480, Ciudad Autónoma de Buenos Aires'); ?>
							</li>
							<li style="margin-bottom:8px;">
								<a href="<?php print caNavUrl($this->request, '', 'Contact', 'form'); ?>" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-envelope" style="margin-right:8px; color:#2db5a3;"></i><?php print _t('Formulario de Contacto'); ?>
								</a>
							</li>
							<li style="margin-bottom:8px;">
								<a href="https://filo.uba.ar" target="_blank" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-external-link" style="margin-right:8px; color:#2db5a3;"></i>filo.uba.ar
								</a>
							</li>
							<li style="margin-bottom:8px;">
								<a href="<?php print caNavUrl($this->request, '', 'About', 'Index'); ?>" style="color:#c8e6e4; font-size:13px; text-decoration:none;">
									<i class="fa fa-info-circle" style="margin-right:8px; color:#2db5a3;"></i><?php print _t('Acerca de'); ?>
								</a>
							</li>
						</ul>
					</div>

				</div><!-- end row -->

				<!-- Línea inferior de copyright -->
				<div style="border-top:1px solid #252d4a; padding-top:15px; padding-bottom:10px; text-align:center; color:#8899bb; font-size:12px;">
					&copy; <?php print date('Y'); ?> <?php print _t('Facultad de Filosofía y Letras'); ?> &mdash; <?php print _t('Universidad de Buenos Aires'); ?>.
					<?php print _t('Todos los derechos reservados.'); ?>
					&nbsp;|&nbsp;
					<a href="https://filo.uba.ar" target="_blank" style="color:#8899bb;">filo.uba.ar</a>
				</div>

			</div><!-- end footerInner -->
		</div><!-- end container -->
	</footer>

	<?php print TooltipManager::getLoadHTML(); ?>
	<div id="caMediaPanel">
		<div id="caMediaPanelContentArea">
		</div>
	</div>
	<script type="text/javascript">
		var caMediaPanel;
		jQuery(document).ready(function() {
			if (caUI.initPanel) {
				caMediaPanel = caUI.initPanel({
					panelID: 'caMediaPanel',
					panelContentID: 'caMediaPanelContentArea',
					exposeBackgroundColor: '#FFFFFF',
					exposeBackgroundOpacity: 0.7,
					panelTransitionSpeed: 400,
					allowMobileSafariZooming: true,
					mobileSafariViewportTagID: '_msafari_viewport',
					closeButtonSelector: '.close'
				});
			}
		});
	</script>
	</body>
</html>
