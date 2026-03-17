<?php
/** ---------------------------------------------------------------------
 * themes/filo/Front/featured_set_slideshow_html.php
 * Pagina de inicio - buscador centrado + carousel 2 columnas
 * ----------------------------------------------------------------------
 */
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
?>

<div class="home-search">
	<div class="home-search-box">
		<form class="bibtype large" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>" aria-label="<?php print _t("Search"); ?>">
			<div class="formOutline">
				<div class="form-group">
					<input type="text" class="form-control" id="searchInput" placeholder="<?php print _t("Buscar..."); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
				</div>
				<button type="submit" class="btn-search" id="searchButton"><span aria-label="<?php print _t("Submit"); ?>"><?php print _t("Search"); ?> </span></button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#searchButton').prop('disabled', true);
			$('#searchInput').on('keyup', function(){
				$('#searchButton').prop('disabled', this.value == "" ? true : false);
			});
		});
	</script>
</div>


<?php 
	if($qr_res && $qr_res->numHits()){
?>   

		<div class="jcarousel-wrapper">
			<div class="carousel-title">Recursos Destacados</div>

			<!-- Prev/next controls — afuera del jcarousel -->
			<a href="#" class="jcarousel-control-prev">&larr;</a>
			<a href="#" class="jcarousel-control-next">&rarr;</a>

			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
				while($qr_res->nextHit()){
					
					print "<li><div class='frontSlide'>";
					
					$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
					if($vs_caption){
						print "<div class='frontSlideTitle'><p class='bibtype medium'>".$vs_caption."</p>";
						$vs_entity_raw = $qr_res->getWithTemplate('<l>^ca_entities.preferred_labels</l>');
						$vs_entity = str_replace(";",", ", $vs_entity_raw);
						if($vs_entity){
							print "<p class='frontSlideEntity'>".$vs_entity."</p>";
						}
						print "</div>";
					}
					
					if($qr_res->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values))){
						$vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values));
						if($vs_media){
							print "<div class='frontSlideMedia'>".$vs_media."</div>";
						}
					}

					$va_lcsh_subjects_raw = $qr_res->get("ca_objects.lcsh_terms.text");
					$va_lcsh_subjects = str_replace(";",", ", $va_lcsh_subjects_raw);
					if($va_lcsh_subjects){
						print "<div class='frontSlideSubject'>".$va_lcsh_subjects."</div>";
					}
					
					print "</div></li>";
				}
?>
				</ul>
			</div><!-- end jcarousel -->

			<!-- Pagination -->
			<p class="jcarousel-pagination"></p>

		</div><!-- end jcarousel-wrapper -->

		<script type='text/javascript'>
			jQuery(document).ready(function() {

				var GAP = 16; // espacio entre las 2 tarjetas en px

				function initCarousel() {
					var wrapperW = $('.jcarousel-wrapper').width();
					var arrowW   = 50; // ancho reservado para cada flecha
					var trackW   = wrapperW - (arrowW * 2);
					var itemW    = Math.floor((trackW - GAP) / 2);

					// El <ul> interno debe ser MUCHO mas ancho que el track
					// para que jCarousel pueda desplazar los items
					var totalItems = $('.jcarousel li').length;
					var listW = (itemW + GAP) * totalItems + GAP;

					$('.jcarousel').css('width', trackW);
					$('.jcarousel li').css('width', itemW);
					$('.jcarousel ul').css('width', listW);
				}

				initCarousel();
				$(window).on('resize', function(){ initCarousel(); });

				// Inicializar jCarousel
				$('.jcarousel').jcarousel({ wrap: 'circular' });

				// Flechas — avanzan/retroceden de 2 en 2
				$('.jcarousel-control-prev')
					.on('jcarouselcontrol:active',   function(){ $(this).removeClass('inactive'); })
					.on('jcarouselcontrol:inactive', function(){ $(this).addClass('inactive'); })
					.jcarouselControl({ target: '-=2' });

				$('.jcarousel-control-next')
					.on('jcarouselcontrol:active',   function(){ $(this).removeClass('inactive'); })
					.on('jcarouselcontrol:inactive', function(){ $(this).addClass('inactive'); })
					.jcarouselControl({ target: '+=2' });

				// Paginacion
				$('.jcarousel-pagination')
					.on('jcarouselpagination:active',   'a', function(){ $(this).addClass('active'); })
					.on('jcarouselpagination:inactive', 'a', function(){ $(this).removeClass('active'); })
					.jcarouselPagination();
			});
		</script>
<?php
	}
?>
