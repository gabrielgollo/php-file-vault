<?php 
    include './configs/config.global.php';
    include './configs/banco.php';
?>

<?php
// Check the current page method
if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $username = trim($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Perform further validation as per your requirements
    $errors = array();

    // Validate username
    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    // Validate email
    if (!$email) {
        $errors[] = 'Invalid email address.';
    }

    // Validate password
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    // If there are no validation errors, proceed with registration
    if (empty($errors)) {
        try{

            $conn = Banco::conectar();
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement
            $insertUserSQL = 'INSERT INTO USER (username, email, password, createdAt, rootFolderId) VALUES (:username, :email, :password, NOW(), NULL)';
            $insertFolderSQL = 'INSERT INTO FOLDER (folderName, parentFolderId) VALUES (:folderName, NULL)';
            $stmt = $conn->prepare($sql);

            // Start a transaction
            $conn->beginTransaction();

            // Insert the folder record
            $insertFolderSQL = 'INSERT INTO FOLDER (folderName, parentFolderId) VALUES (:folderName, NULL)';
            $stmtFolder = $conn->prepare($insertFolderSQL);
            $stmtFolder->bindParam(':folderName', $username);
            $stmtFolder->execute();

            // Get the auto-generated folderId for the inserted folder
            $folderId = $conn->lastInsertId();

            // Insert the user record with the associated folder
            $insertUserSQL = 'INSERT INTO USER (username, email, password, createdAt, rootFolderId) VALUES (:username, :email, :password, NOW(), :rootFolderId)';
            $stmtUser = $conn->prepare($insertUserSQL);
            $stmtUser->bindParam(':username', $username);
            $stmtUser->bindParam(':email', $email);
            $stmtUser->bindParam(':password', $password);
            $stmtUser->bindParam(':rootFolderId', $folderId);
            $stmtUser->execute();

            // Commit the transaction
            $conn->commit();

            // Define the path where you want to create the folder
            $basePath = 'uploads/' . $folderId . '/';

            // Create the folder
            if (!file_exists($basePath)) {
                if (mkdir($basePath, 0777, true)) {
                    // Folder created successfully
                    echo 'Folder created successfully.';
                } else {
                    // Failed to create the folder
                    echo 'Failed to create the folder.';
                }
            } else {
                // Folder already exists
                echo 'Folder already exists.';
            }

            // Close the database connection
            Banco::desconectar();
            
            header('Location: success.php');
            exit();
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container d-flex justify-content-center">
        <form method="POST" action="register.php">
            <div class="jumbotron">
            <h1>Registration Form</h1>
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
    <footer>
        <div class="container d-flex justify-content-center">
            <span class="text-muted">File Vault - By Gabriel Gollo - 2023</span>
        </div>
    </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>