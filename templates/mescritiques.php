<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\CritiqueRender;
UserTools::requireLogin();
?>

<!DOCTYPE html>
<html lang="fr">
<?php
include('global/head.php'); 
title_html('Connected');
link_to_css('static/index_connected.css');
?>
<body>
        <?php include('global/header_connected.php'); ?>
        <main>
            <h1>Vos dernières critiques gastronomiques</h1>
            <?php
            $critiques = DBConnector::getCritiquesByUser($_SESSION['user']['username']);
            var_dump(($critiques));
            $render = new CritiqueRender($critiques);
            $render->render();
            ?>
        
        </main>

        <?php include('global/footer.php'); ?>
    </body>
</html>