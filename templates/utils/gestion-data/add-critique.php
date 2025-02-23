<?php 

session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_resto'])) {
    $id_critique = DBConnector::maxCritiqueId()+1;
    $nouveau_message = trim($_POST['message']);
    $nouvelle_note = intval($_POST['note'])-1;
    $result = DBConnector::addCritique($_POST['id_resto'], $id_critique, $nouveau_message, $nouvelle_note, $_SESSION['user']['username']);
    if ($result) {
        header('Location: ../../mescritiques.php?success=2');
    } else {
        header('Location: ../../mescritiques.php?error=1');
    }
}

?>