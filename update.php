<?php
include_once 'config.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (isset($_SESSION["loggedin"])) {
    if (@$_GET['page'] == 'addquiz') {
        $id      = uniqid();
        $owner   = $_SESSION["username"];
        $name    = $_POST['name'];
        $name    = ucwords(strtolower($name));
        $description = $_POST['description'];
        $views   = (int)0;
        $total   = $_POST['total'];
        $time    = 5;

        mysqli_query($link, "INSERT INTO quiz VALUES (NULL,'$id','$owner','$name','$description','$views','$total','$time',NULL)") or die();
        
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

if (isset($_SESSION['loggedin'])) {
    if (@$_GET['page'] == 'addqns') {
        $n   = @$_GET['n'];
        $eid = @$_GET['eid'];
        $ch  = @$_GET['ch'];

        for ($i = 1; $i <= $n; $i++) {
            $qid  = uniqid();
            $qns  = addslashes($_POST['qns' . $i]);
            $q3   = mysqli_query($link, "INSERT INTO questions VALUES (NULL,'$eid','$qid','$qns','$ch','$i')") or die();
            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $a    = addslashes($_POST[$i . '1']);
            $b    = addslashes($_POST[$i . '2']);
            $c    = addslashes($_POST[$i . '3']);
            $d    = addslashes($_POST[$i . '4']);
            $qa = mysqli_query($link, "INSERT INTO options VALUES (NULL,'$qid','$a','$oaid')") or die('Error61');
            $qb = mysqli_query($link, "INSERT INTO options VALUES (NULL,'$qid','$b','$obid')") or die('Error62');
            $qb = mysqli_query($link, "INSERT INTO options VALUES (NULL,'$qid','$c','$ocid')") or die('Error63'.mysqli_error($link));
            $qd = mysqli_query($link, "INSERT INTO options VALUES (NULL,'$qid','$d','$odid')") or die('Error64');
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
            
            $qans = mysqli_query($link, "INSERT INTO answer VALUES(NULL,'$qid','$ansid')");

        }
        header("location:welcome.php?page=1");
    }
}
?>