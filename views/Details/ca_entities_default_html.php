<?php
/* ----------------------------------------------------------------------
 * themes/filo/views/Details/ca_entities_default_html.php
 * Vista de detalle de colectores — Museo Etnográfico Juan B. Ambrosetti
 * ----------------------------------------------------------------------
 */
	$t_item = $this->getVar("item");
	$va_access_values = caGetUserAccessValues($this->request);
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
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H6><?php print _t("Colector"); ?></H6>
					<HR>

<?php
					if ($v = $t_item->get('ca_entities.biography')) {
						echo "<div class='unit'><H6>"._t("Biografía")."</H6><span class='trimText'>".$v."</span></div>";
					}

					// Colecciones relacionadas
					if ($va_coll = $t_item->get('ca_collections.preferred_labels', ['returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values])) {
						echo "<div class='unit'><H6>"._t("Colecciones")."</H6>".$va_coll."</div>";
					}
?>
				</div>
			</div>

			{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class='col-sm-12'><HR><H5><?php print _t("Objetos colectados"); ?></H5></div>
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Cargando...')); ?>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load(
						"<?php print caNavUrl($this->request, '', 'Search', 'objects', ['search' => 'ca_entities.entity_id:^ca_entities.entity_id'], ['dontURLEncodeParameters' => true]); ?>",
						function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Cargando...')); ?>',
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						}
					);
				});
			</script>
			</ifcount>}}}

		</div><!-- end container -->
	</div><!-- end col -->

	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div>
	</div>
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({ speed: 75, maxHeight: 120 });
	});
</script>
