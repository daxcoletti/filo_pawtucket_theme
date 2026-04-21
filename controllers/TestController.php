<?php

class TestController extends ActionController {
	# -------------------------------------------------------
	public function index(){
		try {
			// Cargar el set "Destacados"
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => 'Destacados'));

			$va_debug = array();
			$va_debug['set_code_buscado'] = 'Destacados';
			$va_debug['set_id'] = $t_set->get('set_id');
			$va_debug['set_code_encontrado'] = $t_set->get('set_code');
			$va_debug['title'] = $t_set->get('preferred_labels.name');

			if ($t_set->get('set_id')) {
				$va_items = $t_set->getItemRowIDs();
				$va_debug['items_count'] = count($va_items);
				$va_debug['items'] = array_keys($va_items);

				// Crear SearchResult con los items
				$qr_result = caMakeSearchResult('ca_objects', array_keys($va_items));
				$this->view->setVar('result', $qr_result);
				$va_debug['success'] = 'Set cargado correctamente';
			} else {
				$va_debug['error'] = 'Set no encontrado con código "Destacados"';
			}

			$this->view->setVar('debug', $va_debug);
		} catch (Exception $e) {
			$this->view->setVar('debug', array('exception' => $e->getMessage()));
		}

		$this->render('test_html.php');
	}
}
