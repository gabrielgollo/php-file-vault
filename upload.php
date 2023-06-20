<?php
include_once 'configs/configs.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: index.php");
    exit();
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    include 'configs/banco.php';

    // Get the file details from the $_FILES array
    $file = $_FILES['file'];
    $folderId = $_POST['folderId']; // Replace with the actual folder ID
    
    // Define the upload directory
    $uploadDir = 'uploads/' . $folderId . '/';

    // Create the directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate a unique filename for the uploaded file
    $uniqueFilename = uniqid() . '_' . $file['name'];

    // Move the uploaded file to the upload directory
    $targetFilePath = $uploadDir . $uniqueFilename;
    move_uploaded_file($file['tmp_name'], $targetFilePath);

    // Insert the file details into the FILE table
    $fileId = $uniqueFilename;
    $fileName = $file['name'];
    $mimeType = $file['type'];
    $createdAt = date('Y-m-d H:i:s');
    $checkSum = md5_file($targetFilePath); // Calculate the checksum
    // verify if filename has .php
    if (strpos($fileName, '.php') !== false) {
        echo "<script>alert('Arquivo não permitido!');</script>";
        echo "<script>window.location.href='index.php';</script>";
        exit();
    }
        try {
        // Create a new PDO instance
        $conn = Banco::conectar();
        
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare the SQL statement to insert the file details
        $insertFileSQL = 'INSERT INTO FILE (fileId, fileName, mimeType, createdAt, checkSum, folderId)
                        VALUES (:fileId, :fileName, :mimeType, :createdAt, :checkSum, :folderId)';
        $stmt = $conn->prepare($insertFileSQL);
        $stmt->bindParam(':fileId', $fileId);
        $stmt->bindParam(':fileName', $fileName);
        $stmt->bindParam(':mimeType', $mimeType);
        $stmt->bindParam(':createdAt', $createdAt);
        $stmt->bindParam(':checkSum', $checkSum);
        $stmt->bindParam(':folderId', $folderId);
        $stmt->execute();
        
        // Close the database connection
        Banco::desconectar();
        
        // // Return the file details as the response
        // $response = array(
        //     'fileId' => $fileId,
        //     'fileName' => $fileName,
        //     'mimeType' => $mimeType,
        //     'createdAt' => $createdAt,
        //     'checkSum' => $checkSum
        // );
        // echo json_encode($response);

        // Redirect to index.php
        // header("Location: index.php");
        echo "<script>window.location.href='index.php';</script>";
        exit();
    } catch (PDOException $e) {
        // Display an error message
        echo "Error: " . $e->getMessage();
        // You can handle the error as per your requirements (e.g., logging, displaying a user-friendly error message)
        header('location: index.php');
        exit();
    }
}
?>
