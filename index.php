<?php
include_once 'header.php';
?>

    <div class="container-fluid">
    <div class="jumbotron text-center">
        <h1 class="display-2 text-white"><b>Quizzical</b></h1>
        <p class="text-black"><b>open platform web-based tool to allow users to learn through the ability to create and take quizzes</b></p>
        <p><a href="register.php" class="btn btn-success btn-lg btn-outline-dark">Sign Up Today</a></p>
    </div>

    <div class="container">
        <div class="row">

        <?php
        $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY views DESC LIMIT 4") or die('Error');

        while ($row = mysqli_fetch_array($result)) {

            echo'
                <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">' . $row['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="quiz.php?page=quiz&eid=' . $row['eid'] . '" class="text-white">Take Quiz</a>
                    </div>
                </div>
                </div>
            ';
        
        }
        ?>

        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">

        <?php
        $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY date DESC LIMIT 4") or die('Error');

        while ($row = mysqli_fetch_array($result)) {

            echo'
                <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">New
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">' . $row['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="quiz.php?page=quiz&eid=' . $row['eid'] . '" class="text-white">Take Quiz</a>
                    </div>
                </div>
                </div>
            ';
        
        }
        ?>

        </div>
    </div>

</body>
</html>