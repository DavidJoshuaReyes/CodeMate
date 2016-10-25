<?php

    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="An University application to improve the efficeincy of teacher-student test taking">

        <title>Instructor</title>

        <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="../css/animate.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/skeleton.css">

    </head>
    <body>

        <div class="navigation">
            <div class="container">
                <div class="row">
                    <!-- <a href="#" class="header-link">Home</a> -->
                    <a href="../logout.php" class="header-link u-pull-right">Log Out</a>
                </div>
            </div>
        </div>

        <div class="section animated fadeIn">
            <div class="container">
                <div class="row">

                    <h1 class="splash-head">Welcome <?php echo $_SESSION['user'];?></h1>
                    <p class="splash-subhead">
                        Please select the appropriate action...
                    </p>

                </div>

                <div class="row">
                  <p class="offset-by-four four columns"><a href="addQuestion.php" class="button button-primary u-full-width">Create a question</a></p>
                </div>
                <div class="row">
                  <p class="offset-by-four four columns"><a href="addTest.php" class="button button-primary u-full-width">Create a test</a></p>
                </div>
                <div class="row">
                  <p class="offset-by-four four columns"><a href="gradeTest.php" class="button button-primary u-full-width">Grade a test</a></p>
                </div>
            </div>
        </div>


        <script type="text/javascript" src="../js/main.js"></script>
    </body>
</html>
