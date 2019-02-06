<?php  require_once("../../core/includes.php");
    // unique html head vars
    $u = new User;

    if( !empty($_POST) ){ // Form was submitted
        $u->edit();
        header('Location: /users/saved.php');
        exit();
    }

    $user = $u->get_by_id($_SESSION['user_logged_in']);


    $title = 'Edit Profile';
    require_once("../../elements/html_head.php");
    require_once("../../elements/nav.php");





?>
<div class="chalkboard">

    <div class="container">


        <div class="col-md-8">

            <div class="card-body card-body-center">

                <div class="card page-center-card">

                    <h1 class="Center-card-title">Edit Account Information</h1>
                    <hr>

                    <form  method="post">

                        <input class="form-control center-card-form-input" type="email" name="email" value="<?=$email['email']?>" placeholder="Email" >
                        <a class="password-reference" href="https://xkcd.com/936/">How to make a strong password</a>

                        <input class="form-control center-card-form-input" type="password" name="password" value="" placeholder="Password, leave empty to keep same password">
                        <input class="form-control center-card-form-input" type="password" name="" value="" placeholder="Re-type password" >

                        <input class="btn btn-red signup-btn" type="submit" name="sign-up" value="Change">

                    </form>

                </div><!--.card-->

            </div><!--.card-body-->


        </div>


    </div>
</div><!--background-->
