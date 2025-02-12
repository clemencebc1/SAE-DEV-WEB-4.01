<?php
session_start();
require('../../autoloader.php');
Autoloader::register();
use utils\connection\UserTools;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $targetDir = __DIR__ . "/../../data/"; 
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($_FILES["file"]["size"] > 500000) {
        echo "fichier trop volumineux";
        $uploadOk = 0;
    }

    if (!in_array($fileType, ["json"])) {
        echo "seulement les fichiers json sont autorisés";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "erreur téléchargement";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["file"]["name"])) . " a été téléchargé avec succès.";
            function redirect($url) {
                header('Location: '.$url);
                die();
            }
            redirect('../../index_connected.php');
        } else {
            echo "erreur téléchargement";
        }
    }
} else {
    echo "pas de fichier sélectionné";
}
?>
