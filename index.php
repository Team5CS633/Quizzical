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

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Featured Tests and Quizzes
                    </div>
                    <div class="card-body">
                        <p class="card-text">Make your own tests and quizzes and take it anytime</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Shared Knowledge
                    </div>
                    <div class="card-body">
                        <p class="card-text">For those that want to share their knowledge, Quizzical is your place</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Improved Skills
                    </div>
                    <div class="card-body">
                        <p class="card-text">Quizzical is your answer for better studying from sunset to sunrise</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Team Studying
                    </div>
                    <div class="card-body">
                        <p class="card-text">For those that want to create your own study group, Quizzical is your place</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Available for Free
                    </div>
                    <div class="card-body">
                        <p class="card-text">Easy to create your account, simply sign up and access your account anytime</p>
                        <br><br><br>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Mobility
                    </div>
                    <div class="card-body">
                        <p class="card-text">Any device, any browser, our website is optimized for any phone or tablet so that you can access all Quizzical features from the browser of any device</p>
                        <br>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">Future Release
                    </div>
                    <div class="card-body">
                        <p class="card-text">Flashcards, Quizzical will make it simple to create your own flashcards, study those of a classmate, or search our archive of millions of flashcard decks from other students</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 18rem;">
                    <div class="card-header">User Comments
                    </div>
                    <div class="card-body">
                        <p class="card-text">Students report that Quizzical meets their needs</p>
                        <br><br><br><br>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <br>

    <h2 class="text-white text-center">Some Featured Quizzes</h2>

    <br>

    <div class="container">

        <?php
        $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY views DESC LIMIT 4") or die('Error');

        while ($row = mysqli_fetch_array($result)) {

            echo'
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 560px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="img/featured.png" class="card-img" alt="Featured">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['title'] . '</h5>
                                <p class="card-text">' . $row['description'] . '</p>
                                <p><a href="quiz.php?page=quiz&eid=' . $row['eid'] . '" class="text-white">Take Quiz</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        
        }
        ?>

    </div>

    <br>

    <h2 class="text-white text-center">Some Newly Created Quizzes</h2>

    <br>

    <div class="container">

        <?php
        $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY date DESC LIMIT 4") or die('Error');

        while ($row = mysqli_fetch_array($result)) {

            echo'
                <div class="card text-white bg-info border-dark shadow-lg mb-3" style="max-width: 560px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="img/new.png" class="card-img" alt="New">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['title'] . '</h5>
                                <p class="card-text">' . $row['description'] . '</p>
                                <p><a href="quiz.php?page=quiz&eid=' . $row['eid'] . '" class="text-white">Take Quiz</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        
        }
        ?>

    </div>

</body>
</html>