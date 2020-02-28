<?php
include('config.php');

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
    <title>Quizzical</title>
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/main.css">

    <script>
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

<?php
if (isset($_SESSION["loggedin"])) {
    if (@$_GET['page'] == 'addquiz') {
        $id      = uniqid();
        $owner   = $_SESSION["username"];
        $name    = $_POST['name'];
        $name    = ucwords(strtolower($name));
        $name    = mysqli_real_escape_string($link, $name);
        $description = $_POST['description'];
        $description    = mysqli_real_escape_string($link, $description);
        $views   = (int)0;
        $total   = $_POST['total'];
        $time    = $_POST['time'];;

        mysqli_query($link, "INSERT INTO quiz (id, eid, owner, title, description, views, total, time, date) VALUES (NULL,'$id','$owner','$name','$description','$views','$total','$time',NULL)") or die();
        
        header("location: welcome.php?page=2&step=2&eid=$id&n=$total");
    }
}

if (isset($_SESSION["loggedin"])) {
    if (@$_GET['page'] == 'deletequiz') {

        $eid = @$_GET['eid'];
        $row = mysqli_query($link, "SELECT FROM quiz WHERE eid='$eid'");
        $name = $row['owner'];
        $row2 = mysqli_query($link, "SELECT FROM questions WHERE eid='$eid' LIMIT 1");
        $qid = $row2['qid'];

        mysqli_query($link, "DELETE FROM quiz WHERE eid='$eid'");
        mysqli_query($link, "DELETE FROM questions WHERE eid='$eid'");
        mysqli_query($link, "DELETE FROM options WHERE qid='$qid'");
        mysqli_query($link, "DELETE FROM answer WHERE qid='$qid'");
        
        header("location: welcome.php?page=3");
    }
}

if (isset($_SESSION["loggedin"])) {
    if (@$_GET['page'] == 'admindeletequiz') {

        $eid = @$_GET['eid'];
        $row = mysqli_query($link, "SELECT FROM quiz WHERE eid='$eid'");
        $name = $row['owner'];
        $row2 = mysqli_query($link, "SELECT FROM questions WHERE eid='$eid' LIMIT 1");
        $qid = $row2['qid'];

        mysqli_query($link, "DELETE FROM quiz WHERE eid='$eid'");
        mysqli_query($link, "DELETE FROM questions WHERE eid='$eid'");
        mysqli_query($link, "DELETE FROM options WHERE qid='$qid'");
        mysqli_query($link, "DELETE FROM answer WHERE qid='$qid'");
        
        header("location: welcome.php?page=admin");
    }
}

if (isset($_SESSION['loggedin'])) {
    if (@$_GET['page'] == 'addqns') {
        $n   = @$_GET['n'];
        $eid = @$_GET['eid'];
        $ch  = @$_GET['ch'];

        for ($i = 1; $i <= $n; $i++) {
            $qid  = uniqid();
            $qns  = addslashes($_POST['qns' . $i]);

            $q3   = mysqli_query($link, "INSERT INTO questions (id, eid, qid, qns, choice, sn) VALUES (NULL,'$eid','$qid','$qns','$ch','$i')") or die();

            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $a    = addslashes($_POST[$i . '1']);
            $a    = mysqli_real_escape_string($link, $a);
            $b    = addslashes($_POST[$i . '2']);
            $b    = mysqli_real_escape_string($link, $b);
            $c    = addslashes($_POST[$i . '3']);
            $c    = mysqli_real_escape_string($link, $c);
            $d    = addslashes($_POST[$i . '4']);
            $d    = mysqli_real_escape_string($link, $d);

            $qa = mysqli_query($link, "INSERT INTO options (id, qid, option, optionid) VALUES (NULL,'$qid','$a','$oaid')") or die('Error61');
            $qb = mysqli_query($link, "INSERT INTO options (id, qid, option, optionid) VALUES (NULL,'$qid','$b','$obid')") or die('Error62');
            $qb = mysqli_query($link, "INSERT INTO options (id, qid, option, optionid) VALUES (NULL,'$qid','$c','$ocid')") or die('Error63'.mysqli_error($link));
            $qd = mysqli_query($link, "INSERT INTO options (id, qid, option, optionid) VALUES (NULL,'$qid','$d','$odid')") or die('Error64');

            $e = $_POST['ans' . $i];

            switch ($e) {
                case 'a':
                    $ansid = $oaid;
                    break;
                
                case 'b':
                    $ansid = $obid;
                    break;
                
                case 'c':
                    $ansid = $ocid;
                    break;
                
                case 'd':
                    $ansid = $odid;
                    break;
                
                default:
                    $ansid = $oaid;
            }
            
            $qans = mysqli_query($link, "INSERT INTO answer (id, qid, ansid) VALUES (NULL,'$qid','$ansid')");

        }

        echo '
            <div class="quizSuccessfulModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Quiz</h5>
                        </div>
                        <div class="modal-body">
                            <p>Quiz Creation Successful.</p>
                            <p>Redirecting back to the dashboard in <span id="countdowntimer">10</span> seconds. Otherwise, click <a href="welcome.php?page=1">here</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        ';

        echo '
            <meta http-equiv="refresh" content="10;url=welcome.php?page=1" />
        ';

        }
}
?>