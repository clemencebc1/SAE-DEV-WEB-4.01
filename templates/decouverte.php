<?php
session_start();
require_once 'utils/autoloader.php';
Autoloader::register();
use utils\connection\DBconnector;
use utils\connection\UserTools;
use model\Restaurant;
use utils\render\Restaurant_render;
use model\critique;

$all_restaurants = [];
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
                <form action="search.php" method="get">
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
            $Dbrestaurants = DBconnector::getAllRestaurants();
            echo '<pre>';
            var_dump($Dbrestaurants);
            echo '</pre>';
            ?>
        </section>
    </main>
    
</body>
</html>
