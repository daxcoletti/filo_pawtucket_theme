<?php
/** ---------------------------------------------------------------------
 * themes/filo/views/About/Index.php
 * Página "Acerca de" — Archivo FFyL UBA
 * ---------------------------------------------------------------------- */
?>
<div class="staticPageArea">
	<h1><?php print _t('Acerca de'); ?></h1>

	<h2><?php print _t('Presentación'); ?></h2>

	<p>El Archivo de la Facultad de Filosofía y Letras de la Universidad de Buenos Aires conserva la documentación producida y acumulada por la institución a lo largo de su existencia y es por lo tanto reflejo de la organización que ha tenido desde su creación. Su finalidad es reunir, conservar, organizar, custodiar y difundir los documentos que forman el Archivo Documental de esta casa de estudios. Este está constituido por el Fondo de la Facultad de Filosofía y Letras, por los Fondos Personales y Colecciones que la facultad custodia y que fueron donados por personalidades destacadas para promover la investigación en los diferentes campos disciplinares.</p>

	<p>Esta es una nueva etapa de este servicio a la comunidad que se irá desarrollando a través de la incorporación de nuevas descripciones archivísticas para que los fondos y colecciones de la Facultad de Filosofía y Letras se encuentren en acceso público.</p>

	<hr style="margin: 30px 0; border-color: #e8edf5;">

	<h2><?php print _t('Sistema de institutos'); ?></h2>

	<p>Este CollectiveAccess se nutre de los fondos y colecciones de los institutos de investigación de la Facultad.</p>

	<hr style="margin: 30px 0; border-color: #e8edf5;">

	<h2><?php print _t('Autoridades'); ?></h2>

	<p>
		<strong><?php print _t('Decanato'); ?></strong><br>
		<?php print _t('Decano'); ?><br>
		Lic. Ricardo Manetti<br>
		<?php print _t('Vicedecana'); ?><br>
		Dra. Graciela Morgade<br>
		<br>
		<strong><?php print _t('Subsecretaría de Bibliotecas'); ?></strong><br>
		<?php print _t('Subsecretaria'); ?><br>
		Mg. María Rosa Mostaccio
	</p>

	<hr style="margin: 30px 0; border-color: #e8edf5;">

	<h2><?php print _t('Equipo de Trabajo'); ?> (2024–2026)</h2>

	<p>
		Noelia Delpiano<br>
		Maricel Martinez<br>
		<br>
		<strong><?php print _t('Responsable de desarrollo informático'); ?></strong><br>
		Daniel Coletti<br>
		<br>
		<strong><?php print _t('Colaborador'); ?></strong><br>
		Nahuel Victorero
	</p>

	<hr style="margin: 30px 0; border-color: #e8edf5;">

	<p>
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
		// El atributo data-* divide la dirección en tres partes.
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
</div>

<script>
(function() {
	var el = document.querySelector('.filo-email');
	if (!el) return;
	var addr = el.dataset.u + '@' + el.dataset.d + '.' + el.dataset.t;
	// Al hacer clic: abre el cliente de correo
	el.addEventListener('click', function() {
		window.location.href = 'mailto:' + addr;
	});
	// Al pasar el mouse: muestra la dirección real en el tooltip
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
