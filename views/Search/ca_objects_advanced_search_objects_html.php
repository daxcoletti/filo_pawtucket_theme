<div class="container">
	<div class="row">
		<div class="col-sm-1 "></div>
		<div class="col-sm-10 staticPageArea">
			<div class="container">
				<div class="row">
				
				
		<div class="col-sm-8 ">
			<h4><?php print _t("Búsqueda avanzada"); ?></h4>

<?php		
	print "<p>"._t("Ingresá los términos de búsqueda en los campos a continuación.")."</p>";
?>

{{{form}}}
	
	<div class='advancedContainer row'>
	<div class='col-sm-12 col-md-12 col-lg-12' style='height:60px;'>	
		<div class="advancedSearchField">
			<?php print _t("Título"); ?>:<br/>
			{{{ca_objects.preferred_labels.name%width=380px}}}
		</div>
	</div>	
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			<?php print _t("Entidad / Persona"); ?> <br/>
			{{{ca_entities.preferred_labels.displayname%width=380px&height=25px}}}
			<br style='clear: both;'/>
		</div>
	</div>		
	<div class='col-sm-12 col-md-12 col-lg-12'>			
		<div class="advancedSearchField">
			<?php print _t("Identificador"); ?>:<br/>
			{{{ca_objects.idno%width=53}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			<?php print _t("Tipo"); ?>:<br/>
			{{{ca_objects.type_id%width=380px}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			<?php print _t("Colección"); ?> <br/>
			{{{ca_collections.collection_id%restrictToTypes=collection%width=380px&height=40px&select=1&sort=ca_collections.preferred_labels.name&inUse=1}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			<?php print _t("Palabra clave"); ?><br/>
			{{{_fulltext%width=380px&height=25px}}}
		</div>
	</div>	
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			<?php print _t("Fecha o rango de fechas"); ?> <i>(ej. 1970-1979)</i><br/>
			{{{ca_objects.date%width=380px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-12'>		
		<div class="advancedSearchField">
			<?php print _t("Lugar"); ?><br/>
			{{{ca_objects.venue%width=380px&height=40px0}}}
		</div>
	</div>					
	

	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Limpiar}}}</div>
	<div style="float: right;">{{{submit%label=Buscar}}}</div>	

	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd; min-height:650px; padding-top:40px;'>
			<img src="/themes/filo/assets/pawtucket/graphics/acta-1.jpg" alt="Acta fundacional FFyL" style="width:100%; height:auto; display:block;">
		</div><!-- end col -->
			</div></div>
			</div>
		<div class='col-sm-1'></div>
	</div><!-- end row -->
</div><!-- end container -->
