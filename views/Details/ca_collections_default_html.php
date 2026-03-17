<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class="col-sm-1"></div>
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">				
<?php
					#$vs_finding_aid = array();
					$va_anchors = array();
					$vs_finding_aid= "<div class='row'><div class='col-sm-12'>";
					if ($t_item->get('ca_collections.repository.repositoryName')) {
						if ($vs_repository = $t_item->get('ca_collections.repository', array('template' => '<ifdef code="ca_collections.repository.repositoryName"><b>Repository Name: </b></ifdef> ^ca_collections.repository.repositoryName <ifdef code="ca_collections.repository.repositoryLocation"><br/><b>Repository Location: </b></ifdef> ^ca_collections.repository.repositoryLocation', 'delimiter' => '<br/>'))) {
							$va_anchors[] = "<a href='#repository'>"._t("Repositorio")."</a>";
							$vs_finding_aid.= "<div class='unit'><h3><a name='repository'>"._t("Repositorio")."</a></h3>".$vs_repository."</div>";
						}
					}
					if ($vs_desc = $t_item->get('ca_collections.description.description_text', array('delimiter' => '<br/>'))) {
						$vs_finding_aid.= "<div class='unit'><h3>"._t("Descripción")."</h3>".$vs_desc."</div>"; 
					}	
					if ($t_item->get('ca_collections.unitdate.date_value')) {
						if ($vs_date = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_collections.unitdate.date_value (^ca_collections.unitdate.dates_types)</unit>')) {
							$va_anchors[] = "<a href='#date'>"._t("Fecha")."</a>";
							$vs_finding_aid.= "<div class='unit'><h3><a name='date'>"._t("Fecha")."</a></h3>".$vs_date."</div>";
						}
					}
					if ($vs_folder = $t_item->get('ca_collections.folder_number', array('delimiter' => '<br/>'))) {
						$vs_finding_aid.= "<div class='unit'><h3>"._t("Número de carpeta")."</h3>".$vs_folder."</div>";
					}					
					if ($t_item->get('ca_collections.hierarchy.preferred_labels')) {
						$va_coll_array = array();
						if ($vs_parent = $t_item->get('ca_collections.hierarchy.preferred_labels', array('returnWithStructure' => true))) {
							$va_anchors[] = "<a href='#parent'>".$t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))." "._t("Ubicación")."</a>";
							$vs_finding_aid.= "<div class='unit'><h3><a name='parent'>".$t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))." "._t("Ubicación")."</a></h3>";
								foreach ($vs_parent as $va_key => $va_coll_level) {
									foreach($va_coll_level as $va_coll_id => $va_collection) {
										foreach ($va_collection as $va_key2 => $va_collection_name) {
											$va_coll_array[] = caNavLink($this->request, $va_collection_name['name'], '', '', 'Detail', 'collections/'.$va_coll_id);
										}
									}
								}
								$vs_finding_aid.= join(' > ', $va_coll_array);
							$vs_finding_aid.=  "</div>";
						}
					}
					if ($vs_description = $t_item->get('ca_collections.description')) {
						$va_anchors[] = "<a href='#description'>"._t("Descripción")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='description'>"._t("Descripción")."</a></h3>".$vs_description."</div>";
					}					
					if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
						$va_anchors[] = "<a href='#extent'>"._t("Extensión")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='extent'>"._t('Extensión')."</a></h3>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						$va_anchors[] = "<a href='#creator'>"._t("Entidades relacionadas")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='creator'>"._t("Entidades relacionadas")."</a></h3>".$vs_creator."</div>";
					}
					if ($vs_agency = $t_item->get('ca_collections.agencyHistory')) {
						$va_anchors[] = "<a href='#history'>"._t("Historia de la entidad")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a href='agency'>"._t("Historia de la entidad")."</a></h3>".$vs_agency."</div>";
					}
					if ($vs_adminbiohist = $t_item->get('ca_collections.adminbiohist')) {
						$va_anchors[] = "<a href='#adminbiohist'>"._t("Historia administrativa/biográfica")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a href='adminbiohist'>"._t("Historia administrativa/biográfica")."</a></h3>{$vs_adminbiohist}</div>";
					}
					if ($vs_abstract = $t_item->get('ca_collections.abstract')) {
						$va_anchors[] = "<a href='#abstract'>"._t("Resumen")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='abstract'>"._t("Resumen")."</a></h3>".$vs_abstract."</div>";
					}
					$vs_finding_aid.= "</div>";

					$vs_finding_aid.= "</div><!-- end row -->";
					$vs_finding_aid.= "<div class='row'><div class='col-sm-12'>";
					if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
						$va_anchors[] = "<a href='#citation'>"._t("Cita preferida")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='citation'>"._t("Cita preferida")."</a></h3>".$vs_citation."</div>";
					}
					if ($vs_custodhist = $t_item->get('ca_collections.custodhist')) {
						$va_anchors[] = "<a href='#custodhist'>"._t("Historia custodial")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='custodhist'>"._t("Historia custodial")."</a></h3>".$vs_custodhist."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						$va_anchors[] = "<a href='#acqinfo'>"._t("Fuente inmediata de adquisición")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='acqinfo'>"._t("Fuente inmediata de adquisición")."</a></h3>".$vs_acqinfo."</div>";
					}
					if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
						$va_anchors[] = "<a href='#accruals'>"._t("Incorporaciones")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='accruals'>"._t("Incorporaciones")."</a></h3>".$vs_accruals."</div>";
					}	
					if ($vs_provenance = $t_item->get('ca_collections.provenance')) {
						$va_anchors[] = "<a href='#provenance'>"._t("Procedencia")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='provenance'>"._t("Procedencia")."</a></h3>".$vs_provenance."</div>";
					}						
					if ($va_acc_method = $t_item->get('ca_collections.acquisition_method', array('convertCodesToDisplayText' => true))){
						$va_anchors[] = "<a href='#acquisition'>"._t("Método de adquisición")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='acquisition'>"._t("Método de adquisición")."</a></h3>".$va_acc_method."</div>";
					}
					if ($vs_scopecontent = $t_item->get('ca_collections.scopecontent')) {
						$va_anchors[] = "<a href='#scope'>"._t("Alcance y contenido")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='scope'>"._t("Alcance y contenido")."</a></h3>".$vs_scopecontent."</div>";
					}	
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
						$va_anchors[] = "<a href='#arrangement'>"._t("Sistema de organización")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='arrangement'>"._t("Sistema de organización")."</a></h3>".$vs_arrangement."</div>";
					}
					if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict')) {
						$va_anchors[] = "<a href='#accessrestrict'>"._t("Condiciones de acceso")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='accessrestrict'>"._t("Condiciones de acceso")."</a></h3>".$vs_accessrestrict."</div>";
					}
					if ($vs_physaccessrestrict = $t_item->get('ca_collections.physaccessrestrict')) {
						$va_anchors[] = "<a href='#physaccessrestrict'>"._t("Acceso físico")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='physaccessrestrict'>"._t("Acceso físico")."</a></h3>".$vs_physaccessrestrict."</div>";
					}
					if ($vs_techaccessrestrict = $t_item->get('ca_collections.techaccessrestrict')) {
						$va_anchors[] = "<a href='#techaccessrestrict'>"._t("Acceso técnico")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='techaccessrestrict'>"._t("Acceso técnico")."</a></h3>".$vs_techaccessrestrict."</div>";
					}
					if ($vs_reproduction_conditions = $t_item->get('ca_collections.reproduction_conditions')) {
						$va_anchors[] = "<a href='#reprocon'>"._t("Condiciones de reproducción")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='reprocon'>"._t("Condiciones de reproducción")."</a></h3>".$vs_reproduction_conditions."</div>";
					}
					if ($vs_langmaterial = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_collections.langmaterial.material ^ca_collections.langmaterial.language1</unit>')) {
						$va_anchors[] = "<a href='#langmaterial'>"._t("Idiomas y escrituras del material")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='langmaterial'>"._t("Idiomas y escrituras del material")."</a></h3>".$vs_langmaterial."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
						$va_anchors[] = "<a href='#otherfindingaid'>"._t("Otros instrumentos de descripción")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='otherfindingaid'>"._t("Otros instrumentos de descripción")."</a></h3>".$vs_otherfindingaid."</div>";
					}
					if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
						$va_anchors[] = "<a href='#originalsloc'>"._t("Existencia y localización de originales")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='originalsloc'>"._t("Existencia y localización de originales")."</a></h3>".$vs_originalsloc."</div>";
					}	
					if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
						$va_anchors[] = "<a href='#altformavail'>"._t("Existencia y localización de copias")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='altformavail'>"._t("Existencia y localización de copias")."</a></h3>".$vs_altformavail."</div>";
					}
					if ($vs_relatedmaterial = $t_item->get('ca_collections.relatedmaterial', array('delimiter' => '<br/>'))) {
						$va_anchors[] = "<a href='#relatedmaterial'>"._t("Materiales archivísticos relacionados")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='relatedmaterial'>"._t("Materiales archivísticos relacionados")."</a></h3>".$vs_relatedmaterial."</div>";
					}
					if ($vs_bibliography = $t_item->get('ca_collections.bibliography')) {
						$va_anchors[] = "<a href='#bibliography'>"._t("Nota de publicación")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='bibliography'>"._t("Nota de publicación")."</a></h3>".$vs_bibliography."</div>";
					}
					if ($vs_processing = $t_item->getWithTemplate('<ifdef code="ca_collections.processInfo.createdBy">._t("Inventario creado por").": ^ca_collections.processInfo.createdBy<br/></ifdef><ifdef code="ca_collections.processInfo.dateCreated">._t("Fecha de creación").": ^ca_collections.processInfo.dateCreated<br/></ifdef><ifdef code="ca_collections.processInfo.information">._t("Información").": ^ca_collections.processInfo.information</ifdef>')) {
						$va_anchors[] = "<a href='#processing'>"._t("Información de procesamiento")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='processing'>"._t("Información de procesamiento")."</a></h3>".$vs_processing."</div>";
					}
					if ($va_related_storage = $t_item->get('ca_storage_locations.preferred_labels', array('returnAsArray' => true))) {
						$va_anchors[] = "<a href='#processing'>"._t("Ubicación de almacenamiento")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='processing'>"._t("Ubicación de almacenamiento")."</a></h3>";
						foreach ($va_related_storage as $va_key => $va_storage) {
							$vs_finding_aid.= caNavLink($this->request, $va_storage, '', '', 'Search', 'objects', array('search' => "ca_storage_locations.preferred_labels:'".$va_storage."'"))."<br/>";
						}
						$vs_finding_aid.= "</div>";
					}										
					$va_subjects_list = array();
					if ($va_subject_terms = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true))) {
						print_r($va_subject_terms);
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							$va_subject_term_list = explode('[', $va_subject_term);
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_term_list[0]), '', '', 'MultiSearch', 'Index', array('search' => "ca_collections.lcsh_terms:'".$va_subject_term_list[0]."'"));
						}
					}
					if ($va_subject_terms_text = $t_item->get('ca_collections.LcshNames', array('returnAsArray' => true))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							$va_subject_text_list = explode('[', $va_subject_term_text);
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_text_list[0]), '', '', 'MultiSearch', 'Index', array('search' => "ca_collections.LcshNames:'".$va_subject_text_list[0]."'"));
						}
					}
					if ($va_subject_genres = $t_item->get('ca_collections.LcshTopical', array('returnAsArray' => true))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							$va_subject_genre_list = explode('[', $va_subject_genre);
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_genre_list[0]), '', '', 'MultiSearch', 'Index', array('search' => "ca_collections.LcshTopical:'".$va_subject_genre_list[0]."'"));
						}
					}											
					asort($va_subjects_list);
					if ($va_subjects_list) {
						$va_anchors[] = "<a href='#subjects'>"._t("Materias - palabras clave y encabezamientos LC")."</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='subjects'>"._t("Materias - palabras clave y encabezamientos LC")."</a></h3>".join("<br/>", $va_subjects_list)."</div>";
					}
					

					if ($t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true)) == "Series") {
						
						if ($va_objects = $t_item->get('ca_objects.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							$vs_finding_aid.=  "<div class='unit'><h3>"._t("Related Objects")."</h3>".$va_objects."</div>";
						}
						if ($va_entities = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							$vs_finding_aid.=  "<div class='unit'><h3>"._t("Entidades relacionadas")."</h3>".$va_entities."</div>";
						}					
						if ($va_work = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('work'), 'delimiter' => '<br/>'))) {
							$vs_finding_aid.=  "<div class='unit'><h3>"._t("Related Works")."</h3>".$va_work."</div>";
						}
						if ($va_production = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('production'), 'delimiter' => '<br/>'))) {
							$vs_finding_aid.=  "<div class='unit'><h3>"._t("Related Productions")."</h3>".$va_production."</div>";
						}
						if ($va_event = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('event'), 'delimiter' => '<br/>'))) {
							$vs_finding_aid.=  "<div class='unit'><h3>"._t("Related Events")."</h3>".$va_event."</div>";
						}																	
					}
					$vs_finding_aid.= "</div></div><!-- end row -->";
					$va_top_level = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'sort' => ['ca_collections.collection_id']));
					
					if ($va_top_level) {
						if ($qr_top_level = caMakeSearchResult('ca_collections', $va_top_level, array('sort' => ['ca_collections.preferred_labels']))) {
							$vs_buf.= "<h3><a name='contents'>"._t("Contenido de la colección")."</a></h3>";
							$va_anchors[] = "<a href='#contents'>"._t("Contenido de la colección")."</a>";
							$vs_buf.= "<div class='colContents'>";
							$vn_i = 0;
						
							while($qr_top_level->nextHit()) {
								$va_series_level = $qr_top_level->get('ca_collections.children.collection_id', array('returnAsArray' => true));
								$qr_series_level = caMakeSearchResult('ca_collections', $va_series_level, array('sort' => ['ca_collections.preferred_labels.name_sort']));
								$vs_buf.= "<div>".(sizeof($va_series_level) > 0 ? "<a href='#' onclick='$(\".seriesLevel".$va_top_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>");
								if ((($qr_top_level->get('ca_collections.type_id', array('convertCodestoDisplayText' => true)) == 125) && $qr_top_level->get('ca_collections.scopecontent')) | ($qr_top_level->get('ca_collections.type_id', array('convertCodestoDisplayText' => true)) != 125)) {
									$vs_buf.= caNavLink($this->request, $qr_top_level->get('ca_collections.preferred_labels').', '.$qr_top_level->get('ca_collections.unitdate.date_value').($qr_top_level->get('ca_collections.folder_number') ? ", "._t("Folder")." ".$qr_top_level->get('ca_collections.folder_number') : ""), '', '', 'Detail', 'collections/'.$qr_top_level->get('ca_collections.collection_id'));
								} elseif ($qr_top_level->get('ca_collections.type_id', array('convertCodestoDisplayText' => true)) == 125){
									$vs_buf.= $qr_top_level->get('ca_collections.preferred_labels').', '.$qr_top_level->get('ca_collections.unitdate.date_value').($qr_top_level->get('ca_collections.folder_number') ? ", "._t("Folder")." ".$qr_top_level->get('ca_collections.folder_number') : "");
								}
								$vs_buf.= "</div>";
								
								if ($qr_series_level) {
									$vs_buf.= "<div class='seriesLevel".$va_top_level_id."' style='margin-left:20px;'>";

									while($qr_series_level->nextHit()) {
										$va_subseries_level = $qr_series_level->get('ca_collections.children.collection_id', array('returnAsArray' => true));
											$qr_subseries_level = caMakeSearchResult('ca_collections', $va_subseries_level, array('sort' => ['ca_collections.preferred_labels.name_sort']));
								
											$vs_buf.= "<div>".(sizeof($va_subseries_level) > 0 ? "<a href='#' onclick='$(\".subseriesLevel".$va_series_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $qr_series_level->get('ca_collections.preferred_labels').', '.$qr_series_level->get('ca_collections.unitdate.date_value').($qr_series_level->get('ca_collections.folder_number') ? ", "._t("Folder")." ".$qr_series_level->get('ca_collections.folder_number') : ""), '', '', 'Detail', 'collections/'.$qr_series_level->get('ca_collections.collection_id'))."</div>";
											if ($qr_subseries_level) {
											
											$vs_buf.= "<div class='subseriesLevel".$va_series_level_id."' style='margin-left:40px;'>";
				
											while($qr_subseries_level->nextHit()) {
												$va_box_levels = $qr_subseries_level->get('ca_collections.children.collection_id', array("idsOnly" => true));
												$vs_buf.= "<div>".(sizeof($va_box_levels) > 0 ? "<a href='#' onclick='$(\".boxLevel".$va_subseries_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $qr_subseries_level->get('ca_collections.preferred_labels').', '.$qr_subseries_level->get('ca_collections.unitdate.date_value').($qr_subseries_level->get('ca_collections.folder_number') ? ", "._t("Folder")." ".$qr_subseries_level->get('ca_collections.folder_number') : ""), '', '', 'Detail', 'collections/'.$qr_subseries_level->get('ca_collections.collection_id'))."</div>";
												$vs_buf.= "<div class='boxLevel".$va_subseries_level_id."' style='margin-left:60px;'>";
									
												if(is_array($va_box_levels)) { 
													if ($qr_box_level = caMakeSearchResult('ca_collections', $va_box_levels, array('sort' => ['ca_collections.preferred_labels.name_sort']))) {
														while($qr_box_level->nextHit()) {
															$vs_buf.= "<div><span class='colspacer'></span>".caNavLink($this->request, $qr_box_level->get('ca_collections.preferred_labels').', '.$qr_box_level->get('ca_collections.unitdate.date_value').($qr_box_level->get('ca_collections.folder_number') ? ", "._t("Folder")." ".$qr_box_level->get('ca_collections.folder_number') : ""), '', '', 'Detail', 'collections/'.$qr_box_level->get('ca_collections.collection_id'))."</div>";
														}
													}
												}
												$vs_buf.= "</div><!-- end boxlevel -->";
											}
				
											$vs_buf.= "</div><!-- end subseries -->";
										}
									}
									$vs_buf.= "</div><!-- end series -->";
								}
							}
							$vs_buf.= "</div><!-- col Contents-->";
						}
					}
					$vs_finding_aid.= $vs_buf;																																																																																																																																			
?>
					

					
				
				
				
					<div class='col-sm-3 col-md-3 col-lg-3 contentsTable'>
						<div style='margin-bottom:20px;'>
							<h3><?php print _t("Table of Contents"); ?></h3>
<?php
							print join('<br/>', $va_anchors);
?>
						</div><!-- end col -->
<?php						
					
					if ($va_rep = $t_item->get('ca_object_representations.media.large')) {
						print "<div class='collectionRep'>".$va_rep."</div>";
					} elseif ($va_rep = $t_item->getWithTemplate('<unit relativeTo="ca_objects" restrictToRelationshipTypes="depicts"><unit relativeTo="ca_object_representations">^ca_object_representations.media.large</unit></unit>')) {
						if ($va_reps = $t_item->get('ca_objects.object_id', array('restrictToRelationshipTypes' => array('depicts'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
							foreach ($va_reps as $va_key => $va_rep) {
								$t_object = new ca_objects($va_rep);
								print "<div class='collectionRep'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.small'), '', '', 'Detail', 'objects/'.$t_object->get('ca_objects.object_id'))."</div>";
							}
						}
					}
						
?>					 					
					</div><!-- end contentsTable-->
					
				
				<div class='col-sm-9 col-md-9 col-lg-9'>
<?php
					#print caNavLink($this->request, 'Download Finding Aid <i class="fa fa-chevron-right"></i>', 'faDownload', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');

?>				
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<h6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.collection_number">, ^ca_collections.collection_number</ifdef>}}}</h6>
<?php					
						print $vs_finding_aid;
				if (($t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true)) == "Collection")) {
?>	
	
<?php
				}
?>								
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>", {'search': 'ca_collections.collection_id:^ca_collections.collection_id'}, function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class="col-sm-1"></div>
</div><!-- end row -->
