<?php
include_once 'config.php';

if (@$_GET['page'] == 'quiz') {

    $eid   = @$_GET['eid'];
    $q     = mysqli_query($link, "SELECT * FROM questions WHERE eid='$eid' ");

    echo '
        <div class="panel" style="margin-right:5%;margin-left:5%;margin-top:10px;border-radius:10px">
        <form id="qform" action="update.php?page=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal">
        <br />
    ';

    while ($row = mysqli_fetch_array($q)) {
        $qns = stripslashes($row['qns']);
        $qid = $row['qid'];
        $sn = $row['sn'];

        echo '
            <b><pre style="background-color:white"><div style="font-size:20px;font-weight:bold;font-family:calibri;margin:10px">' . $sn . ' : ' . $qns . '</div></pre></b>
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
                    <label for="' . $optionid . '" style="width:50%">
                    <div style="color:black;font-size:12px;word-wrap:break-word">&nbsp;&nbsp;' . $option . '
                    </div>
                    </label>
                </div>
            ';
        }

        echo '
            </div>
        ';
        
    }
 
    echo '
        <br>
        <button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px">
        <span class="glyphicon glyphicon-lock" style="font-size:12px" aria-hidden="true"></span>
        <font style="font-size:12px;font-weight:bold">Submit<font>
        </button>
        <a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn + 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px">
        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"  style="font-size:12px"></span>
        </a></form>
        </div>
    ';

}

?>