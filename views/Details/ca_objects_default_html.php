<?php
/* ----------------------------------------------------------------------
 * themes/filo/views/Details/ca_objects_default_html.php
 * Vista de detalle de objetos — Museo Etnográfico Juan B. Ambrosetti
 * ----------------------------------------------------------------------
 */
	$t_object        = $this->getVar("item");
	$t_representation = $this->getVar("t_representation");
	$va_access_values = caGetUserAccessValues($this->request);

	$o_icons_conf = caGetIconsConfig();
	if(!($vs_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	if(!$t_object->getRepresentationCount(['checkAccess' => $va_access_values])) {
		$show_placeholder = true;
	}
?>
<div class="row">
	<div class='col-xs-12 navTop'>
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div>
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div>
	</div>

	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">

			{{!-- Columna izquierda: imagen --}}
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
<?php if(isset($show_placeholder)) { print $vs_placeholder; } ?>
				{{{representationViewer}}}

<?php
$vs_obj_id = $t_object->getPrimaryKey();
$vs_rep_id = $t_representation ? $t_representation->getPrimaryKey() : '';
if ($vs_rep_id) {
	print '<div class="imageTools"><span><a href="#" onclick="caMediaPanel.showPanel(\'/index.php/Detail/GetMediaOverlay/context/objects/id/'.$vs_obj_id.'/representation_id/'.$vs_rep_id.'/overlay/1\'); return false;" title="Ampliar"><span class="glyphicon glyphicon-zoom-in"></span> '._t('Ver imagen completa').'</a></span></div>';
}
?>
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
			</div>

			{{!-- Columna derecha: metadatos --}}
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id%convertCodesToDisplayText=1</unit>}}}</H6>
				<HR>

<?php
				// Identificador
				if ($v = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><H6>"._t("Identificador")."</H6>".$v."</div>";
				}
				// Número original
				if ($v = $t_object->get('ca_objects.numero_original')) {
					print "<div class='unit'><H6>"._t("Número original")."</H6>".$v."</div>";
				}
				// Descripción
				if ($v = $t_object->get('ca_objects.descripcion')) {
					print "<div class='unit'><H6>"._t("Descripción")."</H6><span class='trimText'>".$v."</span></div>";
				}
?>

				{{!-- Tipo de objeto --}}
				{{{<ifdef code="ca_objects.tipo_objeto_vocab">
					<div class='unit'><H6><?php print _t("Tipo de objeto"); ?></H6>
						<unit delimiter=", ">^ca_objects.tipo_objeto_vocab%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Material --}}
				{{{<ifdef code="ca_objects.material">
					<div class='unit'><H6><?php print _t("Material"); ?></H6>
						<unit delimiter=", ">^ca_objects.material%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Técnica de manufactura --}}
				{{{<ifdef code="ca_objects.manufactura">
					<div class='unit'><H6><?php print _t("Técnica de manufactura"); ?></H6>
						<unit delimiter=", ">^ca_objects.manufactura%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Decoración --}}
				{{{<ifdef code="ca_objects.decoracion">
					<div class='unit'><H6><?php print _t("Decoración"); ?></H6>
						<unit delimiter=", ">^ca_objects.decoracion%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Estilo --}}
				{{{<ifdef code="ca_objects.estilo">
					<div class='unit'><H6><?php print _t("Estilo"); ?></H6>
						<unit delimiter=", ">^ca_objects.estilo%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Época --}}
				{{{<ifdef code="ca_objects.epoca">
					<div class='unit'><H6><?php print _t("Época"); ?></H6>
						<unit delimiter=", ">^ca_objects.epoca%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Grupo étnico --}}
				{{{<ifdef code="ca_objects.grupo">
					<div class='unit'><H6><?php print _t("Grupo étnico"); ?></H6>
						<unit delimiter=", ">^ca_objects.grupo%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Comunidad --}}
				{{{<ifdef code="ca_objects.comunidad">
					<div class='unit'><H6><?php print _t("Comunidad"); ?></H6>
						<unit delimiter=", ">^ca_objects.comunidad%convertCodesToDisplayText=1</unit>
					</div>
				</ifdef>}}}

				{{!-- Dimensiones --}}
				{{{<ifdef code="ca_objects.dimensiones.alto|ca_objects.dimensiones.ancho|ca_objects.dimensiones.profundidad|ca_objects.dimensiones.diametro|ca_objects.dimensiones.peso">
					<div class='unit'><H6><?php print _t("Dimensiones"); ?></H6>
					<ifdef code="ca_objects.dimensiones.alto">Alto: ^ca_objects.dimensiones.alto cm</ifdef>
					<ifdef code="ca_objects.dimensiones.alto,ca_objects.dimensiones.ancho"> | </ifdef>
					<ifdef code="ca_objects.dimensiones.ancho">Ancho: ^ca_objects.dimensiones.ancho cm</ifdef>
					<ifdef code="ca_objects.dimensiones.ancho,ca_objects.dimensiones.profundidad"> | </ifdef>
					<ifdef code="ca_objects.dimensiones.profundidad">Prof.: ^ca_objects.dimensiones.profundidad cm</ifdef>
					<ifdef code="ca_objects.dimensiones.diametro"><br/>Diámetro: ^ca_objects.dimensiones.diametro cm</ifdef>
					<ifdef code="ca_objects.dimensiones.peso"><br/>Peso: ^ca_objects.dimensiones.peso g</ifdef>
					</div>
				</ifdef>}}}

				<HR>

<?php
				// Colección / jerarquía
				if ($va_colecciones = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => ' &rsaquo; ', 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><H6>"._t("Colección")."</H6>".$va_colecciones."</div>";
				}

				// Procedencia geográfica
				if ($va_lugares = $t_object->get('ca_places.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><H6>"._t("Procedencia geográfica")."</H6>".$va_lugares."</div>";
				}

				// Colector/es
				if ($va_colectores = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><H6>"._t("Colector")."</H6>".$va_colectores."</div>";
				}
?>

			</div><!-- end col metadatos -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col center -->

	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div>
	</div>
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
			speed: 75,
			maxHeight: 120
		});
	});
</script>
