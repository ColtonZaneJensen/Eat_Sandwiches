<?php require_once '../../core/includes.php';


$s = new Sandwich;

$sandwiches = $s->search();

echo json_encode($sandwiches);

exit();
