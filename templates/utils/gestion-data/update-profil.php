<?php
session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $password = $_POST['password'];
    $result = DBConnector::updateUser($_SESSION['user']['username'], $nom, $prenom, $password);
    if ($result) {
        header('Location: ../../profil.php?success');
    } else {
        header('Location: ../../profil.php?error');
    }

}

?>