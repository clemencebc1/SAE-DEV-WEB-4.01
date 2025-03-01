<?php 
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\Restaurant_render;
$all_carac = DBConnector::getCaracteristique();
$dernier_restaurant = DBConnector::getLatestRestaurant($_SESSION['user']['username']);
$categories = DBConnector::getAllType();
$dernier_restau_render = new Restaurant_render([$dernier_restaurant]);
link_to_js('static/js/boutons-bar.js');
?>

        <div class="container">
        <div class="last-review">
            <h2>Vous avez testé récemment ? <a href="ajouterCritique.php?id=<?= $dernier_restaurant->getId() ?>">Laissez un avis !</a></h2>
            <?php $dernier_restau_render->iconRestaurant(false);?>
        </div>

        <div class="search-section">
            <div class="search-bar">
            <input type="text" id="searchBar" placeholder="Rechercher un restaurant..." autocomplete="off">
                <button>Rechercher</button>
            </div>

            <div class="filters">
                <div class="dropdown">
                    <button class="dropbtn">🍽️ Caractéristique ▼</button>
                    <div class="dropdown-content">
                        <?php 
                        $cpt = count($all_carac);
                        if (count($all_carac)>5){
                            $cpt = 5;
                        }
                        for($i = 0; $i<$cpt;$i++){
                            $restaurant = $all_carac[$i]->getNom();
                            echo "<a href='#' class='restaurant-item' data-restaurant='" . $restaurant . "'>" . $restaurant . "</a>";
                        }?>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropbtn">🥄 Cuisine ▼</button>
                    <div class="dropdown-content">
                    <?php 
                        $cpt = count($categories);
                        if (count($categories)>5){
                            $cpt = 5;
                        }
                    
                        for ($i = 0; $i < $cpt; $i++) {
                            $cuisine = $categories[$i]->getCuisine();
                            echo "<a href='#' class='category-item' data-cuisine='" . $cuisine . "'>" . $cuisine . "</a>";
                        }?>
                    </div>
                </div>

            </div>

            <div id="selected-filters"></div>
            <div id="'restaurant"></div>
        </div>
    </div>
   <h3 id="decouverte">Pas d'idées ? <a href="decouverte.php">Faites des découvertes !</a></h3>

