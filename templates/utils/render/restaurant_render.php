<?php
declare(strict_types=1);
namespace utils\render;
use model\Restaurant;

class Restaurant_render extends Render {

    function __construct(array $restaurants){
        parent::__construct($restaurants);
    }
    function render(): void{

    }

    function decouvrir(): void {
        echo "<article class='all-restaurants'>";
        foreach ($this->objects as $restaurant){
            echo "<div class='restaurant'>";
            echo "<div><img src='". "appel d'une fonction" ."' alt='img_restaurant'></div>";
            echo "<h3 class='nom'>" . $restaurant->getNom() . "</h3>";
            echo "<p class='lieu'>" . $restaurant->getRegion() . "</p>";
            $nbetoile = $restaurant->getNbEtoile();
            echo "<div class='etoiles'>";
            for ($i = 0; $i<5; $i++){
                if ($i<$nbetoile){
                    echo "<img src='etoile-pleine' alt='a une etoile'>";
                }
                else {
                    echo "<img src='etoile-vide' alt='pas etoile'>";
                }
            }
            echo "</div>";
            echo "</div>";
        }
        echo "</article>";
    }

    function lastestRestaurant(): void {
        $restaurant = $this->objects[0];
        echo "<div class='restaurant-card'>";
        echo "<img src='". $restaurant->getPhotos() . "' alt='img_restaurant'>";
        echo "<div class='restaurant-info'>";
        echo "<h3>" . $restaurant->getNom() . "</h3>";
        echo "<p>Orléans</p>";
        echo "</div></div>";
}
}