<?php 

session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_critique'])) {
    $id_critique = intval($_POST['id_critique']);
    $result = DBConnector::deleteCritique($id_critique);
    if ($result) {
        header('Location: ../../mescritiques.php?success=1');
    } else {
        header('Location: ../../mescritiques.php?error=1');
    }
}

?>