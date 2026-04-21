<?php
echo "<h1>Test: Configuración del set destacado</h1>";
echo "<pre>";

// Leer front.conf como texto
$config_file = '/app/themes/filo/conf/front.conf';
$content = file_get_contents($config_file);

echo "Contenido completo de front.conf:\n";
echo "================================\n";
echo $content;
echo "\n================================\n\n";

// Extraer front_page_set_code
preg_match('/front_page_set_code\s*=\s*([^\n]+)/', $content, $match);

if ($match) {
    $raw_value = $match[1];
    $clean_value = trim($raw_value, '\'" ');

    echo "Valor encontrado (raw): '" . $raw_value . "'\n";
    echo "Valor después de limpiar: '" . $clean_value . "'\n";
    echo "Largo: " . strlen($clean_value) . "\n";
    echo "Bytes: " . bin2hex($clean_value) . "\n";
} else {
    echo "No se encontró front_page_set_code\n";
}

echo "</pre>";
?>
