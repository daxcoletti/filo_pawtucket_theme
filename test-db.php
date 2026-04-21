<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Query directo a BD - Set Destacados</h1>";
echo "<pre>";

// Credenciales encontradas en /opt/collectiveaccess/.env
$host = 'ca_mariadb';
$user = 'ca_user';
$pass = 'capassword';
$db = 'collectiveaccess';  // Pawtucket y Providence comparten esta BD

echo "Conectando a:\n";
echo "  Host: $host\n";
echo "  User: $user\n";
echo "  DB: $db\n\n";

try {
    $mysqli = new mysqli($host, $user, $pass, $db);

    if ($mysqli->connect_error) {
        echo "✗ Conexión falló: " . $mysqli->connect_error . "\n";
        exit;
    }

    echo "✓ Conexión exitosa\n\n";

    // Query para obtener el set
    $sql = "SELECT set_id, set_code FROM ca_sets WHERE set_code = 'Destacados' LIMIT 1";
    echo "SQL: $sql\n\n";

    $result = $mysqli->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "✓✓✓ SET ENCONTRADO ✓✓✓\n";
                echo "  Set ID: " . $row['set_id'] . "\n";
                echo "  Set Code: " . $row['set_code'] . "\n";

                // Obtener items del set
                $set_id = $row['set_id'];
                echo "\n  Buscando tabla de items del set...\n";

                // Buscar qué tabla contiene los items
                $sql_tables = "SHOW TABLES LIKE '%set%'";
                $result_tables = $mysqli->query($sql_tables);
                echo "  Tablas disponibles que contienen 'set':\n";
                $table_found = null;
                while ($row_table = $result_tables->fetch_assoc()) {
                    $table_name = array_values($row_table)[0];
                    echo "    - $table_name\n";

                    // Intentar usar esta tabla
                    if (strpos($table_name, 'items') !== false && $table_found === null) {
                        $sql2 = "SELECT COUNT(*) as count FROM $table_name WHERE set_id = $set_id";
                        $result2 = $mysqli->query($sql2);
                        if ($result2) {
                            $row2 = $result2->fetch_assoc();
                            echo "\n  ✓ Usando tabla: $table_name\n";
                            echo "  Items en set: " . $row2['count'] . "\n";
                            $table_found = $table_name;
                        }
                    }
                }

                if ($table_found === null) {
                    echo "\n  No se encontró tabla de items. Intentando query manual...\n";
                    $sql2 = "SELECT object_id FROM ca_set_items WHERE set_id = $set_id LIMIT 5";
                    $result2 = $mysqli->query($sql2);
                    if ($result2) {
                        echo "  Primeros 5 items: \n";
                        while ($row2 = $result2->fetch_assoc()) {
                            echo "    - Object ID: " . $row2['object_id'] . "\n";
                        }
                    } else {
                        echo "  Error: " . $mysqli->error . "\n";
                    }
                }
            }
        } else {
            echo "✗ SET NO ENCONTRADO con código 'Destacados'\n";
            echo "\nMostrando primeros 10 sets en la BD:\n";

            $sql = "SELECT set_id, set_code FROM ca_sets LIMIT 10";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "  - ID: " . $row['set_id'] . " Code: '" . $row['set_code'] . "'\n";
            }
        }
    } else {
        echo "✗ Error en query: " . $mysqli->error . "\n";
    }

    $mysqli->close();
} catch (Exception $e) {
    echo "✗ Excepción: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
