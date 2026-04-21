<?php
echo "<h1>Test Simple</h1>";
echo "PHP está funcionando<br>";
echo "Directorio: " . getcwd() . "<br>";
echo "Archivo ca_sets.php existe: " . (file_exists("app/models/ca_sets.php") ? "SÍ" : "NO") . "<br>";
?>
