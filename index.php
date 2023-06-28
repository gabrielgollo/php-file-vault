<?php
include_once './configs/configs.php';
?>

<?php
include './configs/banco.php';
include './utils/table.php';
include './utils/navbar.php';
include './utils/container.php';
include './utils/fileUploadForm.php';

$icons = array();
$icons["folder"] = "assets/imgs/folder.png";
$icons["unknowFile"] = "assets/imgs/unknowFile.png";
$icons["pdf"] = "assets/imgs/pdf.png";


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
    
    if(isset($_POST['folderId'])){
        $currentFolderId = $_POST['folderId'];
    } else {
        $currentFolderId = $rootFolderId;
    }
    
    // Get the contents of the user's root folder
    $getFolderContentsSQL = 'SELECT * FROM FOLDER WHERE parentFolderId = :folderId';
    $stmtFolderContents = $conn->prepare($getFolderContentsSQL);
    $stmtFolderContents->bindParam(':folderId', $currentFolderId);
    $stmtFolderContents->execute();
    $folders = $stmtFolderContents->fetchAll(PDO::FETCH_ASSOC);

    // Get the contents of the user's root folder
    $getFolderContentsSQL = 'SELECT * FROM FILE WHERE folderId = :folderId';
    $stmtFolderContents = $conn->prepare($getFolderContentsSQL);
    $stmtFolderContents->bindParam(':folderId', $currentFolderId);
    $stmtFolderContents->execute();
    $files = $stmtFolderContents->fetchAll(PDO::FETCH_ASSOC);
    $folderContents = $files;

    // Close the database connection
    Banco::desconectar();
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
    <script src='assets/file.js'></script>
    
    <title><?php echo $TITLE_GLOBAL ?> - Home</title>
</head>

<body>
    <?php
    echo generateNavbar("home");
    
    $title = "Home";
    $description =  'Welcome '.$username.' to File Vault, a simple file manager. Give a look in the current users';
    $resultHtml = '
    <section>
    <h2>' . $title . '</h2>
    <p>' . $description . '</p>'.
    '</section>';
    
    
    echo generateContainer($resultHtml);
    
    $fileUploadForm = generateFileUploadForm($rootFolderId);
    echo generateContainer($fileUploadForm);

    // $createFolderButton = '<a href="createFolder.php" class="btn btn-primary">Create Folder</a>';
    ?>

    <!-- <form action="upload.php" method="POST" enctype="multipart/form-data" style="border:0px;" id="fileForm">
        <input type="hidden" name="folderId" value="' . $folderId . '">
        <div class="form-group">
            <input type="file" class="form-control form-control-lg" id="file" name="file" onchange="uploadFile()">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form> -->

    <div class="container">
        <?php
            function showFolderNameAndBackButton(){
            if(isset($_POST['folderId'])){
                $conn = Banco::conectar();
                $folderId = $_POST['folderId'];
                $getFolderNameSQL = 'SELECT * FROM FOLDER WHERE folderId = :folderId';
                $stmtFolderName = $conn->prepare($getFolderNameSQL);
                $stmtFolderName->bindParam(':folderId', $folderId);
                $stmtFolderName->execute();
                $data = $stmtFolderName->fetchColumn();
                Banco::desconectar();
                //back folder
                echo '<div class="folder" onclick="submitFolderForm('.$data["parentFolderId"].');" style="cursor: pointer;"><- Back</div>';
                echo '<h2>Folder: '.$data["folderName"].'</h2>';
                // echo $data;
                if(isset($data["parentFolderId"])) return 0;
            } else {
                echo '<h1>Root Folder Contents</h1>';

            }
            return 0;
            } 
            showFolderNameAndBackButton();
        ?>
        <form action="createFolder.php" method="POST" enctype="multipart/form-data" style="border:0px;" id="folderForm">
            <input type="hidden" name="folderId" value="<?php echo $currentFolderId; ?>">
            <button href="createFolder.php" class="btn btn-primary">Create Folder</button>
        </form>
        </br>
        <div class="folder-container">
            <?php foreach ($folders as $folder): ?>
                <div class="folder" onclick="submitFolderForm(<?php echo $folder['folderId']; ?>);" style="cursor: pointer;">
                <img src="<?php echo $icons['folder']; ?>" alt="Folder Icon" class="icon" width="32" height="32">
                    <span><?php echo $folder['folderName']; ?></span>
                    <a href="#" class="btn btn-danger" onclick="deleteFile('<?php echo $file['fileId']; ?>'); return false;">Delete</a>
                </div>
            <?php endforeach; ?>
            </br>
            <?php foreach ($files as $file): ?>
                <div class="file">
                    <img src="<?php echo $icons['unknowFile']; ?>" alt="File Icon" class="icon" width="32" height="32">
                    <span><?php echo $file['fileName']; ?></span>
                    <a href="#" class="btn btn-primary" onclick="downloadFile('<?php echo $file['fileId']."'".','."'".$file['fileName']."'"; ?>)">Download</a>
                    <a href="#" class="btn btn-danger" onclick="deleteFile('<?php echo $file['fileId']; ?>'); return false;">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- <div class="container">
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
    </div> -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
 
</html>
