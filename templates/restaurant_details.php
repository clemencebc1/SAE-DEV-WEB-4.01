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
        echo "<form method='GET' action='ajouterCritique.php' style='display:inline;'>";
        echo "<input type='hidden' name='id' value='" . $_GET['id'] . "'>";
        echo "<button type='submit' class='seeResto-button'>Ajouter ma critique</button>";
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
