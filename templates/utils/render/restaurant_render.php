<?php
declare(strict_types=1);
namespace utils\render;
require_once 'autoloader.php';

use utils\render\render;
use classes\model\restaurant;
use utils\connection\DBConnector;

class Restaurant_render extends Render {

    function __construct(array $restaurants){
        parent::__construct($restaurants);
    }
    function render(): void{
        $restaurant = $this->objects[0];
        echo"<section class='titre'>";
            echo"<h1>Détails du restaurant ". $restaurant->getNom() ."</h1>";
        echo"</section>";
        echo"<section>";
            echo"<div class='image_nom'>";
                echo"<div class='image'>";
                echo"</div>";
                echo"<div class='nom'>";
                echo"</div>";
            echo"</div>";
            echo"<div class='details_lien'>";
                echo"<div class='details'>";
                    echo"<p>Adresse :". $restaurant->getAdresse() ."</p>";
                    echo"<p>Type de cuisine :". $restaurant->getTypeCuisine() ." </p>";
                    echo"<p>Inclus :</p>";
                    echo"<p>Horaire :</p>";
                    echo"<p>Site web :</p>";
                    echo"<p>Email :</p>";
                    echo"<p>Numéro :</p>";
                echo"</div>";
                echo"<div>";
                    echo"<a href=''>Inscrivez vous dès maintenant pour voir les avis de ce restaurant !</a>";
                echo"</div>";
            echo"</div>";
        echo"</section>";
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

    function iconRestaurant($favoris): void {
        if (empty($this->objects)){
            echo "<h3 id='vide'>Vous n'avez pas encore de restaurants favoris</h3>";
        }
        else {
        foreach($this->objects as $restaurant){;
        echo "<div class='restaurant-card'>";
        echo "<img src='". $restaurant->getPhotos() . "' alt='img_restaurant'>";
        echo "<div class='restaurant-info'>";
        echo "<h3>" . $restaurant->getNom() . "</h3>";
        echo "<div class='coeur'><p>Orléans</p>";
        if ($favoris){
            $this->addFavoris($restaurant);
        }
        echo "</div></div></div>"
        ;}}
    }
    function addFavoris($restaurant):void {
        echo "<form action='utils/gestion-data/delete-favoris.php' method='POST'>";
        echo "<input type='hidden' name='restaurant_id' value='".$restaurant->getId()."'>";
        echo "<button type='submit' name='bouton-fav' class='svg-heart-btn'>";
        echo "<svg viewBox='0 0 24 24' width='40' height='40' fill='white'><path d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/></svg></button></form>";
    }
}