<?php 
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\Restaurant_render;

$dernier_restaurant = DBConnector::getLatestRestaurant($_SESSION['user']['username']);
$dernier_restau_render = new Restaurant_render([$dernier_restaurant]);
$categories = DBConnector::getAllType();
link_to_css('static/index_connected.css');
link_to_js('static/js/boutons-bar.js');

$all_types = DBconnector::getAllType();
?><div class="container">
<div class="last-review">
    <?php if($dernier_restaurant == null){?>
        <h2>Vous n'avez pas encore testé de restaurant ? <a href="decouverte.php">Faites des découvertes !</a></h2>
        <?php } else{ $dernier_restau_render->iconRestaurant(false);}?>
</div>

<div class="search-section">
    <div class="search-bar">
    <input type="text" id="searchBar" placeholder="Rechercher un restaurant..." autocomplete="off">
        <button><a href="decouverte.php">Rechercher</a></button>
    </div>

    <div class="filters">
    

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
    </div>
    </div>      
   <h3 id="decouverte">Pas d'idées ? <a href="decouverte.php">Faites des découvertes !</a></h3>

