<?php  require_once("../../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../../elements/html_head.php");
    require_once("../../elements/nav.php");
?>

<div class="chalkboard">

    <div class="container">


        <div class="col-md-8">

            <div class="card-body card-body-center">

                <div class="card page-center-card">

                    <h1 class="Center-card-title">Log In</h1>
                    <hr>

                    <?php echo $_SESSION['login_attempt_msg']; 


                    ?>

                    <form action="login.php" method="post">

                        <input class="form-control center-card-form-input" type="username" name="username" value="" placeholder="Username" required>

                        <input class="form-control center-card-form-input" type="password" name="password" value="" placeholder="Password" required>
                        <a class="password-reference" href="">Forgot Password?</a>

                        <input class="btn btn-red signup-btn" type="submit" name="login" value="Log In">

                    </form>


                </div><!--.card-->

            </div><!--.card-body-->


        </div>


    </div>
</div><!--background-->
