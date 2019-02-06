<?php  require_once("../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../elements/html_head.php");
    require_once("../elements/nav.php");


?>

<div class="chalkboard">
    <div class="container">

        <div class="row full-width" id="sotm-background">
            <div class="col-md-7 card-body-center" >
                <div id="sotm" class="card">

                    <div class="row">

                        <div class="col-lg-7">
                            <div class="sotm-picture">

                            </div>
                        </div>

                        <div class="col-lg-5">

                            <div class="padding-15">
                                <h4 class="red-txt">Sandwich of the Month</h4>
                                <h2 class="red-txt">Sanzese panini</h2>

                                <p class="black-txt">Capicola, Pepperoni, Soppressata, Provolone and Peppers</p>
                            </div>


                        </div>

                    </div><!--.row-->

                </div>
            </div>
        </div><!--.row-->


        <div class="index-divider full-width bg-red"></div>

        <div id="sandwich-bar" class="row bg-white">

                <div class="col-md-3">

                    <a class="btn btn-red" href="/sandwiches/">Add Sandwich</a>

                </div>

                <div id="sandwich-select" class="col-md-6">

                    <h1 class="red-txt">Sandwiches</h1>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <h4 class="red-txt"></h4>
                        </div>
                        <div class="col-4">
                            <h4 class="black-txt"></h4>
                        </div>
                        <div class="col-4">
                            <h4 class="black-txt"></h4>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <form id="search-form" class="search" action="index.php" method="post">
                        <input id="search-input" class="form-control btn-white" type="text" name="search" placeholder="Find Sandwiches">
                    </form>

                </div>

        </div><!--.row-->

            <div class="row" id="sandwich-feed">

                <!-- auto loaded by infinite sandwich js function -->
            </div><!--.row-->




        <div class="text-center">
            <img class="loading-bars" src="/assets/files/23.gif">
        </div>

    </div><!-- .container -->
</div><!--.chalkboard-->


<?php require_once("../elements/footer.php");
