<?php
session_start();

$APP_WEB_SITE = "FileVault";

// Function to check if the user is logged in
function checkLoggedIn() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // User is not logged in, redirect to login.php
        header("Location: login.php");
        exit;
    } elseif (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        // User is already logged in, no need to redirect
        
        $currentPage = basename($_SERVER['PHP_SELF']);
        $loginPage = 'login.php';
        
        if ($currentPage === $loginPage) {
            // User is already on the login page and logged in, redirect to index.php
            header("Location: index.php");
            exit;
        }
    }
}

// Check if the user is already on the login page
function checkLoginRedirect() {
    $currentPage = basename($_SERVER['PHP_SELF']);
    $loginPage = 'login.php';
    $registerPage = 'register.php';
    if (($currentPage === $loginPage || $currentPage === $registerPage) && (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false)) {
        // User is already on the login page and logged in, no need to redirect
        return;
    }

    checkLoggedIn();
}

// Call the checkLoginRedirect function to handle user authentication and redirection
checkLoginRedirect();
?>
