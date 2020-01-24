<?php
    // Database Settings
    define('DB_SERVER', 'sql207.epizy.com');
    define('DB_USERNAME', 'epiz_25095131');
    define('DB_PASSWORD', '9xlV1yCLr6psnG');
    define('DB_NAME', 'epiz_25095131_quizzical');
 
    // Connect to MySQL database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
    // Check connection
    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>