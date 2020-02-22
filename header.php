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
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    echo'
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
                    <a class="nav-link text-white" href="about.php">About</a>
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


    <!-- Feature Unavailable Modal -->
    <div class="modal" id="featureUnavailableModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Feature Unavailable</h4>
                </div>
                <div class="modal-body">
                    <p>Feature Coming Soon.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            
        </div>
    </div>

    <script>
    // Creates and focuses the bootstrap modal
        $(document).ready(function() {
            $('#featureUnavailableModal').modal('hide')
            $('#featureUnavailableModal').focus()
        });
    </script>
    <!-- End Modal -->

    <!-- Register Modal and Timer -->
    <script>
        // Creates and focuses the bootstrap modal
        $(document).ready(function() {
            $("#accountSuccessfulModal").modal('show');
            $('#accountSuccessfulModal').focus()
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