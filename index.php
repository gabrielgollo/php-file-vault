<?php
include_once './configs/configs.php';
?>

<?php
include './configs/banco.php';
include './utils/table.php';
include './utils/navbar.php';
include './utils/container.php';
include './utils/fileUploadForm.php';


try {
    // Create a new PDO instance
    $conn = Banco::conectar();

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the user's root folderId (assuming the user is already authenticated)
    $userId = $_SESSION["userId"]; // Replace with the actual user's ID
    $username = $_SESSION["username"];

    $getUserRootFolderSQL = 'SELECT rootFolderId, userName FROM USER WHERE userId = :userId';
    $stmtUserRootFolder = $conn->prepare($getUserRootFolderSQL);
    $stmtUserRootFolder->bindParam(':userId', $userId);
    $stmtUserRootFolder->execute();
    $rootFolderId = $stmtUserRootFolder->fetchColumn();

    // Get the contents of the user's root folder
    $getFolderContentsSQL = 'SELECT * FROM FILE WHERE folderId = :folderId';
    $stmtFolderContents = $conn->prepare($getFolderContentsSQL);
    $stmtFolderContents->bindParam(':folderId', $rootFolderId);
    $stmtFolderContents->execute();
    $folderContents = $stmtFolderContents->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $conn = null;
} catch (PDOException $e) {
    // Display an error message
    echo "Error: " . $e->getMessage();
    // You can handle the error as per your requirements (e.g., logging, displaying a user-friendly error page)
    //exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <title><?php echo $TITLE_GLOBAL ?> - Home</title>
</head>

<body>
    <?php
    echo generateNavbar("home");
    $fileUploadForm = generateFileUploadForm($rootFolderId);
    
    $title = "Home";
    $description =  'Welcome '.$username.' to File Vault, a simple file manager. Give a look in the current users';
    $resultHtml = '
    <section>
        <h2>' . $title . '</h2>
        <p>' . $description . '</p>'.
    '</section>';

    
    echo generateContainer($resultHtml);
    
    echo generateContainer($fileUploadForm);
    ?>

    <div class="container">
        <h1>Root Folder Contents</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>MIME Type</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($folderContents as $file) : ?>
                    <tr>
                        <td><?php echo $file['fileName']; ?></td>
                        <td><?php echo $file['mimeType']; ?></td>
                        <td><?php echo $file['createdAt']; ?></td>
                        <td>
                            <a href="#" class="btn btn-primary" onclick="downloadFile('<?php echo $file['fileId']."'".','."'".$file['fileName']."'"; ?>)">Download</a>
                            <a href="#" class="btn btn-danger" onclick="deleteFile('<?php echo $file['fileId']; ?>'); return false;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script src='./assets/file.js'></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
 
</html>
