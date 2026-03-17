<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
?>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 staticPageArea">
	
		<h4><?php print _t("Contacto"); ?></h4>
		<p>¿Tiene alguna consulta sobre nuestra colección? Complete el siguiente formulario y nos pondremos en contacto a la brevedad.</p>

<?php
	if(is_array($va_errors) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
		<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group<?php print (is_array($va_errors) && $va_errors["name"]) ? " has-error" : ""; ?>">
						<label for="name">Nombre</label>
						<input type="text" class="form-control input-sm" placeholder="Ingresá tu nombre" name="name" value="{{{name}}}">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group<?php print (is_array($va_errors) && $va_errors["email"]) ? " has-error" : ""; ?>">
						<label for="email">Correo electrónico</label>
						<input type="text" class="form-control input-sm" placeholder="Ingresá tu email" name="email" value="{{{email}}}">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group<?php print (is_array($va_errors) && $va_errors["phone"]) ? " has-error" : ""; ?>">
						<label for="phone">Teléfono</label>
						<input type="text" class="form-control input-sm" placeholder="Ingresá tu teléfono" name="phone" value="{{{phone}}}">
					</div>
				</div>
<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
				<div class="col-sm-6">
					<div class="form-group<?php print (is_array($va_errors) && $va_errors["recaptcha"]) ? " has-error" : ""; ?>">
						<script type="text/javascript">
							var gCaptchaRender = function(){
								grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
							};
						</script>
						<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
						<div id="regCaptcha"></div>
					</div>
				</div>
<?php
	}
?>
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (is_array($va_errors) && $va_errors["message"]) ? " has-error" : ""; ?>">
						<label for="message">Mensaje</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div>
			</div><!-- end row -->
			
			<div class="form-group">
				<button type="submit" class="btn btn-default">Enviar</button>
			</div>
			<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		</div><!-- end col-md-9 -->
		</div><!-- end row -->
	</form>

	</div><!-- end col-sm-10 -->
	<div class="col-sm-1"></div>
</div>
