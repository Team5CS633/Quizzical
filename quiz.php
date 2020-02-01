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

    <link rel="stylesheet" href="css/quiz.css">

</head>
<body>

<?php
include_once 'config.php';


if (@$_GET['eid']) {

    $eid   = @$_GET['eid'];

    $s          = mysqli_query($link, "SELECT * FROM quiz WHERE eid='$eid' ");
    $sQuiz      = mysqli_fetch_array($s);
    $quizName   = $sQuiz['title'];

    echo '
        <div class="container">
            <div class="text-center">
                <h1>' . $quizName . '</h1>
            </div>
            <br>
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
            <div class="card">
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
                <input type="submit" value="Submit Quiz">
            </div>
            </form>
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
        echo $question . ' - ' . $answer . '<br><br>';
        if ( $answer == $answers[$index] ) {
            $score++;
        }
        $index++;
    }

    /* show score */
    echo '
        Your score is <b>'. $score . '</b> out of <b>' . $index . '</b>!
    ';

}

?>

</body>
</html>