<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizzical</title>
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light" style="background-color: #373737;">
        <div class="navbar-collapse collapse w-100 ml-auto d-flex align-items-center" id="collapsingNavbar3">
        <ul class="navbar-nav w-100 justify-content-start">
                <li class="nav-item">
                    <a href="index.php" class="navbar-brand p-0"><img src="img/Qlogo.png" width="32" height="30" alt="Quizzical"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                </li>
                <li class="nav-item">
                    <p class="text-uppercase" style="font-size: 70%;vertical-align: super;"><sub><b>SHARE STUDY CHALLENGE</b></sub></p>
                </li>
            </ul>
            <ul class="navbar-nav w-100 justify-content-center">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="about.php">About</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                <li class="nav-item">
                    <a href="login.php" class="nav-item nav-link">
                        <input type="submit" class="btn btn-success btn-outline-dark" value="Login">
                    </a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-item nav-link">
                        <input type="submit" class="btn btn-success btn-outline-dark" value="Register">
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <br><br>

    <div class="container-fluid">
    <div class="jumbotron text-center">
        <h1 class="display-2 text-white"><b>About Us</b></h1>
        <p class="lead">Team 5 from course CS 633 at Boston University.</p>
    </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-4">
            <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                <div class="card-header">Project Manager
                </div>
                <div class="card-body">
                    <h5 class="card-title">Jimmy</h5>
                    <p class="card-text">Hi.</p>
                </div>
            </div>
            </div>

            <div class="col-sm-4">
            <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                <div class="card-header">QA and Tester
                </div>
                <div class="card-body">
                    <h5 class="card-title">Sami</h5>
                    <p class="card-text">Hi.</p>
                </div>
            </div>
            </div>

            <div class="col-sm-4">
            <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                <div class="card-header">Developer
                </div>
                <div class="card-body">
                    <h5 class="card-title">Peter</h5>
                    <p class="card-text">Hi.</p>
                </div>
            </div>
            </div>

        </div>
    </div>

</body>
</html>