<?php
include('../configs/banco.php');

try {
    $conn = Banco::conectar();

    // Delete FILE table
    $deleteFileTable = "DROP TABLE IF EXISTS FILE";
    $conn->exec($deleteFileTable);
    echo "FILE table deleted successfully.<br>";

    // Delete FOLDER table
    $deleteFolderTable = "DROP TABLE IF EXISTS FOLDER";
    $conn->exec($deleteFolderTable);
    echo "FOLDER table deleted successfully.<br>";

    // Delete USER table
    $deleteUserTable = "DROP TABLE IF EXISTS USER";
    $conn->exec($deleteUserTable);
    echo "USER table deleted successfully.<br>";

    // delete all folders in uploads folder
    $folders = glob('../uploads/*', GLOB_ONLYDIR); // get all folder names
    foreach ($folders as $folder) { // iterate folders
        if (is_dir($folder)) {
            rmdir($folder); // delete folder
        }
    }

    Banco::desconectar();
} catch (PDOException $e) {
    echo "Error deleting tables: " . $e->getMessage();
}
?>