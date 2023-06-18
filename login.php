<?php
    require_once 'configs/config.global.php';
    $warningBallon = '';
?>
<?php
    // check curect page method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "POST";
        if (!isset($_POST["email"]) || !isset($_POST["password"])) {
            header("Location: login.php");
            exit;
        }
        
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        // echo $email."<br>";
        // echo $password;
        if($email == '' || $password == '') {
            // header("Location: login.php");
            // exit;
        }
    
        // require_once 'configs/config.global.php';
        require_once 'configs/banco.php';
    
        try {
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($email, $password));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Banco::desconectar();
    
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
            // REDIRECT TO LOGIN AND PASS ERROR
            // header("Location: login.php");
            // exit;
        }
    
        if($data) {
            // session_destroy();
            // session_start();
            $_SESSION["id"] = $data["id"];
            $_SESSION["nome"] = $data["nome"];
            $_SESSION["email"] = $data["email"];
            $_SESSION["senha"] = $data["senha"];
            $_SESSION["logged_in"] = true;
            header("Location: index.php");
            exit;
        } else {
            $errorMessage = "Email ou senha incorretos";
            $warningBallon = '<div class="alert alert-warning" role="alert">
            ' . $errorMessage . '
            </div>';
            // header("Location: login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Vault - Login</title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <form class="form-group" action="login.php" method="post">
            <?php
                echo $warningBallon;
            ?>
            <h1>Login</h1>
            <div class="jumbotron">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input class="form-control" name="email" type="email" placeholder="Email" autocomplete="nope">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input class="form-control" name="password" type="password" placeholder="Password" autocomplete="new-password">
                </div>
                <a href="#" class="link">Forgot Your Password?</a>
                <br>
                <br>
                <div class="form-group">
                    <button class="btn btn-primary">Sign in</button>
                    <button class="btn btn-secondary disabled" disabled>Register</button>
                </div>
            </div>
        </form>
    </div>
    <footer>
        <div class="container d-flex justify-content-center">
            <span class="text-muted">File Vault - By Gabriel Gollo - 2023</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>