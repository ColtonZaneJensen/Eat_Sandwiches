<?php require_once '../../core/includes.php';


    if ( !empty($_POST['sandwich_id']) ){
        $s = new Sandwich;
        $s->delete();
    }


        exit();
