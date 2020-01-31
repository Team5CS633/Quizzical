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

</head>
<body>

<?php
include_once 'config.php';

if (@$_GET['page'] == 'quiz') {

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

    echo '
            <form id="qform" action="update.php?page=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal">
    ';

    $q     = mysqli_query($link, "SELECT * FROM questions WHERE eid='$eid' ");

    while ($row = mysqli_fetch_array($q)) {
        $qns = stripslashes($row['qns']);
        $qid = $row['qid'];
        $sn = $row['sn'];

        echo '
            <div class="card">
                <div class="card-header">Question ' . $sn . ' - ' . $qns . '
                </div>
                <div class="card-body">
        ';

        echo '
                    <div class="funkyradio">
        ';

        $k = mysqli_query($link, "SELECT * FROM options WHERE qid='$qid' ");

        while ($row = mysqli_fetch_array($k)) {
            $option   = stripslashes($row['option']);
            $optionid = $row['optionid'];

            echo '
                        <div class="funkyradio-success">
                            <input type="radio" id="' . $optionid . '" name="ans" value="' . $optionid . '" onclick="enable()">
                            <label for="' . $optionid . '" style="width:50%">' . $option . '</label>
                        </div>
            ';
        }

        echo '
                    </div>
        ';

        echo '
                </div>
            </div>
            <br>
        ';
        
    }
 
    echo '
            <div class="text-center">
            <button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px">
                <font style="font-size:12px;font-weight:bold">Submit<font>
            </button>
            </form>
            </div>
        </div>

    ';

}

?>

</body>
</html>