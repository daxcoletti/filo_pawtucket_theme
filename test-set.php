<?php
// Script de prueba simple para debuggear el set Destacados
// Acceso: /test-set.php

echo "<h1>Prueba de Set 'Destacados'</h1>";
echo "<pre>";

try {
    // Cargar bootstrap - rutas relativas desde /app
    require_once("conf/AppConfig.php");
    require_once("models/ca_sets.php");

    echo "AppConfig y ca_sets cargados...\n\n";

    $t_set = new ca_sets();
    echo "Intentando cargar set con código 'Destacados'...\n";
    $t_set->load(array('set_code' => 'Destacados'));

    echo "Set ID: " . $t_set->get('set_id') . "\n";
    echo "Set Code: " . $t_set->get('set_code') . "\n";
    echo "Set Title: " . $t_set->get('preferred_labels.name') . "\n";

    if ($t_set->get('set_id')) {
        $va_items = $t_set->getItemRowIDs();
        echo "\nItems count: " . count($va_items) . "\n";
        echo "Items IDs: " . implode(", ", array_keys($va_items)) . "\n";
        echo "\n✓ SET CARGADO EXITOSAMENTE\n";
    } else {
        echo "\n✗ ERROR: Set no encontrado con código 'Destacados'\n";
    }
} catch (Exception $e) {
    echo "✗ EXCEPCION: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "</pre>";
