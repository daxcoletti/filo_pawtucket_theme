<?php
/** ---------------------------------------------------------------------
 * themes/filo/Front/featured_set_slideshow_html.php
 * Pantalla de inicio: hero full-viewport + carousel debajo
 * ----------------------------------------------------------------------
 */
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}
	$va_bg = ['bg-bandera', 'bg-edificio', 'bg-acta'];
	$vs_bg = $va_bg[array_rand($va_bg)];
?>

<!-- HERO full-viewport -->
<div class="filo-hero <?php print $vs_bg; ?>">
	<div class="filo-hero-inner">
		<p class="filo-hero-tagline"><?php print _t('Explorá la memoria documental de la'); ?></p>
		<h1 class="filo-hero-title"><?php print _t('Facultad de Filosofía y Letras'); ?><br><span><?php print _t('Universidad de Buenos Aires'); ?></span></h1>

		<div class="filo-hero-search">
			<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
				<div class="filo-search-row">
					<input type="text" id="searchInput" name="search" autocomplete="off"
						placeholder="<?php print _t('Buscá documentos, fotografías, fondos...'); ?>"
						aria-label="<?php print _t('Texto de búsqueda'); ?>" />
					<button type="submit" id="searchButton" disabled>
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</form>
		</div>

		<a href="#recursos-destacados" class="filo-hero-scroll">
			<span><?php print _t('Recursos destacados'); ?></span>
			<span class="glyphicon glyphicon-chevron-down"></span>
		</a>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#searchButton').prop('disabled', true);
	$('#searchInput').on('keyup', function(){
		$('#searchButton').prop('disabled', this.value === '');
	});
	$('.filo-hero-scroll').on('click', function(e){
		e.preventDefault();
		$('html, body').animate({ scrollTop: $('#recursos-destacados').offset().top }, 600);
	});
});
</script>

<!-- CAROUSEL debajo del hero -->
<?php if($qr_res && $qr_res->numHits()){ ?>

<div id="recursos-destacados" class="jcarousel-section">
	<div class="jcarousel-wrapper">
		<div class="carousel-title"><?php print _t('Recursos Destacados'); ?></div>
		<a href="#" class="jcarousel-control-prev">&larr;</a>
		<a href="#" class="jcarousel-control-next">&rarr;</a>
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
				if($vs_entity){ print "<p class='frontSlideEntity'>".$vs_entity."</p>"; }
				print "</div>";
			}
			if($qr_res->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values))){
				$vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values));
				if($vs_media){ print "<div class='frontSlideMedia'>".$vs_media."</div>"; }
			}
			$va_lcsh_subjects = str_replace(";",", ", $qr_res->get("ca_objects.lcsh_terms.text"));
			if($va_lcsh_subjects){ print "<div class='frontSlideSubject'>".$va_lcsh_subjects."</div>"; }
			print "</div></li>";
		}
?>
			</ul>
		</div>
		<p class="jcarousel-pagination"></p>
	</div>

	<script type='text/javascript'>
	jQuery(document).ready(function() {
		var GAP = 16;
		function initCarousel() {
			var wrapperW = $('.jcarousel-wrapper').width();
			var trackW   = wrapperW - 100;
			var itemW    = Math.floor((trackW - GAP) / 2);
			var listW    = (itemW + GAP) * $('.jcarousel li').length + GAP;
			$('.jcarousel').css('width', trackW);
			$('.jcarousel li').css('width', itemW);
			$('.jcarousel ul').css('width', listW);
		}
		initCarousel();
		$(window).on('resize', initCarousel);
		$('.jcarousel').jcarousel({ wrap: 'circular' });
		$('.jcarousel-control-prev')
			.on('jcarouselcontrol:active',   function(){ $(this).removeClass('inactive'); })
			.on('jcarouselcontrol:inactive', function(){ $(this).addClass('inactive'); })
			.jcarouselControl({ target: '-=2' });
		$('.jcarousel-control-next')
			.on('jcarouselcontrol:active',   function(){ $(this).removeClass('inactive'); })
			.on('jcarouselcontrol:inactive', function(){ $(this).addClass('inactive'); })
			.jcarouselControl({ target: '+=2' });
		$('.jcarousel-pagination')
			.on('jcarouselpagination:active',   'a', function(){ $(this).addClass('active'); })
			.on('jcarouselpagination:inactive', 'a', function(){ $(this).removeClass('active'); })
			.jcarouselPagination();
	});
	</script>
</div>

<?php } ?>
