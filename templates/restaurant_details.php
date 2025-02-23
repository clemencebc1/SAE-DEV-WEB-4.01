<?php

use utils\render\CritiqueRender;
session_start();
require_once 'autoloader.php';
Autoloader::register();

use utils\render\restaurant_render;
use function utils\render;
use classes\model\restaurant;

use utils\connection\DBConnector;

?>
<!DOCTYPE html>
<html lang="fr">
<?php include('interfaces-role/global/head.php'); 
title_html('Détails');
link_to_css('static/details.css');?>
<body>
    <?php 
    if (count($_SESSION)==0){
        include('interfaces-role/global/header.php');
     }
     else {
        include('interfaces-role/global/header_connected.php');
     } ?>
    <main>
    <?php
    if (!isset($_GET['id']) || empty($_GET['id'])){
        throw new Exception("aucun restaurant sélectionné");
    }

    $id_restaurant = (int) $_GET['id'];
    $restaurant = DBConnector::getRestaurantById($id_restaurant);

    if (!$restaurant) {
        throw new Exception("restaurant non trouvé");
    }

    $restaurant_render = new Restaurant_render([$restaurant]);
    $restaurant_render->render();

    if (count($_SESSION)>=1){
        $favoris = DBConnector::getFavorisByUser($_SESSION['user']['username']);
        $inFavoris = false;
        foreach ($favoris as $favori){
            if ($favori->getIdRestaurant() == $id_restaurant){
                $inFavoris = true;
            }
        }
        echo "<form method='GET' action='ajouterCritique.php' style='display:inline;'>";
        echo "<input type='hidden' name='id' value='" . $_GET['id'] . "'>";
        echo "<button type='submit' class='critique'>Ajouter ma critique</button>";
        echo "</form>";
        $action = ($inFavoris) ? 'utils/gestion-data/delete-favoris.php' : 'utils/gestion-data/add-favoris.php';
        $fill = ($inFavoris) ? 'red' : 'grey';
        echo "<form method='POST' action='". $action . "' style='display:inline;'>";
        echo "<input type='hidden' name='id' value='" . $_GET['id'] . "'>";
        echo "<button type='submit' class='svg-heart-btn'><svg viewBox='0 0 24 24' width='40' height='40' fill='". $fill."'><path d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/></svg></button></form>";
        echo "</form>";
        $critiques = DBConnector::getCritiqueByRestaurant(intval($_GET['id']));
        $renderCritique = new CritiqueRender($critiques);
        $renderCritique->render_critiques_restaurant();
    }
    ?>
    </main>
    <?php include('interfaces-role/global/footer.php'); ?>
</body>
</html>
