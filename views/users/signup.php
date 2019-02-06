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

                    <h1 class="Center-card-title">Create Account</h1>
                    <hr>

                    <?= !empty($_SESSION['create_acc_msg']) ? $_SESSION['create_acc_msg'] : '';

                    ?>


                    <form action="/users/add.php" method="post">

                        <input class="form-control center-card-form-input" type="email" name="email" value="" placeholder="Email" required>

                        <label id="username-label" class="red-txt" for="username">Username</label>
                        <input class="form-control center-card-form-input" type="text" name="username" value="" placeholder="What should we call you?" required>

                        <a class="password-reference" href="https://xkcd.com/936/">How to make a strong password</a>

                        <input id="password" class="form-control center-card-form-input" type="password" name="password" value="" placeholder="Password" required>
                        <input id="passwordConfirm" class="form-control center-card-form-input" type="password" name="" value="" placeholder="Re-type password" >


                        <input id="btnSubmit" class="btn btn-red signup-btn" type="submit" name="sign-up" value="Sign Up">

                    </form>

                </div><!--.card-->

            </div><!--.card-body-->


        </div>


    </div>
</div><!--background-->
