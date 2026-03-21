<?php
/* ----------------------------------------------------------------------
 * themes/filo/views/Details/ca_collections_default_html.php
 * Vista de detalle de colecciones — Museo Etnográfico Juan B. Ambrosetti
 * ----------------------------------------------------------------------
 */
	$t_item = $this->getVar("item");
	$vn_id  = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
	$type_code = $t_item->get('ca_collections.type_id', ['convertCodesToIdno' => true]);
?>
<div class="row">
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div>
	</div>

	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>

					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id%convertCodesToDisplayText=1}}}</H6>
					<HR>

<?php
					// Jerarquía
					if ($t_item->get('ca_collections.hierarchy.preferred_labels')) {
						$va_coll_array = [];
						if ($vs_parent = $t_item->get('ca_collections.hierarchy.preferred_labels', ['returnWithStructure' => true])) {
							echo "<div class='unit'><H6>"._t("Ubicación en la colección")."</H6>";
							foreach ($vs_parent as $va_coll_level) {
								foreach ($va_coll_level as $va_coll_id => $va_collection) {
									foreach ($va_collection as $va_collection_name) {
										$va_coll_array[] = caNavLink($this->request, $va_collection_name['name'], '', '', 'Detail', 'collections/'.$va_coll_id);
									}
								}
							}
							echo join(' &rsaquo; ', $va_coll_array)."</div>";
						}
					}

					// Descripción
					if ($vs_desc = $t_item->get('ca_collections.description')) {
						echo "<div class='unit'><H6>"._t("Descripción")."</H6><span class='trimText'>".$vs_desc."</span></div>";
					}

					// Colectores relacionados
					if ($vs_creator = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit>')) {
						echo "<div class='unit'><H6>"._t("Colector/es")."</H6>".$vs_creator."</div>";
					}

					// Sub-colecciones directas
					$va_children = $t_item->get('ca_collections.children.collection_id', ['returnAsArray' => true]);
					if ($va_children) {
						echo "<div class='unit'><H6>"._t("Contiene")."</H6>";
						if ($qr_children = caMakeSearchResult('ca_collections', $va_children, ['sort' => ['ca_collections.preferred_labels.name_sort']])) {
							echo "<ul>";
							while ($qr_children->nextHit()) {
								$child_id   = $qr_children->get('ca_collections.collection_id');
								$child_name = $qr_children->get('ca_collections.preferred_labels.name');
								$child_type = $qr_children->get('ca_collections.type_id', ['convertCodesToDisplayText' => true]);
								echo "<li>".caNavLink($this->request, $child_name, '', '', 'Detail', 'collections/'.$child_id)." <small>({$child_type})</small></li>";
							}
							echo "</ul>";
						}
						echo "</div>";
					}
?>
				</div>
			</div><!-- end row -->

			{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class='col-sm-12'><HR><H5><?php print _t("Objetos en esta colección"); ?></H5></div>
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Cargando...')); ?>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load(
						"<?php print caNavUrl($this->request, '', 'Search', 'objects', ['search' => 'ca_collections.collection_id:^ca_collections.collection_id'], ['dontURLEncodeParameters' => true]); ?>",
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
