
<?php
    session_start();
    session_destroy();

    include('header.php');

	// print '<script> window.location = "https://cs490-somsai002.c9users.io/logout.php"<script>';
?>


    <div class="section animated fadeIn">
        <div class="container">
            <div class="row">
                <div class="column">
                    <h1 class="goodbye">Good Bye! </h1>
                    <h4>
                          Comeback again soon...
                    </h4>

                </div>
            </div>
        </div>
    </div>
<?php

    include('footer.php');

?>
