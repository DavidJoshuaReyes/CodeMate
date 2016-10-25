<?php

    session_start();
    include('header.php');

?>
    <div id="logInStatus" hidden><?php echo $_SESSION['loggedin'];?></div>
    <div id="anotherone" hidden><?php echo $_SESSION['response'];?></div>

    <div class="login animated fadeIn">
        <div class="container">
            <div class="row u-pull-center">

                <form class="login-form" action="https://web.njit.edu/~sv389/backOfFront/frontlogin.php"  method="POST" accept-charset='UTF-8'>
                    <div class= "row">
                    <div class="offset-by-four four columns ">
                        <label for="username" class="u-pull-left">Username</label>
                        <input class="u-full-width" type="text" name="username" placeholder="Username"/>
                        </div>
                    </div>

                    <div class= "row">
                        <div class="offset-by-four four columns ">
                            <label for="password" class="u-pull-left">Password</label>
                            <input class="u-full-width" type="password" name="password" placeholder="Password"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-by-four four columns">
                            <span id="status" class="animate fadeIn" style="color: red;" ></span>
                            <input class="button button-primary u-full-width " type="submit" value="Log In" >
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>


    <script type="text/javascript" src="js/functions.js"></script>
    <script type="text/javascript">
        checkLoginStatus();
    </script>

<?php

    include('footer.php');
    session_destroy();

?>
