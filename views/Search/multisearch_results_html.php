<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	$vs_search = $this->getVar('search');
?>
<div class="col-sm-1"></div>
<div class="col-sm-10">

	<!-- Formulario de búsqueda siempre visible -->
	<div style="margin: 20px 0 30px 0;">
		<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" method="get">
			<div class="filo-search-row" style="max-width:600px;">
				<input type="text" name="search" value="<?php print htmlspecialchars($vs_search); ?>"
					placeholder="<?php print _t('Buscá documentos, fotografías, fondos...'); ?>"
					style="flex:1; border:none; padding:12px 18px; font-size:15px; outline:none;" />
				<button type="submit"
					style="background:#1a2035; border:none; padding:0 20px; color:#fff; font-size:16px; cursor:pointer;">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		</form>
	</div>

<?php
	if ($vs_search) {
		if ($va_result_count > 0) {
?>
		<h4 style='margin-bottom:10px; letter-spacing:1px; float:left;'><?php print _t("Resultados para %1", caUcFirstUTF8Safe($vs_search)); ?></h4>
		<small class='pull-right' style='margin-top:20px; margin-bottom:10px;'>
<?php
			$i = 0;
			foreach($this->getVar('blockNames') as $vs_block) {
				if ($va_results[$vs_block]['count'] == 0) { continue; }
				$i++;
				if($i > 1){ print " | "; }
				print "<a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].")</a>";
			}
?>
		</small>
<?php
			foreach($this->getVar('blockNames') as $vs_block) {
?>
			<a name='<?php print $vs_block; ?>'></a>
			<div id="<?php print $vs_block; ?>Block" class='resultBlock'>
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
			}
		} else {
			print "<p style='color:#666; margin-top:10px;'>"._t("No se encontraron resultados para %1", "<strong>".caUcFirstUTF8Safe($vs_search)."</strong>")."</p>";
		}
	}
?>

</div>
<div class="col-sm-1"></div>
<?php
	TooltipManager::add('#Block', _t('Tipo de registro'));
?>
