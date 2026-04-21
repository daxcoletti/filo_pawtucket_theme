<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug del Set 'Destacados'</h1>";
echo "<pre>";

// Test 1: Verificar archivos
echo "TEST 1: Verificar archivos\n";
echo "conf/AppConfig.php existe: " . (file_exists("conf/AppConfig.php") ? "SÍ" : "NO") . "\n";
echo "models/ca_sets.php existe: " . (file_exists("models/ca_sets.php") ? "SÍ" : "NO") . "\n";

// Test 2: Intentar cargar AppConfig
echo "\nTEST 2: Cargar AppConfig\n";
try {
    require_once("conf/AppConfig.php");
    echo "✓ AppConfig cargado\n";
} catch (Exception $e) {
    echo "✗ Error al cargar AppConfig: " . $e->getMessage() . "\n";
}

// Test 3: Intentar cargar ca_sets
echo "\nTEST 3: Cargar ca_sets\n";
try {
    require_once("models/ca_sets.php");
    echo "✓ ca_sets cargado\n";
} catch (Exception $e) {
    echo "✗ Error al cargar ca_sets: " . $e->getMessage() . "\n";
}

// Test 4: Crear instancia de ca_sets
echo "\nTEST 4: Crear instancia de ca_sets\n";
try {
    $t_set = new ca_sets();
    echo "✓ Instancia de ca_sets creada\n";
} catch (Exception $e) {
    echo "✗ Error al crear instancia: " . $e->getMessage() . "\n";
}

// Test 5: Cargar set con código 'Destacados'
echo "\nTEST 5: Cargar set 'Destacados'\n";
try {
    $t_set->load(array('set_code' => 'Destacados'));
    echo "✓ load() ejecutado\n";
    echo "Set ID: " . $t_set->get('set_id') . "\n";
    echo "Set Code: " . $t_set->get('set_code') . "\n";
} catch (Exception $e) {
    echo "✗ Error al cargar set: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
