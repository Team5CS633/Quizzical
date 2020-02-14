<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Show MODAL
                echo '
                    <div class="accountSuccessfulModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                                </div>
                                <div class="modal-body">
                                    <p>Account Creation Successful.</p>
                                    <p>Redirecting to login page in <span id="countdowntimer">10</span> seconds. Otherwise, click <a href="login.php">here</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                // Redirect to login page
                echo '
                    <meta http-equiv="refresh" content="10;url=login.php" />
                ';
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizzical - Sign Up</title>
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/main.css">

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
        <p class="text-black"><b>Let's create, share, and learn together!</b></p>
        <p class="text-black"><b>Create an account below to start your journey!</b></p>
    </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark mb-4">
                    <div class="card-body align-center">
                        <p>Already have an account?</p>
                        <p><a href="login.php" class="btn btn-success btn-lg btn-outline-dark">Log In</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark mb-4">
                    <div class="card-body">
                        <div class="form">
                            <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Username" required>
                                    <div class="badge"><?php echo $username_err; ?></div>
                                </div>    
                                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <input data-toggle="tooltip" data-placement="top" type="password" name="password" class="form-control" value="<?php echo $password; ?>" placeholder="Password" required>
                                    <div class="badge"><?php echo $password_err; ?></div>
                                </div>
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password" required>
                                    <div class="badge"><?php echo $confirm_password_err; ?></div>
                                </div>
                                <div class="align-center">
                                    <input type="submit" class="btn btn-success btn-outline-dark" value="Register">
                                </div>

                                <br>

                                <div class="align-center">
                                    <p>Trouble signing in instead?<br>Click <a class="text-white" href="#"><u>here</u></a>.</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="container border-dark">
                    <img src="img/QuizImg.png" class="img-fluid rounded mx-auto d-block" alt="Quiz Image">
                </div>
            </div>
            <div class="col-sm-1">
            </div>
        </div>
    </div>

</body>
</html>