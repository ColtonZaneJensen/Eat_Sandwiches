<div class="text-center">
    <a href="/">
        <img id="logoHead" src="/graphics/EatSandwichesLogo.png" alt="Eat Sandwiches Logo">

    </a>
</div>


<nav class="navbar navbar-light bg-red">

  <a class="navbar-brand" href="/hotdog.php">Is a hotdog a sandwich?</a>

  <?php
        //check if user is logged in. Show welcome links
            $u = new User;

            if( $_SESSION['user_logged_in'] ){

                $user = $u->get_by_id($_SESSION['user_logged_in']);

                ?>

                <div class="align-right">
                    <a class="btn btn-white" href="/users/submitted.php"><i class="fas fa-user"></i></a>
                    <a class="btn btn-red" href="/users/logout.php">log Out</a>
                </div>

                <?php }else{ //user not logged in. ?>

                  <div class="align-right">
                      <a class="btn btn-white" href="/users/signup.php">Join Us</a>
                      <a class="btn btn-red" href="/users/login-page.php">login</a>
                  </div>

                <?php } ?>



</nav>
