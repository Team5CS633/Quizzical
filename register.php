<?php
include_once 'header.php';

if ($_SESSION["loggedin"] || $_SESSION["loggedin"]) {
    header("location: welcome.php?page=1");
}
 
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
                                    <p>Trouble signing in instead?<br>Click <a class="text-white" href="#" data-toggle="popover" data-trigger="focus" title="Feature Unavailable" data-content="Our engineers are still working on this feature; it will be available in the near future."><u>here</u></a>.</p>
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