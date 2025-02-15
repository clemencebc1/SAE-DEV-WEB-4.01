<?php
session_start();
require('../../autoloader.php');
Autoloader::register();
use classes\provider\DataLoaderJson;
use utils\connection\DBConnector;


function redirect($url) {
    header('Location: '.$url);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $targetDir = __DIR__ . "/../../data/"; 
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($_FILES["file"]["size"] > 500000) {
        $uploadOk = 0;
    }

    if (!in_array($fileType, ["json"])) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        redirect('../../ajout-json.php?upload=error');
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["file"]["name"])) . " a été téléchargé avec succès.";
            $loader = new DataLoaderJson($targetFile);
            $loader->insertData(DBConnector::getInstance());
            redirect('../../ajout-json.php?upload=success');
        } else {
            redirect('../../ajout-json.php?upload=error');

        }
    }
} else {
    redirect('../../ajout-json.php?upload=nofile');
}
?>
