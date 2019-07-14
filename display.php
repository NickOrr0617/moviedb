<?php
date_default_timezone_set('America/Boise');
set_include_path(
    realpath('lib'). PATH_SEPARATOR . 
    realpath('M') . PATH_SEPARATOR .
    realpath('V') . PATH_SEPARATOR .
    realpath('C') . PATH_SEPARATOR .
    get_include_path());

require_once 'movieController.php';

$controller = new movieController();
$controller->showMovies();

?>
