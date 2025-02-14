<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBconnector;
use utils\connection\UserTools;
use classes\model\Departement;
use classes\model\Restaurant;
use classes\model\Critique;
use utils\render\Restaurant_render;


$restaurants = [];
if (!(empty($_GET["search"]))) {
    $restaurants = [];
    $byType = DBconnector::searchRestaurantByType($_GET["search"]);
    $byName = DBconnector::searchRestaurantByName($_GET["search"]);
    $byCity = DBconnector::searchRestaurantByCity($_GET["search"]);
    $restaurants = array_merge($byName, $byType, $byCity);
}

(empty($_GET["search"])) ? $restaurants = DBconnector::getAllRestaurants() : null;
$render = new Restaurant_render($restaurants);
?>

<!DOCTYPE html>
<html lang="fr">
<?php 
include 'interfaces-role/global/head.php'; 
title_html('Connexion');

?>
<body>
    <?php include('interfaces-role/global/header.php') ?>
    <main>
        <section>
            <div class="titles-container">
                <h1>Découvrir des restaurants</h1>
                <h2>selon vos envies</h2>
            </div>
            <div id="search-container">
                    <form action="" method="get">
                    <input type="text" name="search" id="search" placeholder="Ville, Restaurant, type de cuisine..">
                    <button type="submit">Rechercher</button>
                </form>
            </div>
        </section>
        <section>
        <div class="titles-container">
                <h1>Pas d’idées ? </h1>
                <h2>Nos suggestions du moment</h2>
                <h2>Cuisine simpliste </h2>
            </div>
        </section>
        <section>
            <?php
            // $restaurants = Restaurant_render::renderAllRestaurants();
            // $Dbrestaurants = DBconnector::getAllRestaurants();

            // echo '<pre>';
            // var_dump($restaurants);
            // echo '</pre>';
            echo $render->decouvrir();
            ?>
        </section>
    </main>
    
</body>
</html>
