<?php
declare(strict_types=1);
namespace utils\render;
require_once 'autoloader.php';

use utils\render\render;
use utils\render\critiqueRender;
use classes\model\restaurant;
use utils\connection\DBConnector;


class Restaurant_render extends Render {

    function __construct(array $restaurants){
        parent::__construct($restaurants);
    }

    function render(): void {
        $restaurant = $this->objects[0];
        echo"<section class='titre'>";
            echo"<h1>Détails du restaurant <span>". $restaurant->getNom() ."</span></h1>";
        echo"</section>";
        echo"<section class='image_details'>";
            echo"<div class='image'>";
                if ($restaurant->getPhotos()) {
                    echo "<img src='" . $restaurant->getPhotos() . "' alt='Photo de " . $restaurant->getNom() . "'>";
                } else {
                    echo "<p>Aucune image disponible</p>";
                }
            echo"</div>";
            echo"<div class='details_lien'>";
                echo"<div class='details'>";
                    $typeCuisine = $restaurant->getTypeCuisine();
                    echo "<p><strong>Type de cuisine :</strong> " . ($typeCuisine ? $typeCuisine->getCuisine() : "Non renseigné") . "</p>";
                    echo "<p><strong>Inclus : </strong>";
                    $caracteristiques = DBConnector::getCaracteristiquesByRestaurant($restaurant->getId());
                    if (!empty($caracteristiques)) {
                        $count = count($caracteristiques);
                        for ($i = 0; $i < $count; $i++) {
                            echo htmlspecialchars($caracteristiques[$i]->getMessage());
                            // Ajouter une virgule sauf pour le dernier élément
                            if ($i < $count - 1) {
                                echo ", ";
                            }
                        }
                    } else {
                        echo "Non renseigné";
                    }
                    echo "</p>";
                    echo "<p><strong>Nombre d'étoiles :</strong> " . ($restaurant->getNbEtoile() ?? "Non renseigné") . "</p>";
                    echo "<p><strong>Capacité :</strong> " . ($restaurant->getCapacity() ?? "Non renseignée") . "</p>";
                    echo "<p><strong>Adresse :</strong> " . ($restaurant->getAdresse() ? $restaurant->getAdresse() : "Non renseignée") . "</p>";
                    $departement = $restaurant->getDepartement();
                    echo "<p><strong>Département :</strong> " . ($departement ? $departement->getNomdep() : "Non renseigné") . "</p>";
                    $website = $restaurant->getWebsite();
                    if (!empty($website)) {
                        echo "<p><strong>Site web :</strong> <a href='" . htmlspecialchars($website) . "' target='_blank'>" . htmlspecialchars($restaurant->getNom()) . "</a></p>";
                    }
                    if (count($_SESSION['user'])){
                        echo "<div class='coeur_div'>";
                            $favoris = DBConnector::getFavorisByUser($_SESSION['user']['username']);
                            $inFavoris = false;

                            foreach ($favoris as $favori){
                                if ((int) $favori->getId() == (int) $id_restaurant){
                                    $inFavoris = true;
                                    break;
                                }
                            }

                            $action = ($inFavoris) ? 'utils/gestion-data/delete-favoris.php' : 'utils/gestion-data/add-favoris.php';
                            $fill = ($inFavoris) ? 'red' : 'grey';
                            echo "<form method='POST' action='". $action . "' style='display:inline;'>";
                            echo "<input type='hidden' name='id' value='" . $_GET['id'] . "'>";
                            echo "<button type='submit' class='svg-heart-btn'><svg viewBox='0 0 24 24' width='40' height='40' fill='". $fill."'><path d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/></svg></button></form>";
                            echo "</form>";
                        echo "</div>";
                    }
                echo"</div>";
                if (count($_SESSION['user'])){
                    echo "<form method='GET' action='ajouterCritique.php' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $_GET['id'] . "'>";
                    echo "<button type='submit' class='critique_bouton'>Ajouter ma critique</button>";
                    echo "</form>";

                    $voirCritiques = false;
                    if (isset($_GET['voir_critiques']) && $_GET['voir_critiques'] == '1') {
                        $voirCritiques = true;
                    }
                    
                    echo "<form method='GET' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($_GET['id']) . "'>";
                    if (!$voirCritiques) {
                        echo "<button type='submit' class='critique_bouton' name='voir_critiques' value='1'>Voir les critiques de ce restaurant</button>";
                    } else {
                        echo "<button type='submit' class='critique_bouton' name='voir_critiques' value='0'>Masquer les critiques</button>";
                    }
                    echo "</form>";
                    if ($voirCritiques) {
                        echo "<div id='reviews-container'>";
                        $critiques = DBConnector::getCritiqueByRestaurant($_GET['id']);
                        if (empty($critiques)) {
                            echo "<p>Aucune critique disponible pour ce restaurant</p>";
                        } else {
                            $renderCritique = new CritiqueRender($critiques);
                            $renderCritique->render_critiques_restaurant();
                        }
                        echo "</div>";
                    }
                }
                echo "</div>";
            echo "</div>";
        echo"</section>";
    }

    function decouvrir(): void {
        echo "<article class='all-restaurants'>";
        foreach ($this->objects as $restaurant){
            echo "<div class='restaurant'>";
            echo "<h3 class='nom'><a href='restaurant_details.php?id=". $restaurant->getId() . "'>" . $restaurant->getNom() . "</a></h3>";
            $nbetoile = $restaurant->getNbEtoile();
            echo "<div class='etoiles'>";
            for ($i = 0; $i < 5; $i++){
                echo $i < $nbetoile ? "<span class='stars'>★</span>" : "<span class='no-stars'>★</span>";
            }
            echo "</div>";
            $this->addPhotos($restaurant);
            echo "<p class='lieu'>" . $restaurant->getRegion() . "</p>";
            echo "<p class='adresse'>" . $restaurant->getAdresse() . "</p>";
            echo "</div>";
        }
        echo "</article>";
    }

    function iconRestaurant($favoris): void {
        if (empty($this->objects)){
            echo "<h3 id='vide'>Vous n'avez pas encore de restaurants favoris</h3>";
        } else {
            echo "<div class='restaurant-container'>"; 
            foreach($this->objects as $restaurant){
                echo "<div class='restaurant-card'>";
                $result_photo = $restaurant->getPhotos();
                $photo = true;
                if (($result_photo == '' || $result_photo == null) && $favoris){
                    echo "<div class='pas-photo'><p>Il n'y a pas de photos pour ce restaurant</p></div>";
                    $photo = false;
                    echo "<img src='../../img/resto-sans-photo.png' alt='img_restaurant'>";
                } else if ($favoris || $photo){ 
                    echo "<img src='" . $restaurant->getPhotos() . "' alt='img_restaurant'>";
                }
                echo "<div class='restaurant-info'>";
                echo "<p>" . $restaurant->getNom() . "</p>";
                echo "<div class='coeur'><p>Orléans</p></div>";
                echo "</div>";
                if ($favoris){
                    $this->addFavoris($restaurant);
                }
                echo "</div>";
            }
        echo "</div>";
        }
    }

    function addFavoris($restaurant): void {
        echo "<form action='utils/gestion-data/delete-favoris.php' method='POST'>";
        echo "<input type='hidden' name='restaurant_id' value='" . $restaurant->getId() . "'>";
        echo "<button type='submit' name='bouton-fav' class='svg-heart-btn'>";
        echo "<svg viewBox='0 0 24 24' width='40' height='40' fill='red'><path d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/></svg>";
        echo "</button></form>";
    }

    function addPhotos($restaurant): void {
        if (is_array($restaurant->getPhotos())){
            if (count($restaurant->getPhotos()) < 1){
                echo "<h4>Il n'y a pas de photos pour ce restaurant</h4>";
            } else {
                foreach ($restaurant->getPhotos() as $photo){
                    echo "<img src='". $photo . "' alt='img_restaurant'>";
                }
            }
        } else {
            echo "<img src='". $restaurant->getPhotos() . "' alt='img_restaurant'>";
        }
    }

    function moyenne(): void {
        echo "<article class='all-restaurants'>";
        foreach ($this->objects as $restaurant){
            echo "<div class='restaurant'>";
            echo "<h3 class='nom'><a href='restaurant_details.php?id=". $restaurant['id_resto'] . "'>" . $restaurant['nom'] . "</a></h3>";
            $nbetoile = $restaurant['moyenne_etoiles'];
            echo "<div class='etoiles'>";
            for ($i = 0; $i < 5; $i++){
                echo $i < $nbetoile ? "<span class='stars'>★</span>" : "<span class='no-stars'>★</span>";
            }
            echo "<span>(" . $restaurant['nombre_critiques'] . " avis)</span>";
            echo "</div>";
            echo "<p class='adresse'>" . $restaurant['adresse'] . "</p>";
            echo "</div>";
        }
        echo "</article>";
    }
}
