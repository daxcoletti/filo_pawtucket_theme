<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
	if($this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$va_user_links[] = '<li class="divider nav-divider"></li>';
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	if(Debug::isEnabled()) {		
		//
		// Pull in JS and CSS for debug bar
		// 
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">

</head>
<body>

	<!-- ============================================================
	     ENCABEZADO FILO UBA
	     Estructura: [barra superior gris] + [logo sobre fondo BLANCO
	     con redes sociales] + [navbar azul oscuro con links]
	     ============================================================ -->

	<!-- 1. Barra superior: fondo gris muy claro, links utilitarios -->
	<div style="background-color:#f2f2f2; border-bottom:1px solid #ddd; font-size:11px; padding:5px 0;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12" style="display:flex; align-items:center; justify-content:space-between;">
					<ul class="list-inline" style="margin:0; padding:0;">
						<li>
							<a href="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>"
							   style="color:#1a2035; font-weight:700; text-decoration:none; text-transform:uppercase; font-size:10px; letter-spacing:1.5px;">
								<span class="glyphicon glyphicon-search" style="margin-right:4px; color:#2db5a3;"></span><?php print _t('Buscador'); ?>
							</a>
						</li>
					</ul>
					<ul class="list-inline" style="margin:0; padding:0;">
<?php if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')): ?>
						<li>
<?php if($this->request->isLoggedIn()): ?>
							<a href="<?php print caNavUrl($this->request, '', 'LoginReg', 'Logout', array()); ?>"
							   style="color:#1a2035; font-weight:700; text-decoration:none; text-transform:uppercase; font-size:10px; letter-spacing:1.2px;">
								<span class="glyphicon glyphicon-user" style="margin-right:4px;"></span><?php print $this->request->user->get("fname"); ?> — <?php print _t('Salir'); ?>
							</a>
<?php else: ?>
							<a href="#" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array()); ?>'); return false;"
							   style="color:#1a2035; font-weight:700; text-decoration:none; text-transform:uppercase; font-size:10px; letter-spacing:1.2px;">
								<span class="glyphicon glyphicon-user" style="margin-right:4px;"></span><?php print _t('Ingresar'); ?>
							</a>
<?php endif; ?>
						</li>
<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- 2. Banda del logo: fondo BLANCO, logo a la izquierda, redes a la derecha -->
	<div style="background-color:#ffffff; padding:14px 0 12px 0; border-bottom:1px solid #e0e0e0;">
		<div class="container">
			<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
				<!-- Logo -->
				<a href="<?php print caNavUrl($this->request, '', '', ''); ?>">
					<?php print caGetThemeGraphic($this->request, 'filo_logo.png', ['style'=>'height:60px; width:auto;']); ?>
				</a>
				<!-- Redes sociales (solo desktop) -->
				<div class="hidden-xs" style="display:flex; align-items:center; gap:14px;">
					<a href="https://www.facebook.com/filosofiayletrasuba" target="_blank" title="Facebook"
					   style="color:#1a2035; font-size:22px; text-decoration:none; transition:color .2s;"
					   onmouseover="this.style.color='#2db5a3'" onmouseout="this.style.color='#1a2035'">
						<i class="fa fa-facebook-square"></i></a>
					<a href="https://x.com/filo_uba" target="_blank" title="X / Twitter"
					   style="color:#1a2035; font-size:22px; text-decoration:none; transition:color .2s;"
					   onmouseover="this.style.color='#2db5a3'" onmouseout="this.style.color='#1a2035'">
						<i class="fa fa-twitter"></i></a>
					<a href="https://www.instagram.com/filo.uba" target="_blank" title="Instagram"
					   style="color:#1a2035; font-size:22px; text-decoration:none; transition:color .2s;"
					   onmouseover="this.style.color='#2db5a3'" onmouseout="this.style.color='#1a2035'">
						<i class="fa fa-instagram"></i></a>
					<a href="https://www.youtube.com/@FFyL" target="_blank" title="YouTube"
					   style="color:#1a2035; font-size:22px; text-decoration:none; transition:color .2s;"
					   onmouseover="this.style.color='#2db5a3'" onmouseout="this.style.color='#1a2035'">
						<i class="fa fa-youtube-play"></i></a>
				</div>
			</div>
		</div>
	</div>

	<!-- 3. Navbar principal: fondo AZUL OSCURO con links de navegación -->
	<nav class="navbar navbar-default yamm" role="navigation"
	     style="background-color:#1a2035; border-radius:0; border:0; margin-bottom:0; min-height:46px; border-bottom:3px solid #2db5a3;">
		<div class="container">
			<div class="navbar-header">
<?php
	if ($vb_has_user_links) {
?>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only"><?php print _t('Opciones de usuario'); ?></span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only"><?php print _t('Toggle navigation'); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">
					<?php print join("\n", $va_user_links); ?>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				</form>
				<ul class="nav navbar-nav navbar-right menuList">
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "Index")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Acerca de"), "", "", "About", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Collection") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Fondos y Colecciones"), "", "FindingAid", "Collection", "Index"); ?></li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>
 					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Búsqueda Avanzada"), "", "", "Search", "advanced/objects"); ?></li>
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "contact")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contacto"), "", "", "Contact", "form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
