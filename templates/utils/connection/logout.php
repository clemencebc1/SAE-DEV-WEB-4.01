<?php
session_start();
require_once '../autoloader.php';
Autoloader::register();
use utils\connection\UserTools;
$disconnect = UserTools::logout();
session_destroy();
session_start();
$status = UserTools::isLogged();
if ($status == false) {
    header('Location: connexion.php');
}else {
    echo "Erreur de déconnexion";
}
?>