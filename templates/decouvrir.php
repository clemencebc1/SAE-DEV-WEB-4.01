<?php

require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\render\Restaurant_render;
use utils\render\TypeCuisine;

echo "<h1> Pas d'idées ? Nous sommes là pour vous conseiller ! </h1>";
$typeCuisines = DBConnector::getAllType();
foreach($typeCuisines as $typeCuisine){
    $restaurants = DBConnector::getRestaurantByType($typeCuisine->getId());
    if (count($restaurants)>=1){
        echo "<h3>" . $typeCuisine->getCuisine() . "</h3>";
        $render = new Restaurant_render($restaurants);
        $render->decouvrir();
    }
}

?>