<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBconnector;
use utils\connection\UserTools;
use model\Restaurant;
use utils\render\Restaurant_render;
use model\critique;

$all_restaurants = DBconnector::getAllRestaurants();
$render = new Restaurant_render($all_restaurants); 
// switch ($_GET["search"]) {
//     // case 'ville':
//     //     $all_restaurants = Restaurant_render::renderAllRestaurantsByCity($_GET["search"]);
//     //     break;
//     // case 'restaurant':
//     //     $all_restaurants = Restaurant_render::renderAllRestaurantsByName($_GET["search"]);
//     //     break;
//     // case 'type':
//     //     $all_restaurants = Restaurant_render::renderAllRestaurantsByType($_GET["search"]);
//     //     break;
//     // default:
//     //     $all_restaurants = Restaurant_render::renderAllRestaurants();
//     //     break;
//     default:
//         $all_restaurants = Restaurant_render::renderAllRestaurants();
//         break;   
// }
?>

<!DOCTYPE html>
<html lang="fr">
<?php 
include 'global/head.php'; 
title_html('Connexion');
// link_to_css('static/connexion.css');
?>
<body>
    <?php include('global/header.php') ?>
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
            // $all_restaurants = Restaurant_render::renderAllRestaurants();
            // $Dbrestaurants = DBconnector::getAllRestaurants();

            echo '<pre>';
            var_dump($all_restaurants);
            echo '</pre>';
            echo $render->decouvrir();
            ?>
        </section>
    </main>
    
</body>
</html>
