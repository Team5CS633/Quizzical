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

<?php
include_once 'config.php';


if (@$_GET['eid']) {

    $eid   = @$_GET['eid'];

    $s          = mysqli_query($link, "SELECT * FROM quiz WHERE eid='$eid' ");
    $sQuiz      = mysqli_fetch_array($s);
    $quizName   = $sQuiz['title'];

    $updatedViews = $sQuiz['views'] + 1;
    mysqli_query($link, "UPDATE quiz SET views='$updatedViews' WHERE eid='$eid' ");

    echo '
        <div class="container-fluid">
        <div class="jumbotron text-center">
            <br><br>
            
            <h1 class="text-white">' . $quizName . '</h1>
        </div>
        </div>
        
        <br>

        <div class="container">
    ';

}


if (@$_GET['page'] == 'quiz' && !(@$_GET['step'])) {

    echo '
            <form action="quiz.php?eid=' . $eid . '" method="POST">
    ';

    $q     = mysqli_query($link, "SELECT * FROM questions WHERE eid='$eid' ");

    $radioCounter = 1;

    while ($row = mysqli_fetch_array($q)) {
        $qns = stripslashes($row['qns']);
        $qid = $row['qid'];
        $sn = $row['sn'];

        echo '
            <div class="card text-white bg-info border-dark">
                <div class="card-header">Question ' . $sn . ' - ' . $qns . '
                </div>
                <div class="card-body">
                    <div class="bloc">
                        <select name="ans' . $radioCounter . '" size="4">
                            <option id="none" value="none" selected hidden>
        ';

        $k = mysqli_query($link, "SELECT * FROM options WHERE qid='$qid' ");

        while ($row = mysqli_fetch_array($k)) {
            $option   = stripslashes($row['option']);
            $optionid = $row['optionid'];

            echo '
                        
                            <option id="' . $optionid . '" value="' . $optionid . '">
                            <label for="' . $optionid . '" style="width:50%">' . $option . '</label>
                        
            ';

        }

        echo '
                        </select>
                    </div>
                </div>
            </div>
            <br>
        ';
        
        $radioCounter++;

    }
 
    echo '
            <div class="text-center">
                <input type="submit" class="btn btn-info btn-outline-dark" value="Submit Quiz">
            </div>
            </form>

            <br><br><br>

        </div>
    ';

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $eid = @$_GET['eid'];

    /* store answers in an array for marking */
    $answers = array();
    $score = 0;
    $index = 0;

    /* select correct answers from db */
    $questions = mysqli_query($link, "SELECT * FROM questions WHERE eid='$eid' ");

    /* populate the answers array */
    while ( $rs = mysqli_fetch_array($questions) ) {
        $questionID = $rs['qid'];
        $correctAnswer = mysqli_query($link, "SELECT * FROM answer WHERE qid='$questionID' ");
        $rs2 = mysqli_fetch_array($correctAnswer);
        $actualAnswer = $rs2['ansid'];
        $answers[] =  $actualAnswer;
    }

    /* mark the answers */
    foreach ( $_POST as $question => $answer ) {
        if ( $answer == $answers[$index] ) {
            $score++;
        }
        $index++;
    }

    $scorePercent = ($score / $index) * 100;

    /* show score */
    echo '
        <div class="align-center">

            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-info" style="width: ' . $scorePercent . '%"></div>
            </div>

            <br>

            Your score is <b>'. $score . '</b> out of <b>' . $index . '</b>!
        </div>
    ';

}

?>

</body>
</html>