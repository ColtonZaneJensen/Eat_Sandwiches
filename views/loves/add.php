<?php require_once '../../core/includes.php';

header('Content-Type: application/json');
$love_data = array(
    'error' => true
);

if( !empty($_POST['sandwich_id']) ){ // project_id socket_sendto

    // Add new love to db

    $l = new Love;
    $love_data = $l->add($love_data);


}

echo json_encode($love_data);

die();
