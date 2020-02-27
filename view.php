<?php
include_once 'header.php';
?>

    <div class="container-fluid">
    <div class="jumbotron text-center">
        <h1 class="display-2 text-white"><b>Quizzes</b></h1>
        <p class="text-black"><b>Here are all the quizzes!</b></p>
    </div>
    </div>

    <div class="container">

            <div class="card text-white bg-info border-dark shadow-lg mb-3">
                <div class="card-header">Quizzes
                </div>
                <div class="card-body">

                    <div id="content">

                        <!-- Alphabets Sort -->
                        <ul class="sort">
                        
                        <?php
                        echo '<li ><a href="view.php" '; 
                        if( !isset($_GET['char']) ){
                        echo ' class="active" ';
                        }
                        echo ' >All Quizzes</a></li>';

                        // Select Alphabets and total records
                        $alpha_sql = "select DISTINCT LEFT(title , 1) as firstCharacter,
                                    ( select count(*) from quiz where LEFT(title , 1)= firstCharacter ) AS counter 
                                    from quiz 
                                    order by title asc";
                        $result_alpha = mysqli_query($link, $alpha_sql);

                        while($row_alpha = mysqli_fetch_array($result_alpha) ) {

                            $firstCharacter = $row_alpha['firstCharacter'];
                            $counter = $row_alpha['counter'];
                        
                            echo '<li ><a href="?char='.$firstCharacter.'" '; 
                            if( isset($_GET['char']) && $firstCharacter == $_GET['char'] ) {
                                echo ' class="active" ';
                            }

                            echo ' >'.$firstCharacter.' ('.$counter.')</a></li>';

                        }
                        ?>

                        </ul>
                        
                        <br><br>

                        <table width="100%" id="userstable" border="1" align="center">
                        <tr class="tr_header">
                            <th class="text-center">Title</th>
                            <th class="text-center">Owner</th>
                            <th class="text-center"># of Questions</th>
                            <th class="text-center">Action</th>
                        </tr>

                        <?php

                        // selecting rows
                        $sql = "SELECT * FROM quiz where 1"; 
                        
                        if( isset($_GET['char']) ) {
                            $sql .= " and LEFT(title,1)='".$_GET['char']."' ";
                        }
                        
                        $sql .=" ORDER BY title ASC";
                        $result = mysqli_query($link, $sql);

                        $sno = 1;
                        
                        while($fetch = mysqli_fetch_array($result)) {
                            $name = $fetch['title'];
                            $username = $fetch['owner'];
                            $total = $fetch['total'];
                            $eid = $fetch['eid'];
                            ?>
                            <tr>
                            <td align='left'><?php echo $name; ?></td>
                            <td align='center'><?php echo $username; ?></td>
                            <td align='center'><?php echo $total; ?></td>
                            <td align='center'>
                                <?php
                                echo '
                                    <a href="quiz.php?page=quiz&eid=' . $eid . '" class="btn btn-success btn-sm btn-outline-dark"><b>Take Quiz</b></a>
                                ';
                                ?>
                            </td>
                            </tr>
                            <?php
                            $sno ++;
                        }

                        ?>
                        </table>

                    </div>

                </div>
            </div>

    </div>

</body>
</html>