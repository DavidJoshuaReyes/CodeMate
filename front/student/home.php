<?php

    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="An University application to improve the efficeincy of teacher-student test taking">

        <title>Student</title>

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
                    <!-- <a href="../index.php" class="header-link">Home</a> -->
                    <a href="../logout.php" class="header-link u-pull-right">Log Out</a>
                    <!-- <a href="#" class="header-link u-pull-right">About Us</a> -->
                </div>
            </div>
        </div>

        <div class="section animated fadeIn">
            <div class="container">
                <div class="row">

                    <h1 class="splash-head">Welcome <?php echo $_SESSION['user']?></h1>
                    <p class="splash-subhead">
                        Please select the appropriate action...
                    </p>

                </div>

                <div class="row">
                    <p class="offset-by-four four columns"><a href="takeTest.php" class="u-full-width button">Take a Test</a></p>
                </div>
                <div class="row">
                    <p class="offset-by-four four columns"><a href="feedback.php" class="u-full-width button">View Feedback</a></p>
                </div>

            </div>
        </div>


        <script type="text/javascript" src="../js/main.js"></script>
    </body>
</html>
