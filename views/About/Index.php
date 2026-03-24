<?php
/** ---------------------------------------------------------------------
 * themes/filo/views/About/Index.php
 * Página "Acerca de" — Archivo FFyL UBA
 * ---------------------------------------------------------------------- */
?>
<div class="staticPageArea">
	<h1><?php print _t('Acerca de'); ?></h1>

	<div class="row justify-content-between page-layout" style="margin-top: 1.5rem;">

		<!-- Columna izquierda: texto institucional -->
		<div class="col-sm-6 about-main-text">

			<h4><?php print _t('Presentación'); ?></h4>

			<p>El Archivo de la Facultad de Filosofía y Letras de la Universidad de Buenos Aires conserva la documentación producida y acumulada por la institución a lo largo de su existencia y es por lo tanto reflejo de la organización que ha tenido desde su creación. Su finalidad es reunir, conservar, organizar, custodiar y difundir los documentos que forman el Archivo Documental de esta casa de estudios. Este está constituido por el Fondo de la Facultad de Filosofía y Letras, por los Fondos Personales y Colecciones que la facultad custodia y que fueron donados por personalidades destacadas para promover la investigación en los diferentes campos disciplinares.</p>

			<p>Esta es una nueva etapa de este servicio a la comunidad que se irá desarrollando a través de la incorporación de nuevas descripciones archivísticas para que los fondos y colecciones de la Facultad de Filosofía y Letras se encuentren en acceso público.</p>

			<h4><?php print _t('Sistema de institutos'); ?></h4>

			<p>Este CollectiveAccess se nutre de los fondos y colecciones de los institutos de investigación de la Facultad.</p>

			<p style="margin-top: 2rem;">
				<strong>Archivo de la Facultad de Filosofía y Letras</strong><br>
				Universidad de Buenos Aires<br>
				Puán 480<br>
				Caballito, Ciudad Autónoma de Buenos Aires, Argentina
			</p>

			<p>
				<strong><?php print _t('Contacto'); ?></strong><br>
				<?php
				// Email obfuscado: los bots leen el HTML estático,
				// los humanos ven el texto ensamblado por JavaScript.
				?>
				Email — <span
					class="filo-email"
					data-u="archivos"
					data-d="filo.uba"
					data-t="ar"
					style="cursor:pointer; color:#2db5a3; text-decoration:underline;"
					title="<?php print _t('Hacé clic para copiar el email'); ?>">
					archivos [en] filo.uba.ar
				</span>
			</p>

		</div><!-- /col izquierda -->

		<!-- Columna derecha: autoridades y equipo -->
		<div class="col-sm-5 col-sm-offset-1">
			<div class="metadata">

				<dl>
					<h4>Facultad de Filosofía y Letras — UBA</h4>

					<dt><?php print _t('Decano'); ?></dt>
					<dd>Lic. Ricardo Manetti</dd>

					<dt><?php print _t('Vicedecana'); ?></dt>
					<dd>Dra. Graciela Morgade</dd>

					<dt><?php print _t('Subsecretaría de Bibliotecas'); ?></dt>
					<dd>Mg. María Rosa Mostaccio</dd>

					<dt><?php print _t('Equipo de Trabajo'); ?> (2024–2026)</dt>
					<dd>
						Noelia Delpiano<br>
						Maricel Martinez<br>
						<?php print _t('Responsable de desarrollo informático'); ?>: Daniel Coletti<br>
						<?php print _t('Colaborador'); ?>: Nahuel Victorero
					</dd>
				</dl>

			</div>
		</div><!-- /col derecha -->

	</div><!-- /row -->
</div>

<script>
(function() {
	var el = document.querySelector('.filo-email');
	if (!el) return;
	var addr = el.dataset.u + '@' + el.dataset.d + '.' + el.dataset.t;
	el.addEventListener('click', function() {
		window.location.href = 'mailto:' + addr;
	});
	el.addEventListener('mouseenter', function() {
		el.setAttribute('title', addr);
		el.textContent = addr;
	});
	el.addEventListener('mouseleave', function() {
		el.textContent = 'archivos [en] filo.uba.ar';
		el.setAttribute('title', '<?php print _t("Hacé clic para copiar el email"); ?>');
	});
})();
</script>
