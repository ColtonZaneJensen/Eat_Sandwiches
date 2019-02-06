<?php  require_once("../../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../../elements/html_head.php");
    require_once("../../elements/nav.php");

    $u = new User;
    $user = $u->get_by_id($_SESSION['user_logged_in']);





?>

<div class="chalkboard">
    <div class="container">

        <div id="sandwich-bar" class="row bg-white">

        <div class="col-sm-3">
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

                <div class="col-md-6">
                    <h4 class="red-txt">Submitted Sandwiches</h4>
                </div>

            </div>

        </div>

        <div class="col-sm-3">

            <form class="search" action="index.html" method="post">
                <input class="form-control btn-white" type="text" name="search" placeholder="Find Sandwiches">
            </form>

        </div>








</div><!--.container.-->

<div class="row" id="sandwich-feed">

<?php
    $s = new Sandwich;
    $sandwiches = $s->get_by_user_id();






    if ( !empty($sandwiches)) {
        // code...

    foreach($sandwiches as $sandwich){
?>


<div class="col-lg-4">

    <div class="card sandwich-post" data-sandwichID="<?=$sandwich['id']?>">


        <!-- modal trigger -->
        <button class="sandwich-modal-button" type="button" data-toggle="modal" data-target="#sandwich-modal-<?=$sandwich['id']?>" >
            <div class="sandwich-pic">
                      <img class="img-fluid" src="/assets/files/<?=$sandwich['filename']?>" alt="Sandiwch" >
                      <div class="desc"><?=$sandwich['name']?></div>
            </div>
        </button>

        <!-- modal -->

        <div class="modal fade" id="sandwich-modal-<?=$sandwich['id']?>" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-body">

                        <img class="img-fluid" src="/assets/files/<?=$sandwich['filename']?>" alt="Sandiwch">

                    </div>


                </div>
            </div>


        </div>

        <?php
            $love_class = 'black-txt';

            if( !empty($sandwich['love_id']) ){ //They loved it
                $love_class = 'red-txt';
            }
        ?>


        <div class="row">

            <div class="col-1 margin-15">
                <div class="">
                    <i class="<?=$love_class?> fas fa-arrow-up love-btn"></i>
                    <span class="loves-count"><?=$sandwich['love_count']?></span>
                </div>
            </div>


            <div class="col-10">
                <h5 class="red-txt padding-15"><?=$sandwich['name']?></h5>

            </div>


        </div>
        <div class="row recipe-star">

            <div class="col-4">

                <p>Recipe </p>



            </div>
            <div class="col-8 text-align-right">
                <?php
                if( empty($_SESSION['user_logged_in']) ){// user not logged in

                    echo '<a href="/users/login-page.php"><i class="far fa-star"></i></a>';

                }else if($_SESSION['user_logged_in'] == $sandwich['user_id']){ // logged in and owns sandwich

                ?>

                <span class="float-right">
                    <a href="/sandwiches/edit.php?id=<?=$sandwich['id']?>">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
                    <span class="delete-btn delete-sandwich-btn text-danger" data-sandwichID="<?=$sandwich['id']?>">
                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                    </span>
                </span>
            <?php }else{ ?>

                <i class="far fa-star"></i>

            <?php } ?>
            </div>

        </div>

        <div class="dropdown">

        <button data-target="#collapseAdd-<?=$sandwich['id']?>" type="button" data-toggle="collapse" class="btn toggle-recipe-btn" aria-expanded="false">

            <i class="fas fa-align-left"></i>

        </button>

        <div id="collapseAdd-<?=$sandwich['id']?>" class="collapse">
            <p class="instructions-p"><strong>Bread</strong>: <?=$sandwich['bread_type']?></p>
            <ul><strong>Sandwich Inners:</strong>

            <?php

            foreach ($sandwich['ingredients'] as $ingredient) {

                echo '<li class="ingredient-li">'.$ingredient['name'].'</li>';

            }


             ?>
         </ul>
         <hr>
            <p class="instructions-p"><strong>Additional information:</strong> <?=$sandwich['instructions']?></p>


        </div>
      </div>



    </div>

</div>




<?php
}
}else{
    echo "<h2>No submitted subs!</h2>";
}

?>
</div><!--.row-->



</div><!--chalkboard-->
