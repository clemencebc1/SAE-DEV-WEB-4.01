<?php
session_start();
require_once '../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
$subscribe = DBConnector::subscribe($_POST['email'],$_POST['password'], $_POST['name'], $_POST['prenom']);
if ($subscribe) {
    $login = UserTools::login($_POST['email'], $_POST['password']);
    header('Location: ../../index.php');
} else {
    $_GET['error'] = true;
    header('Location: ../../inscription.php');
}
session_start();
$status = UserTools::isLogged();


?>