<?php  require_once("../../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../../elements/html_head.php");
    require_once("../../elements/nav.php");

    if( !empty($_GET['id']) ){ // check if user id is in url
    $id = (int)$_GET['id'];
    $user = $u->get_by_id($id);
}
?>

<div class="chalkboard">
    <div class="container">

        <div id="sandwich-bar" class="row bg-white">

        <div class="col-lg-3">

            <?php

            if ( !empty($_SESSION['user_logged_in'])) { ?>

                <div class="dropdown">
                  <button class="dropbtn"><i class="fas fa-ellipsis-v"></i></button>
                  <div class="dropdown-content">
                    <a href="/users/edit.php">Edit User</a>
                  </div>
                </div>

                <?php } ?>


        </div>

        <div id="sandwich-select" class="col-sm-6">

            <h1 class="red-txt"><?=$user['username']?></h1>
            <hr>
            <div class="row">

                <div class="col-lg-6">
                    <a href="/views/users/submitted.php">
                        <h4 class="black-txt">Submitted Sandwiches</h4>
                    </a>
                </div>

                <div class="col-lg-6">
                    <h4 class="red-txt">Saved Sandwiches</h4>
                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <form class="search" action="index.html" method="post">
                <input class="form-control btn-white" type="text" name="search" placeholder="Find Sandwiches">
            </form>

        </div>

</div><!--.row-->
<div class="row">

    <div class="col-4">

        <div class="card">

            <div class="row">

                <div class="col-12">
                    <div class="sandwich-pic">

                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-3">
                    <i class="fas fa-arrow-up red-txt"></i>
                    <p>32</p>
                </div>

                <div class="col-9">
                    <h5 class="red-txt">Frankles</h5>

                </div>

            </div>
            <div class="row recipe-star">

                <div class="col-4">
                    <p>Recipe <i class="fas fa-align-left"></i></p>

                </div>
                <div class="col-8 text-align-right">
                    <i class="far fa-star"></i>
                </div>

            </div>



        </div>

    </div>

    <div class="col-4">
        <div class="card">

            <div class="row">

                <div class="col-12">
                    <div class="sandwich-pic">

                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-3">
                    <i class="fas fa-arrow-up red-txt"></i>
                    <p>32</p>
                </div>

                <div class="col-9">
                    <h5 class="red-txt">Frankles</h5>

                </div>

            </div>
            <div class="row recipe-star">

                <div class="col-4">
                    <p>Recipe <i class="fas fa-align-left"></i></p>

                </div>
                <div class="col-8 text-align-right">
                    <i class="far fa-star"></i>
                </div>

            </div>



        </div>
    </div>

    <div class="col-4">
        <div class="card">

            <div class="row">

                <div class="col-12">
                    <div class="sandwich-pic">

                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-3">
                    <i class="fas fa-arrow-up red-txt"></i>
                    <p>32</p>
                </div>

                <div class="col-9">
                    <h5 class="red-txt">Frankles</h5>

                </div>

            </div>
            <div class="row recipe-star">

                <div class="col-4">
                    <p>Recipe <i class="fas fa-align-left"></i></p>

                </div>
                <div class="col-8 text-align-right">
                    <i class="far fa-star"></i>
                </div>

            </div>



        </div>
    </div>

</div>

</div><!--.container.-->
</div><!--chalkboard-->
