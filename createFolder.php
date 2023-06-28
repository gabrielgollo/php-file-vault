<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: index.php");
    exit();
}
?>
<?php
include_once './configs/configs.php';
?>

<?php

if (!isset($_POST['folderId'])) {
    echo "<script>alert('Erro ao criar pasta!');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$folderId = $_POST['folderId']; // Replace with the actual folder ID


//verify if in this directory already exists a folder with default name
$defaultName = "Nova Pasta";

include './configs/banco.php';

try {

    // Create a new PDO instance
    $conn = Banco::conectar();

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement to insert the file details
    $insertFolderSQL = 'INSERT INTO FOLDER (folderName, parentFolderId)
                        VALUES (:folderName, :parentFolderId)';
    $stmt = $conn->prepare($insertFolderSQL);
    $stmt->bindParam(':folderName', $defaultName);
    $stmt->bindParam(':parentFolderId', $folderId);
    $stmt->execute();

    // Close the database connection
    Banco::desconectar();

    //write the folder in the directory
    $folderId = $conn->lastInsertId();
    $folderName = $defaultName;
    $folderPath = "../uploads/" . $folderId;
    mkdir($folderPath, 0777, true);

    //redirect to index.php
    echo "<script>window.location.href='index.php';</script>";
    exit();
    
} catch (PDOException $e) {
    // Display an error message
    echo "Error: " . $e->getMessage();
}


?>