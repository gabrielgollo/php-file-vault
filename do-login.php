<?php
    if (!isset($_POST["email"]) || !isset($_POST["password"])) {
        header("Location: login.php");
        exit;
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    echo $email;
    echo $password;
    if($email == '' || $password == '') {
        header("Location: login.php");
        exit;
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
        header("Location: login.php");
        exit;
    }

    if($data) {
        session_start();
        $_SESSION["id"] = $data["id"];
        $_SESSION["nome"] = $data["nome"];
        $_SESSION["email"] = $data["email"];
        $_SESSION["senha"] = $data["senha"];
        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php");
        exit;
    }
?>