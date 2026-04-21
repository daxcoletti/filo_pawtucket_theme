<?php
echo "<h1>Verificar archivos visibles desde PHP</h1>";
echo "<pre>";

echo "Directorio actual: " . getcwd() . "\n\n";

// Listar directorio actual
echo "Contenido de /app:\n";
$files = scandir('/app');
foreach ($files as $file) {
    if (!in_array($file, ['.', '..'])) {
        echo "  $file\n";
    }
}

echo "\nContenido de /app/conf:\n";
if (is_dir('/app/conf')) {
    $files = scandir('/app/conf');
    foreach ($files as $file) {
        if (!in_array($file, ['.', '..']) && strpos($file, 'app') !== false) {
            echo "  $file\n";
        }
    }
} else {
    echo "  Directorio no existe\n";
}

echo "\nIntentando leer /app/conf/app.conf:\n";
if (file_exists('/app/conf/app.conf')) {
    echo "  Archivo existe\n";
    $content = file_get_contents('/app/conf/app.conf');
    $lines = explode("\n", $content);
    foreach ($lines as $line) {
        if (strpos($line, 'db_') === 0) {
            echo "  " . trim($line) . "\n";
        }
    }
} else {
    echo "  Archivo NO existe\n";

    // Buscar otros app.conf
    echo "\n  Buscando app.conf en el sistema:\n";
    $result = shell_exec('find /app -name "app.conf" 2>/dev/null | head -5');
    echo "  " . $result;
}

echo "</pre>";
?>
