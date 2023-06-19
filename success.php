<?php
require_once 'configs/config.global.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $TITLE_GLOBAL ?> - Registration Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Registration Successful</h1>
        <p>Your registration has been successful. You can now proceed to log in using your credentials.</p>
        <a href="login.php" class="btn btn-primary">Login</a>
    </div>
    <footer>
        <div class="container d-flex justify-content-center">
            <span class="text-muted">File Vault - By Gabriel Gollo - 2023</span>
        </div>
    </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>