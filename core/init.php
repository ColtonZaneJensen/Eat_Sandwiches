<?php
// For functionality like checking if a user is an admin before page is loaded
date_default_timezone_set('America/Vancouver');

if( empty($_SESSION['user_logged_in']) ){ // if not logged in


    // Allowed logged out functionality
    $allowed_urls = array(
        '/',
        '/users/login.php',
        '/users/add.php',
        '/users/signup.php',
        '/users/login-page.php',
        '/sandwiches/search.php',
        '/sandwiches/infinite-sandwiches.php'
    );

    $allowed = false;

    foreach($allowed_urls as $allowed_url){

        if( $_SERVER['REQUEST_URI'] == $allowed_url ){
            $allowed = true;
            break;
        }
    }

    if( $allowed === false ){
        header("Location: /users/signup.php");
        exit();
    }


}else{ // User is logged in

    // Set user's Timezone
    $u = new User;
    $user = $u->get_by_id($_SESSION['user_logged_in']);


}
