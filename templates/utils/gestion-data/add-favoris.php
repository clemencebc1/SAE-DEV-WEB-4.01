<?php

session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;


if (isset($_POST['id'])){
    $restaurant_id = $_POST['id'];
    $username = $_SESSION['user']['username'];
    DBConnector::addFavoris($restaurant_id, $username);
    header('Location: ../../favoris.php');
}

?>