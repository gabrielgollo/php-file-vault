<?php
include('../configs/banco.php');

$conn = Banco::conectar();

$query = "SHOW TABLES";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($tables)) {
        echo "Tables in the database:<br>";
        foreach ($tables as $table) {
            echo $table . "<br>";
        }
    } else {
        echo "No tables found in the database.";
    }

Banco::desconectar();

?>