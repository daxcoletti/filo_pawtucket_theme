<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	
	$qr_top_level_collections = ca_collections::find(
		array('parent_id' => null),
		array(
			'returnAs' => 'searchResult',
			'sort' => 'ca_collection_labels.name',
			'sort_direction' => 'asc'
		)
	);
	
	if (!$va_open_by_default) {
		$vs_hierarchy_style = "style='display:none;'";
	}
?>
	<h1><?php print $vs_page_title; ?></h1>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		// Collect all top-level collections into array and sort by orden_presentacion
		$va_collections = array();
		while($qr_top_level_collections->nextHit()) {
			$vn_id = $qr_top_level_collections->get('ca_collections.collection_id');
			$vn_order = (int)$qr_top_level_collections->get('ca_collections.orden_presentacion');
			// Si no tiene orden asignado, lo mandamos al final (999)
			if (!$vn_order) { $vn_order = 999; }
			$va_collections[sprintf('%04d', $vn_order).'_'.$vn_id] = $vn_id;
		}
		ksort($va_collections);
		
		foreach($va_collections as $vs_key => $vn_top_level_collection_id) {
			$va_hierarchy = $t_collection->hierarchyWithTemplate($ps_template, array('collection_id' => $vn_top_level_collection_id));
			
			// Get name for checking children
			$t_col = new ca_collections($vn_top_level_collection_id);
			$va_children = $t_col->getHierarchyChildren($vn_top_level_collection_id, array('idsOnly' => true));
			
			foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {
				print "<div class='collHeader' style='margin-left: ".($va_hierarchy_item['level'] * 35)."px'>";
				if (($va_hierarchy_item['level']) == 0 && sizeof($va_children)) {
					print "<a href='#'><i class='fa fa-angle-double-down finding-aid down{$vn_top_level_collection_id}'></i></a>";
				} elseif ($va_hierarchy_item['level'] == 0) {
					print "<i class='fa fa-square-o finding-aid' {$va_opacity}></i>";
				} else {
					$va_opacity = "style='opacity: .".(90 - ($va_hierarchy_item['level'] * 20))."' ";
					print "<i class='fa fa-angle-right finding-aid' {$va_opacity}></i>";
				}
				print "{$va_hierarchy_item['display']}</div>\n";
				if ($va_hierarchy_item['level'] == 0) {
					print "<div class='collBlock".$vn_top_level_collection_id."' ".$vs_hierarchy_style.">";
?>				
					<script>
						$(function() {
						  $('.down<?php print $vn_top_level_collection_id;?>').click(function() {
							  if ($('.collBlock<?php print $vn_top_level_collection_id;?>').css('display') == 'none') {
							  	 $('.down<?php print $vn_top_level_collection_id;?>').css('-webkit-transform', 'rotate(0deg)');
							     $('.collBlock<?php print $vn_top_level_collection_id;?>').fadeIn("300"); 
							  } else {
							  	$('.down<?php print $vn_top_level_collection_id;?>').css('-webkit-transform', 'rotate(180deg)');
							    $('.collBlock<?php print $vn_top_level_collection_id;?>').fadeOut("300");
							  }
							  return false;
						  });
						})
					</script>
<?php	
				}	
				$v_i++;			
			}
			print "</div>";
		}
	} else {
		print _t('No collections available');
	}
?>
	</div>
