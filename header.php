<?php
// Initialize the session
session_start();
 
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
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

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
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    echo'
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="welcome.php?page=1">Dashboard</a>
                        </li>
                    ';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="view.php">Quizzes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="about.php">About Us</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto w-100 justify-content-end">

                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    echo'
                        <li class="nav-item">
                            <a href="#" class="nav-item nav-link">
                                <input type="submit" class="btn btn-secondary btn-md disabled" value="' . $_SESSION["username"] . '">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-item nav-link">
                                <input type="submit" class="btn btn-success btn-outline-dark" value="Log Out">
                            </a>
                        </li>
                    ';
                } else {
                    echo'
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
                    ';
                }
                ?>

            </ul>
        </div>
    </nav>

    <br><br>

    <!-- Pop-overs -->
    <script type="text/javascript">  
        $(document).ready(function () {  
            $('[data-toggle="popover"]').popover();  
        });  
    </script>  
    <!-- End Pop-overs -->

    <!-- Register Modal and Timer -->
    <script>
        // Creates and focuses the register bootstrap modal
        $(document).ready(function() {
            $("#accountSuccessfulModal").modal('show');
            $('#accountSuccessfulModal').focus()
        });

        // Creates and focuses the quiz creation bootstrap modal
        $(document).ready(function() {
            $("#quizSuccessfulModal").modal('show');
            $('#quizSuccessfulModal').focus()
        });

        // Countdown timer for redirect after account creation
        var timeleft = 10;
        var downloadTimer = setInterval(function(){
        timeleft--;
        document.getElementById("countdowntimer").textContent = timeleft;
        if(timeleft <= 0)
            clearInterval(downloadTimer);
        },1000);
    </script>
    <!-- End Modal and Timer -->