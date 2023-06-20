<?php
include_once 'configs/configs.php';
?>

<?php
    include_once 'utils/navbar.php';
    include_once 'utils/container.php';
    
?>

<?php
    function generateAboutSection($title, $description)
    {
        $aboutSection = '
        <section>
            <h2>' . $title . '</h2>
            <p>' . $description . '</p>
        </section>';
    
        return $aboutSection;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <title><?php echo $TITLE_GLOBAL ?> - About</title>
</head>
<body>
    <?php
    echo generateNavbar("about");
    $title = "About us";
    $description =  'We are a PHP development company dedicated to providing high-quality web solutions.';
    echo generateContainer(generateAboutSection($title, $description));
    ?>
</body>
</html>