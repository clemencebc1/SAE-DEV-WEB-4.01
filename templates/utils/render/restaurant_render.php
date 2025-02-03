<?php
declare(strict_types=1);
namespace utils\render;

class Restaurant_render extends Render {

    function __construct(array $restaurants){
        parent::__construct($restaurants);
    }
    function render(): void{
        $restaurant = $_GET['id_restaurant'];
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
                    echo"<p>Origine :". $restaurant->getOrigine() ." </p>";
                    echo"<p>Inclus :". $restaurant->getInclus() ."</p>";
                    echo"<p>Horaire :". $restaurant->getHoraire(). "</p>";
                    echo"<p>Email :". $restaurant->getEmail() ."</p>";
                    echo"<p>Numéro :". $restaurant->getNumero() ."</p>";
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
}

?>