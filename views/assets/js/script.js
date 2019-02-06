var sandwichDataStart = 0;
var sandwichDataLimit = 3;
var reachedMax = false;
var loadingInfinite = false;

$(document).ready(function(){
        getMoreSandwichData();

       $('#fillDetails').click( function(){
           $('#ingredients-fields-wrapper').append('<div class="ingredient-wrapper"><input class="form-control center-card-form-input" type="text" name="ingredients[]" placeholder="Type one ingredient here" required> <i class="fas fa-minus-square red-txt delete-ingriedent-field"></i></div>');
       });

       $(document).on('click', '.delete-ingriedent-field', function(){
           $(this).closest('.ingredient-wrapper').remove();
       });

       $('#search-form').submit(function(event){
            event.preventDefault();
        });

        $('#search-input').keyup(function(){

            var searchData = $('#search-input').val();
            $.post('/sandwiches/search.php', {"search":searchData}, function(data){
                console.log(data);

                $('#sandwich-feed').html('');
                var sandwiches = JSON.parse(data);

                var sandwichesHTML = '';

                $.each(sandwiches, function(key, sandwich){
                    sandwichesHTML += '<div class="col-lg-4">';

                        sandwichesHTML += '<div class="card" data-sandwichID="'+sandwich.id+'">';


                            sandwichesHTML += '<!-- modal trigger -->';
                            sandwichesHTML += '<button class="sandwich-modal-button" type="button" data-toggle="modal" data-target="#sandwich-modal-'+sandwich.id+'" >';
                                sandwichesHTML += '<div class="sandwich-pic">';
                                      sandwichesHTML += '<img class="img-fluid" src="/assets/files/'+sandwich.filename+'" alt="Sandiwch" >';
                                      sandwichesHTML += '<div class="desc">'+sandwich.name+'</div>';
                                sandwichesHTML += '</div>';
                            sandwichesHTML += '</button>';

                            sandwichesHTML += '<!-- modal -->';

                            sandwichesHTML += '<div class="modal fade" id="sandwich-modal-'+sandwich.id+'" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';

                                sandwichesHTML += '<div class="modal-dialog" role="document">';

                                    sandwichesHTML += '<div class="modal-content">';

                                        sandwichesHTML += '<div class="modal-body">';

                                            sandwichesHTML += '<img class="img-fluid" src="/assets/files/'+sandwich.filename+'" alt="Sandiwch">';

                                        sandwichesHTML += '</div>';


                                    sandwichesHTML += '</div>';
                                sandwichesHTML += '</div>';


                            sandwichesHTML += '</div>';

                            var love_class = 'black-txt';

                            if( sandwich.love_id ) { //They loved it
                                love_class = 'red-txt';
                            }

                            sandwichesHTML += '<div class="row">';

                                sandwichesHTML += '<div class="col-1 margin-15">';
                                    sandwichesHTML += '<div class="">';
                                        sandwichesHTML += '<i class="'+love_class+' fas fa-arrow-up love-btn"></i>';
                                        sandwichesHTML += '<span class="loves-count">'+sandwich.love_count+'</span>';
                                    sandwichesHTML += '</div>';
                                sandwichesHTML += '</div>';

                                sandwichesHTML += '<div class="col-10">';
                                    sandwichesHTML += '<h5 class="red-txt padding-15">'+sandwich.name+'</h5>';

                                sandwichesHTML += '</div>';

                            sandwichesHTML += '</div>';
                            sandwichesHTML += '<div class="row recipe-star">';

                                sandwichesHTML += '<div class="col-4">';

                                      sandwichesHTML += '<p>Recipe </p>';

                                sandwichesHTML += '</div>';
                                sandwichesHTML += '<div class="col-8 text-align-right">';

                                if( sandwich.user_owns == 'not_logged_in' ){// user not logged in

                                    sandwichesHTML += '<a href="/users/login-page.php"><i class="far fa-star"></i></a>';

                                }else if(sandwich.user_owns == 'true'){ // logged in and owns sandwich

                                    sandwichesHTML += '<span class="float-right">';
                                        sandwichesHTML += '<a href="/sandwiches/edit.php?id='+sandwich.id+'">';
                                            sandwichesHTML += '<i class="far fa-edit" aria-hidden="true"></i>';
                                        sandwichesHTML += '</a>';
                                        sandwichesHTML += '<a class="delete-btn text-danger" href="/sandwiches/delete.php?id='+sandwich.id+'">';
                                            sandwichesHTML += '<i class="far fa-trash-alt" aria-hidden="true"></i>';
                                        sandwichesHTML += '</a>';
                                    sandwichesHTML += '</span>';
                                }else if(sandwich.user_owns == 'false'){

                                    sandwichesHTML += '<i class="far fa-star"></i>';

                                }


                                sandwichesHTML += '</div>';

                            sandwichesHTML += '</div>';
                            sandwichesHTML += '<div class="dropdown">';

                            sandwichesHTML += '<button data-target="#collapseAdd-'+sandwich.id+'" type="button" data-toggle="collapse" class="btn" aria-expanded="false">';

                                sandwichesHTML += '<i class="fas fa-align-left"></i>';

                            sandwichesHTML += '</button>';

                            sandwichesHTML += '<div id="collapseAdd-'+sandwich.id+'" class="collapse">';
                                sandwichesHTML += '<p class="instructions-p">Bread: '+sandwich.bread_type+'</p>';
                                sandwichesHTML += '<ul>Sandwich Inners:';



                            $.each(sandwich.ingredients, function(key, ingredient){

                                sandwichesHTML += '<li class="ingredient-li">'+ingredient.name+'</li>';

                            });



                             sandwichesHTML += '</ul>';
                             sandwichesHTML += '<hr>';
                                sandwichesHTML += '<p class="instructions-p">Additional information: '+sandwich.instructions+'</p>';


                            sandwichesHTML += '</div>';
                          sandwichesHTML += '</div>';



                        sandwichesHTML += '</div>';

                    sandwichesHTML += '</div>';
                });

                $('#sandwich-feed').html(sandwichesHTML);

            });

        });

    $('#sandwich-feed').on('click', '.love-btn', function(){

        // Components to be updated
        var $love_btn = $(this);
        var $love_btn_text = $love_btn.find('.love-btn-text'); // find goes inside an element
        var $loves_count = $love_btn.closest('.sandwich-post').find('.loves-count'); // find goes inside an element

        // Values
        var sandwich_id = $love_btn.closest('.sandwich-post').attr('data-sandwichID');
        console.log(sandwich_id);

        $.post('/loves/add.php', {"sandwich_id":sandwich_id}, function(love_data){
            console.log(love_data);

            if( love_data.error === false){ // loving worked!
                if( love_data.loved == 'loved' ){
                    $love_btn.removeClass('black-txt').addClass('red-txt');
                    $love_btn_text.text('Loved');
                    $loves_count.text(love_data.love_count);
                }else if (love_data.loved == 'unloved') {
                    $love_btn.removeClass('red-txt').addClass('black-txt');
                    $love_btn_text.text('Love it');
                    $loves_count.text(love_data.love_count);
                }
            };

        });

    });

    $('#sandwich-feed').on('click', '.delete-sandwich-btn', function(){

        var sandwich_id = $(this).attr('data-sandwichID');


        $(this).closest('.sandwich-post').remove();
        $.post('/sandwiches/delete.php', {"sandwich_id":sandwich_id}, function(data){

            console.log(data);



        });

    });

    // Infinite Scroll
    $(window).scroll(function(){
        if( $(window).scrollTop() == $(document).height() - $(window).height() ){
            if( !loadingInfinite ) {
                getMoreSandwichData();
            }

        }
    });


    // confirm password

    // var password = document.getElementById("password")
    // , confirm_password = document.getElementById("confirm_password");
    //
    // function validatePassword(){
    //   if(password.value != confirm_password.value) {
    //     confirm_password.setCustomValidity("Passwords Don't Match");
    //   } else {
    //     confirm_password.setCustomValidity('');
    //   }
    // }
    //
    // password.onchange = validatePassword;
    // confirm_password.onkeyup = validatePassword;






}); // END DOCUMENT READY

function previewFile() {

    var preview = document.getElementById('img-preview');
    var file = document.getElementById('file-with-preview').files[0];

    var reader = new FileReader();

    reader.onloadend = function(){
        preview.src = reader.result;
    }

    if(file) {
        reader.readAsDataURL(file);
    }else{
        preview.src = "";
    }

}



function getMoreSandwichData(){
    if(reachedMax)
        return;

    console.log('start: '+sandwichDataStart);
    console.log('limit: '+sandwichDataLimit);

    $.ajax({
        url: '/sandwiches/infinite-sandwiches.php',
        method: 'POST',
        data: {
            getData: 1,
            start: sandwichDataStart,
            limit: sandwichDataLimit,
        },
        success: function(sandwich_data){
            console.log(sandwich_data);
            sandwich_data = JSON.parse(sandwich_data);
            if(sandwich_data.reachedMax == true){
                reachedMax = true;
                $('.loading-bars').hide();
                $('#sandwich-feed').after('<p class="text-center red-txt">No more results...</p>');
            }else{
                sandwichDataStart += 3;
                // sandwichDataLimit += 3;
                var sandwichesHTML = '';
                var sandwiches = sandwich_data.sandwiches;
                console.log(sandwiches);
                $.each(sandwiches, function(i, sandwich) {

                    sandwichesHTML += '<div class="col-lg-4">';

                        sandwichesHTML += '<div class="card sandwich-post" data-sandwichID="'+sandwich.id+'">';


                            sandwichesHTML += '<!-- modal trigger -->';
                            sandwichesHTML += '<button class="sandwich-modal-button" type="button" data-toggle="modal" data-target="#sandwich-modal-'+sandwich.id+'" >';
                                sandwichesHTML += '<div class="sandwich-pic">';
                                      sandwichesHTML += '<img class="img-fluid" src="/assets/files/'+sandwich.filename+'" alt="Sandiwch" >';
                                      sandwichesHTML += '<div class="desc">'+sandwich.name+'</div>';
                                sandwichesHTML += '</div>';
                            sandwichesHTML += '</button>';

                            sandwichesHTML += '<!-- modal -->';

                            sandwichesHTML += '<div class="modal fade" id="sandwich-modal-'+sandwich.id+'" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';

                                sandwichesHTML += '<div class="modal-dialog" role="document">';

                                    sandwichesHTML += '<div class="modal-content">';

                                        sandwichesHTML += '<div class="modal-body">';

                                            sandwichesHTML += '<img class="img-fluid" src="/assets/files/'+sandwich.filename+'" alt="Sandiwch">';

                                        sandwichesHTML += '</div>';


                                    sandwichesHTML += '</div>';
                                sandwichesHTML += '</div>';


                            sandwichesHTML += '</div>';

                            var love_class = 'black-txt';
                            console.log(sandwich.love_id);
                            if( sandwich.love_id ) { //They loved it
                                love_class = 'red-txt';
                            }

                            sandwichesHTML += '<div class="row">';

                                sandwichesHTML += '<div class="col-1 margin-15">';
                                    sandwichesHTML += '<div class="">';
                                        sandwichesHTML += '<i class="'+love_class+' fas fa-arrow-up love-btn"></i>';
                                        sandwichesHTML += '<span class="loves-count">'+sandwich.love_count+'</span>';
                                    sandwichesHTML += '</div>';
                                sandwichesHTML += '</div>';

                                sandwichesHTML += '<div class="col-10">';
                                    sandwichesHTML += '<h5 class="red-txt padding-15">'+sandwich.name+'</h5>';

                                sandwichesHTML += '</div>';

                            sandwichesHTML += '</div>';
                            sandwichesHTML += '<div class="row recipe-star">';

                                sandwichesHTML += '<div class="col-4">';

                                      sandwichesHTML += '<p>Recipe </p>';

                                sandwichesHTML += '</div>';
                                sandwichesHTML += '<div class="col-8 text-align-right">';

                                if( sandwich.user_owns == 'not_logged_in' ){// user not logged in

                                    sandwichesHTML += '<a href="/users/login-page.php"><i class="far fa-star"></i></a>';

                                }else if(sandwich.user_owns == 'true'){ // logged in and owns sandwich

                                    sandwichesHTML += '<span class="float-right">';
                                        sandwichesHTML += '<a href="/sandwiches/edit.php?id='+sandwich.id+'">';
                                            sandwichesHTML += '<i class="far fa-edit" aria-hidden="true"></i>';
                                        sandwichesHTML += '</a>';
                                        sandwichesHTML += '<a class="delete-btn text-danger" href="/sandwiches/delete.php?id='+sandwich.id+'">';
                                            sandwichesHTML += '<i class="far fa-trash-alt" aria-hidden="true"></i>';
                                        sandwichesHTML += '</a>';
                                    sandwichesHTML += '</span>';
                                }else if(sandwich.user_owns == 'false'){

                                    sandwichesHTML += '<i class="far fa-star"></i>';

                                }


                                sandwichesHTML += '</div>';

                            sandwichesHTML += '</div>';
                            sandwichesHTML += '<div class="dropdown">';

                            sandwichesHTML += '<button data-target="#collapseAdd-'+sandwich.id+'" type="button" data-toggle="collapse" class="btn" aria-expanded="false">';

                                sandwichesHTML += '<i class="fas fa-align-left"></i>';

                            sandwichesHTML += '</button>';

                            sandwichesHTML += '<div id="collapseAdd-'+sandwich.id+'" class="collapse">';
                                sandwichesHTML += '<p class="instructions-p">Bread: '+sandwich.bread_type+'</p>';
                                sandwichesHTML += '<ul>Sandwich Inners:';



                            $.each(sandwich.ingredients, function(key, ingredient){

                                sandwichesHTML += '<li class="ingredient-li">'+ingredient.name+'</li>';

                            });



                             sandwichesHTML += '</ul>';
                             sandwichesHTML += '<hr>';
                                sandwichesHTML += '<p class="instructions-p">Additional information: '+sandwich.instructions+'</p>';


                            sandwichesHTML += '</div>';
                          sandwichesHTML += '</div>';



                        sandwichesHTML += '</div>';

                    sandwichesHTML += '</div>';
                });

                $('#sandwich-feed').append(sandwichesHTML);
            }
        }



    });

}
