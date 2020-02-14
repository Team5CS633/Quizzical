<?php
include_once 'config.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizzical - Logged In</title>
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
                    <a class="nav-link text-white" href="welcome.php?page=1">Dashboard</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                <li class="nav-item">
                    <a href="logout.php">
                        <input type="submit" class="btn btn-success btn-outline-dark" value="Log Out">
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <br><br>

    <div class="container-fluid">
    <div class="jumbotron bg-info">

        <?php
        if (@$_GET['page'] == 1 || !(@$_GET['page'])) {

            echo '
                <div class="container-fluid text-center">
                    <h1>Hi, <b>' . $_SESSION["username"] . '</b>!</h1>
                </div>

                <br>

    </div>
    </div>
            ';
            
            echo '
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-3">
                        <div class="card text-white bg-info border-dark mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center">Let\'s get started!</h5>
                                <p class="card-text text-center">What would you like to do?</p>
                                <p class="card-text text-center"><a class="text-white" href="welcome.php?page=2"><u>Create a Quiz</u></a></p>
                                <p class="card-text text-center"><a class="text-white" href="welcome.php?page=3"><u>Take/View Quizzes</u></a></p>
                                <p class="card-text text-center"><a class="text-white" href="#"><u>Search for a Quiz</u></a></p>
                                <p class="card-text text-center"><a class="text-white" href="#"><u>Join a Group</u></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <div class="container border-dark">
                            <img src="img/DashImg.png" class="img-fluid rounded mx-auto d-block" alt="Dashboard Image">
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            ';

        }


        if (@$_GET['page'] == 2 && !(@$_GET['step'])) {
            
            echo ' 
                <div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br><br>
                    <div class="col-md-3"></div><div class="col-md-6">   
                        <form class="form-horizontal title1" name="form" action="update.php?page=addquiz" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name"></label>  
                                    <div class="col-md-12">
                                        <input id="name" name="name" placeholder="Enter quiz title" class="form-control input-md" type="text" required>
                                    </div>
                            </div>
                            <div class="form-group">
                            <label class="col-md-12 control-label" for="description"></label>  
                                <div class="col-md-12">
                                    <input id="description" name="description" placeholder="Description for quiz" class="form-control input-md" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="total"></label>  
                                <div class="col-md-12">
                                    <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="time"></label>  
                                    <div class="col-md-12">
                                        <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number" required>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for=""></label>
                                    <div class="col-md-12"> 
                                        <input type="submit" style="margin-left:45%" class="btn btn-success btn-outline-dark" value="Next">
                                    </div>
                            </div>
                        </fieldset>
                        </form>
                    </div>
            ';                       
        }


        if (@$_GET['page'] == 2 && (@$_GET['step']) == 2) {
   
            echo ' 
                <div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
                    <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <form class="form-horizontal title1" name="form" action="update.php?page=addqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '&ch=4" method="POST">
                            <fieldset>
            ';
                        
            for ($i = 1; $i <= @$_GET['n']; $i++) {
                
                echo '
                    <b>Question number&nbsp;' . $i . '&nbsp;:</><br />
                    <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
                                <div class="col-md-12">
                                    <textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..."></textarea>  
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '1"></label>  
                            <div class="col-md-12">
                                Option A - <input id="' . $i . '1" name="' . $i . '1" placeholder="Enter option a" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '2"></label>  
                            <div class="col-md-12">
                                Option B - <input id="' . $i . '2" name="' . $i . '2" placeholder="Enter option b" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '3"></label>  
                            <div class="col-md-12">
                                Option C - <input id="' . $i . '3" name="' . $i . '3" placeholder="Enter option c" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '4"></label>  
                            <div class="col-md-12">
                                Option D - <input id="' . $i . '4" name="' . $i . '4" placeholder="Enter option d" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <br /><b>Correct answer</b>:<br />
                        <select id="ans' . $i . '" name="ans' . $i . '" placeholder="Choose correct answer " class="form-control input-md" >
                            <option value="a">option a</option>
                            <option value="b">option b</option>
                            <option value="c">option c</option>
                            <option value="d">option d</option>
                        </select><br /><br />
                ';
            }
                        
            echo '
                    <div class="form-group">
                        <label class="col-md-12 control-label" for=""></label>
                        <div class="col-md-12"> 
                            <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                        </div>
                    </div>
                    </fieldset>
                    </form>
                </div>
            ';
                        
        }


        if (@$_GET['page'] == 3) {
    
            $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
            
            echo '
                <div class="panel"><table class="table table-striped title1" style="vertical-align:middle">
                <tr>
                <td style="vertical-align:middle"><b>Name</b></td>
                <td style="vertical-align:middle"><b>Created By</b></td>
                <td style="vertical-align:middle"><b>Total Questions</b></td>
                <td style="vertical-align:middle"><b>Time limit</b></td>
                <td style="vertical-align:middle"><b>Action</b></td>
                </tr>
            ';
            
            $c = 1;
            
            while ($row = mysqli_fetch_array($result)) {
                $title   = $row['title'];
                $owner   = $row['owner'];
                $total   = $row['total'];
                $time    = $row['time'];
                $eid     = $row['eid'];
                            
                echo '
                    <tr>
                    <td style="vertical-align:middle">' . $title . '</td>
                    <td style="vertical-align:middle">' . $owner . '</td>
                    <td style="vertical-align:middle">' . $total . '</td>
                    <td style="vertical-align:middle">' . $time . '&nbsp;min</td>
                    <td style="vertical-align:middle"><b><a href="quiz.php?page=quiz&eid=' . $eid . '" class="btn logb" style="color:#FFFFFF;background:#ff0000;font-size:12px;padding:5px;">&nbsp;<span><b>Take Quiz</b></span></a></b></td>
                    </tr>
                ';
                            
            }
        }
        ?>

    </div>
    </div>

</body>
</html>