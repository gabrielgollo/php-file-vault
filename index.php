<?php
require_once 'configs/config.global.php';
?>

<?php
include './configs/banco.php';
include './utils/table.php';
include './utils/navbar.php';
include './utils/container.php';
function consult()
{
    $pdo = Banco::conectar();
    $sql = 'SELECT nome, email FROM usuarios';
    $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    // foreach($pdo->query($sql) as $row){
    //     $nome = $row['nome'];
    //     $result .= "
    //         <tr>
    //             <td>{$nome}</td>
    //         </tr>";
    // }
    Banco::desconectar();
    return $result;
}
$teste = consult();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <title>File - Home</title>
</head>

<body>
    <?php
    echo generateNavbar("home");
    $title = "Home";
    $description =  'Welcome to File Vault, a simple file manager. Give a look in the current users';
    $WelcomeHTML = '
    <section>
        <h2>' . $title . '</h2>
        <p>' . $description . '</p>';
    echo generateContainer($WelcomeHTML);
    $table = tablePrint(["Nome", "email"], $teste);
    echo generateContainer($table)
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
 
</html>
