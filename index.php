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

    <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #373737;">
        <div class="navbar-collapse collapse w-100 ml-auto d-flex align-items-center" id="collapsingNavbar3">
        <ul class="navbar-nav w-100 justify-content-start">
                <li class="nav-item">
                    <a href="index.php" class="logo navbar-brand p-0"><img src="img/Qlogo.png" width="80" height="80" alt="Quizzical"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                </li>
            </ul>
            <ul class="navbar-nav w-100 justify-content-center">
                <li class="nav-item">
                    <a class="nav-link text-white" href="about.php">About</a>
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
        <h1 class="display-2 text-white"><b>Quizzical</b></h1>
        <p class="text-black"><b>open platform web-based tool to allow users to learn through the ability to create and take quizzes</b></p>
        <p><a href="register.php" target="_blank" class="btn btn-success btn-lg btn-outline-dark">Sign Up Today</a></p>
    </div>

    <div class="container">
        <div class="row">

        <?php
        $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY views DESC LIMIT 4") or die('Error');

        while ($row = mysqli_fetch_array($result)) {

            echo'
                <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">' . $row['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="quiz.php?page=quiz&eid=' . $row['eid'] . '" class="text-white">Take Quiz</a>
                    </div>
                </div>
                </div>
            ';
        
        }
        ?>

        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">

        <?php
        $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY date DESC LIMIT 4") or die('Error');

        while ($row = mysqli_fetch_array($result)) {

            echo'
                <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">New
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">' . $row['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="quiz.php?page=quiz&eid=' . $row['eid'] . '" class="text-white">Take Quiz</a>
                    </div>
                </div>
                </div>
            ';
        
        }
        ?>

        </div>
    </div>

</body>
</html>