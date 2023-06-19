<?php 
    function generateNavbar($activePage = 'home')
    {
        $logoutButton = '<li class="nav-item ml-auto">
                            <a class="nav-link text-danger" href="logout.php">Logout</a>
                         </li>';
        $navbar = '
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container justify-content-end">
                <a class="navbar-brand" href="#">File Vault</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item ' . ($activePage == 'home' ? 'active' : '') . '">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item ' . ($activePage == 'users' ? 'active' : '') . '">
                            <a class="nav-link" href="users.php">Users</a>
                        </li>
                        <li class="nav-item ' . ($activePage == 'about' ? 'active' : '') . '">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        ' . $logoutButton . '
                    </ul>
                </div>
            </div>
        </nav>';
    
        return $navbar;
    }
?>