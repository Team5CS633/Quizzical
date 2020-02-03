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
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                                </div>
                                <div class="modal-body">
                                    <p>Account Creation Successful.</p>
                                    <p>Redirecting to login in <span id="countdowntimer">10</span> seconds. Otherwise, click <a href="index.php">here</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                // Redirect to login page
                echo '
                    <meta http-equiv="refresh" content="10;url=index.php" />
                ';
                // header("location: index.php");
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

    <nav class="navbar navbar-expand-md navbar-light" style="background-color: #3D9970;">
        <a href="#" class="navbar-brand">
            <img src="img/Qlogo.png" height="28" alt="Quizzical">
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
            </div>
            <div class="navbar-nav ml-auto">
                <a href="login.php" class="nav-item nav-link">
                    <input type="submit" class="btn btn-info btn-outline-dark" value="Login">
                </a>
                <a href="register.php" class="nav-item nav-link">
                    <input type="submit" class="btn btn-info btn-outline-dark" value="Register">
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="form_bg">
                <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                <h2 class="text-center"><img src="img/Qlogo.png" width="60" height="60"></h2>
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                    <br>
                    <p>Already have an account? <a href="index.php">Login here</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>