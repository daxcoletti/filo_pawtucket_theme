<?php
require_once(__CA_APP_DIR__."/controllers/FrontController.php");

class FrontController extends FrontController {

    public function index() {
        // Debug: Verificar que se está usando el set correcto
        $vs_set_code = $this->config->get("front_page_set_code");
        error_log("DEBUG FrontController: front_page_set_code = '$vs_set_code'");

        // Llamar al método padre
        parent::index();
    }
}
?>
