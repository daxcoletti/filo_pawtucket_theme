<?php
$va_debug = $this->getVar('debug');
$qr_result = $this->getVar('result');
$va_access_values = caGetUserAccessValues($this->request);
?>

<div class="container" style="margin: 40px auto; padding: 20px;">
	<h1>Prueba de Set "Destacados"</h1>

	<h2>Debug Info:</h2>
	<pre style="background: #f0f0f0; padding: 15px; border-radius: 5px;">
<?php print_r($va_debug); ?>
	</pre>

	<?php if ($qr_result && $qr_result->numHits() > 0): ?>
		<h2>Items del Set (<?php print $qr_result->numHits(); ?>):</h2>
		<div class="row">
			<?php while($qr_result->nextHit()): ?>
				<div class="col-sm-3" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
					<div style="margin-bottom: 10px;">
						<?php
						if ($vs_image = $qr_result->get('ca_object_representations.media.preview', array("checkAccess" => $va_access_values))) {
							print $qr_result->getWithTemplate('<l>^ca_object_representations.media.preview</l>', array("checkAccess" => $va_access_values));
						} else {
							print '<div style="background: #f0f0f0; height: 150px; display: flex; align-items: center; justify-content: center;">Sin imagen</div>';
						}
						?>
					</div>
					<strong><?php print $qr_result->get('ca_objects.preferred_labels.name'); ?></strong><br>
					<small><?php print $qr_result->get('ca_objects.idno'); ?></small>
				</div>
			<?php endwhile; ?>
		</div>
	<?php elseif (isset($va_debug['error'])): ?>
		<div style="background: #ffe6e6; padding: 15px; border-radius: 5px; color: #c00;">
			<strong>ERROR:</strong> <?php print $va_debug['error']; ?>
		</div>
	<?php else: ?>
		<div style="background: #fff3cd; padding: 15px; border-radius: 5px; color: #856404;">
			<strong>Advertencia:</strong> El set no tiene items o no fue encontrado.
		</div>
	<?php endif; ?>
</div>
