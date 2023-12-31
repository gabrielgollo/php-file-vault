<?php
include_once 'configs/configs.php';
// Check if the fileId query parameter is set
if (isset($_GET['fileId'])) {
    include_once './configs/banco.php';
    // Get the fileId query parameter value
    $fileId = $_GET['fileId'];

    try {
        // Create a new PDO instance
        $conn = Banco::conectar();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to fetch file details by fileId
        $fetchFileSQL = 'SELECT fileName, mimeType, folderId FROM FILE WHERE fileId = :fileId';
        $stmtFile = $conn->prepare($fetchFileSQL);
        $stmtFile->bindParam(':fileId', $fileId);
        $stmtFile->execute();
        $file = $stmtFile->fetch(PDO::FETCH_ASSOC);

        // Check if the file exists
        if ($file) {
            $fileName = $file['fileName'];
            $mimeType = $file['mimeType'];
            $folderId = $file['folderId'];

            // Generate the file path on the server
            $filePath = "../uploads/$folderId/$fileId";
            // echo $filePath;
            // Check if the file exists on the server
            if (file_exists($filePath)) {
                // Set appropriate headers for file download
                header('Content-Type: ' . $mimeType);
                header('Content-Disposition: attachment; filename="'.$fileName.'"');
                header('Content-Length: ' . filesize($filePath));
                http_response_code(200);
                // Write the file to the browser
                readfile($filePath);

                // Exit from the script
                die();

            } else {
                // File not found error
                http_response_code(404);
                echo 'File not found.';
            }
        } else {
            // Invalid fileId error
            http_response_code(404);
            echo 'Invalid fileId.';
        }

        // Close the database connection
        Banco::desconectar();
        header("location: index.php");
        exit();
    } catch (PDOException $e) {
        // Display an error message
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // fileId parameter is missing error
    header("location: index.php");
    exit();
}?>