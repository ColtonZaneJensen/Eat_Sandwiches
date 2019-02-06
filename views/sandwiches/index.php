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

                    <h1 class="Center-card-title">Submit Sandwich</h1>
                    <hr>

                    <div class="width-70">

                        <form action="/sandwiches/add.php" method="post" enctype="multipart/form-data">

                            <img id="img-preview">

                            <div class="form-group">
                                <input class="form-control center-card-form-input" id="file-with-preview" type="file" name="fileToUpload" onchange="previewFile()" required>
                            </div>

                            <input class="form-control center-card-form-input" type="text" name="name" placeholder="Sandwich Name" required>

                            <label class="red-txt" for="bread-type">Bread Type</label>
                            <input class="form-control center-card-form-input" type="text" name="bread_type" placeholder="Type bread here" required>


                            <label class="red-txt" for="">Ingredients  </label> <span id='fillDetails'><i class="fas fa-plus-square red-txt"></i></span>

                            <div id="ingredients-fields-wrapper">
                                <input class="form-control center-card-form-input" type="text" name="ingredients[]" placeholder="Type one ingredient here" required>

                            </div>




                            <label class="red-txt" for="extra instructions">Instructions (Optional)</label>
                            <textarea rows="8" cols="50" class="form-control center-card-form-input extra-instructions" type="text" name="instructions"  placeholder="If there is additional information or specific instructions add it it."></textarea>

                            <input class="btn btn-red signup-btn" type="submit" value="Submit Sandwich">

                        </form>
                    </div><!--.width-70-->

                </div><!--.card-->

            </div><!--.card-body-->

        </div>

    </div>
</div><!--background-->

<?php require_once("../../elements/footer.php");
