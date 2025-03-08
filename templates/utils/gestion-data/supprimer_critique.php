<?php 

session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_critique'])) {
    $id_critique = intval($_POST['id_critique']);
    $result = DBConnector::deleteCritique($id_critique);
    if ($result) {
        if (UserTools::isAdmin()) {
            header('Location: ../../avis-admin.php?success=1');
        } else {
            header('Location: ../../mescritiques.php?success=1');
        }
    } else {
        if (UserTools::isAdmin()) {
            header('Location: ../../avis-admin.php?error=1');
        } else {
            header('Location: ../../mescritiques.php?error=1');
        }
    }
}

?>