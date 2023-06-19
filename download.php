<?php
require_once 'configs/config.global.php';
?>

<?php
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
            $mimeType = $file['mimeType'];
            $folderId = $file['folderId'];

            // Generate the file path on the server
            $filePath = "uploads/$folderId/$fileId";
            echo $filePath;
            // Check if the file exists on the server
            if (file_exists($filePath)) {
                // Set appropriate headers for file download
                header('Content-Type: ' . $mimeType);
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Content-Length: ' . filesize($filePath));

                // Read the file and send it to the user
                readfile($filePath);
                header("location: index.php");
                exit();
            } else {
                // File not found error
                echo 'File not found.';
            }
        } else {
            // Invalid fileId error
            echo 'Invalid fileId.';
        }

        // Close the database connection
        Banco::desconectar();
    } catch (PDOException $e) {
        // Display an error message
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // fileId parameter is missing error
    header("location: index.php");
    exit();
}
?>