<?php
session_start();

$TITLE_GLOBAL = "FileVault";

// Check if the user is already on the login page
function checkLoginRedirect() {
    $currentPage = basename($_SERVER['PHP_SELF']);
    $loginPage = 'login.php';
    $registerPage = 'register.php';
    $isCurrentPageOneOfLoginPage = $currentPage === $loginPage || $currentPage === $registerPage;

    $authenticated = isAuthenticated();
    if($authenticated && $isCurrentPageOneOfLoginPage) {
        // User is already on the login page and logged in, redirect to index.php
        header("Location: index.php");
        exit;
    } elseif ($authenticated && !$isCurrentPageOneOfLoginPage) {
        // User is not logged in and is not on the login page, redirect to login.php
    } else if (!$authenticated && $isCurrentPageOneOfLoginPage) {
        // User is not logged in and is already on the login page, no need to redirect
    } else if (!$authenticated && !$isCurrentPageOneOfLoginPage) {
        // User is not logged in and is not on the login page, redirect to login.php
        header("Location: login.php");
        exit;
    }

}

function isAuthenticated() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}



// Call the checkLoginRedirect function to handle user authentication and redirection
checkLoginRedirect();
?>
