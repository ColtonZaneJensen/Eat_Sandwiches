<?php require_once '../../core/includes.php';

$s = new Sandwich;
$sandwiches = $s->infinite_sandwiches();


echo json_encode($sandwiches);

die();
