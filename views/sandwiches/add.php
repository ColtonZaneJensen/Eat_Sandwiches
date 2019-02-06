<?php require_once '../../core/includes.php';

if( !empty($_POST['name']) && !empty($_POST['bread_type']) && !empty($_FILES) && !empty($_POST['ingredients']) ){ // Form was submitted


    // Add new project to db
    $s = new Sandwich;
    $s->add();

}

header("Location: /");
