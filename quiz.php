<?php
include_once 'header.php';

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

    $q     = mysqli_query($link, "SELECT * FROM questions WHERE eid='$eid' ORDER BY id ASC");

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
    $questions = mysqli_query($link, "SELECT * FROM questions WHERE eid='$eid' ORDER BY id ASC");

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