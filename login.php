<?php
include('header.php');

if ($_SESSION["loggedin"] || $_SESSION["loggedin"]) {
    header("location: welcome.php?page=1");
}
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("Refresh:0; url=welcome.php?page=1");
                            echo "<meta http-equiv=\"refresh\" content=\"0;URL=welcome.php?page=1\">";

                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }

                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
        <p class="text-black"><b>Begin your journey by signing in below!</b></p>
    </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-1">
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
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    <div class="badge"><?php echo $password_err; ?></div>
                                </div>
                                <div class="align-center">
                                    <input type="submit" class="btn btn-success btn-outline-dark" value="Login">
                                </div>
                                    
                                <br>

                                <div class="align-center">
                                    <p>Having trouble logging in?<br>Click <a href="#featureUnavailableModal" class="text-white" data-toggle="modal" data-target="#featureUnavailableModal"><u>here</u></a>.</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark mb-4">
                    <div class="card-body align-center">
                        <p>Don't have an account?</p>
                        <p><a href="register.php" class="btn btn-success btn-lg btn-outline-dark">Register</a></p>
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