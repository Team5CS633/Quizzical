<?php
include_once 'header.php';
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>

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
                                <p class="card-text text-center"><a class="text-white" href="welcome.php?page=3"><u>Take/Share/Delete your Quizzes</u></a></p>
                                <p class="card-text text-center"><a class="text-white" href="#" data-toggle="popover" data-trigger="focus" title="Feature Unavailable" data-content="Our engineers are still working on this feature; it will be available in the near future."><u>Search for a Quiz</u></a></p>
                                <p class="card-text text-center"><a class="text-white" href="#" data-toggle="popover" data-trigger="focus" title="Feature Unavailable" data-content="Our engineers are still working on this feature; it will be available in the near future."><u>Join a Group</u></a></p>
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
                                    <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number" max="10" min="1" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="time"></label>  
                                    <div class="col-md-12">
                                        <input id="time" name="time" placeholder="Time limit feature currently unavailable" class="form-control input-md" min="1" type="number" required disabled>
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
                                    <textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..." required></textarea>  
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '1"></label>  
                            <div class="col-md-12">
                                Option A - <input id="' . $i . '1" name="' . $i . '1" placeholder="Enter option a" class="form-control input-md" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '2"></label>  
                            <div class="col-md-12">
                                Option B - <input id="' . $i . '2" name="' . $i . '2" placeholder="Enter option b" class="form-control input-md" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '3"></label>  
                            <div class="col-md-12">
                                Option C - <input id="' . $i . '3" name="' . $i . '3" placeholder="Enter option c" class="form-control input-md" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '4"></label>  
                            <div class="col-md-12">
                                Option D - <input id="' . $i . '4" name="' . $i . '4" placeholder="Enter option d" class="form-control input-md" type="text" required>
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
    
            $result = mysqli_query($link, "SELECT * FROM quiz WHERE owner='$_SESSION[username]' ORDER BY date DESC") or die('Error');
            
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
                   
                $actual_link = 'http://'.$_SERVER['HTTP_HOST'];

                echo '
                    <tr>
                    <td style="vertical-align:middle">' . $title . '</td>
                    <td style="vertical-align:middle">' . $owner . '</td>
                    <td style="vertical-align:middle">' . $total . '</td>
                    <td style="vertical-align:middle">' . $time . '&nbsp;min</td>
                    <td style="vertical-align:middle">
                        <a href="quiz.php?page=quiz&eid=' . $eid . '" class="btn btn btn-success btn-sm btn-outline-dark">Take Quiz</a>
                        <button type="button" class="btn btn-primary btn-sm btn-outline-dark" data-container="body" data-toggle="popover" data-placement="right" title="Send this link to a friend: " data-content=" '. $actual_link .'/quiz.php?page=quiz&eid=' . $eid . ' ">
                            Share Quiz
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-outline-dark" data-container="body" data-toggle="popover" data-placement="right" title="Are You Sure?" data-content="<a href='. $actual_link .'/update.php?page=deletequiz&eid=' . $eid . '>Yes</a>" data-html="true">
                            Delete Quiz
                        </button>
                    </td>
                    </tr>
                ';
                            
            }
        }
        ?>

    </div>
    </div>

</body>
</html>