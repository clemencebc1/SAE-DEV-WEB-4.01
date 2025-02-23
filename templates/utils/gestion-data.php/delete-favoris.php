<?php

session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;


if (isset($_POST['bouton-fav'])){
    $restaurant_id = $_POST['restaurant_id'];
    $username = $_SESSION['user']['username'];
    DBConnector::deleteFavoris($username, $restaurant_id);
    header('Location: ../../favoris.php');
}

?>