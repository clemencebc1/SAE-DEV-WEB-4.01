<?php 
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\Restaurant_render;
$all_restaurants = DBConnector::getAllRestaurants();
$dernier_restaurant = DBConnector::getLatestRestaurant($_SESSION['user']['username']);
$categories = DBConnector::getAllType();
$dernier_restau_render = new Restaurant_render([$dernier_restaurant]);
?>
        <div class="container">
        <div class="last-review">
            <h2>Vous avez testé récemment ? <a href="#">Laissez un avis !</a></h2>
            <?php $dernier_restau_render->iconRestaurant(false);?>
        </div>

        <div class="search-section">
            <div class="search-bar">
                <input type="text" id="search" placeholder="Rechercher un restaurant ...">
                <button>Rechercher</button>
            </div>

            <div class="filters">
                <div class="dropdown">
                    <button class="dropbtn">🍽️ Restaurant ▼</button>
                    <div class="dropdown-content">
                        <?php 
                        $cpt = count($all_restaurants);
                        if (count($all_restaurants)>5){
                            $cpt = 5;
                        }
                        for($i = 0; $i<$cpt;$i++){
                         echo "<a href='#'>" . $all_restaurants[$i]->getNom() . "</a>";
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
                    
                        for($i =0; $i<$cpt;$i++){
                         echo "<a href='#'>" . $categories[$i]->getCuisine() . "</a>";
                        }?>
                    </div>
                </div>

            </div>

            <div class="selected-filters">
                <span class="filter-tag">Italien <span class="close">&times;</span></span>
                <span class="filter-tag">Orléans <span class="close">&times;</span></span>
                <span class="filter-tag">Végétarien <span class="close">&times;</span></span>
            </div>
        </div>
    </div>