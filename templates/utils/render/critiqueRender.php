<?php 
declare(strict_types=1);
namespace utils\render;

use utils\render\render;


class CritiqueRender extends Render {
    function __construct(array $critiques){
        parent::__construct($critiques);
    }

    /**
     * affiche les critiques d'un utilisateur
     * @return void
     */
    function render(): void{
        echo "<div class='critique-container'>";
        foreach ($this->objects as $critique){
            echo "<div class='critique'>";
            echo "<div>";
            $end = false;
            echo "<span class='stars'>";
            for ($i = 1; $i<6;$i++){
                if ($i>$critique['etoiles']){
                    $end=true;
                    echo "</span>";
                    break;
                } else {
                    echo "★";
                }
            }
            if ($end){
                echo "<span class='no-stars'>";
                for ($i = 0; $i<5-$critique['etoiles'];$i++){
                    echo "★";
                }
                echo "</span>";
            }
            echo "</div>"; 
            echo "<h2>Vous avez testé " . $critique['nom'] ." le " . $critique['date_test'] . "</h2>";
            echo "<p>" . $critique['message'] . "</p>";
            echo "<span id='boutons'>";
            $this->render_bouton_supp($critique);
            $this->render_boutons($critique);
            echo "</span>";
            echo "</div>";
        }
        echo "</div>";
    }

    /**
     * affiche les boutons de gestion d'une critique user
     * @param mixed $critique
     * @return void
     */
    function render_boutons($critique):void {

        // deuxième bouton modifier
        echo "<form method='POST' action='modifierCritique.php' style='display:inline;'>";
        echo "<input type='hidden' name='id_critique' value='" . $critique['id_critique'] . "'>";
        echo "<button type='submit' class='modify-button'>Modifier</button>";
        echo "</form>";

        // troisieme bouton voir le restaurant
        echo "<form method='GET' action='restaurant_details.php' style='display:inline;'>";
        echo "<input type='hidden' name='id' value='" . $critique['id_resto'] . "'>";
        echo "<button type='submit' class='seeResto-button'>Voir le restaurant</button>";
        echo "</form>";
    }

    /**
     * affiche les boutons de gestion d'une critique user
     * @param mixed $critique
     * @return void
     */
    function render_bouton_supp($critique): void{
        echo "<form method='POST' action='utils/gestion-data/supprimer_critique.php' style='display:inline;'>";
        echo "<input type='hidden' name='id_critique' value='" . $critique['id_critique'] . "'>";
        echo "<button type='submit' class='delete-button'>". 'Supprimer' . "</button>";
        echo "</form>";
    }

    /**
     * affiche les boutons de gestion d'une critique user
     * @param mixed $critique
     * @return void
     */
    function render_bouton_type_critique($critique): void{
        echo "<form method='POST' action='utils/gestion-data/supprimer_critique.php' style='display:inline;'>";
        echo "<input type='hidden' name='id_critique' value='" . $critique->getId() . "'>";
        echo "<button type='submit' class='delete-button'>". 'Supprimer' . "</button>";
        echo "</form>";
    }

    /**
     * affiche les critiques venant d'un restaurant
     * @return void
     */
    function render_critiques_restaurant(): void{
        echo "<div class='critique-container'>";
        foreach ($this->objects as $critique){
            echo "<div class='critique'>";
            echo "<div>";
            $end = false;
            echo "<span class='stars'>";
            for ($i = 0; $i<5;$i++){
                if ($i>$critique->getNote()-1){
                    $end=true;
                    echo "</span>";
                    break;
                } else {
                    echo "★";
                }
            }
            if ($end){
                echo "<span class='no-stars'>";
                for ($i = 0; $i<5-$critique->getNote()-1;$i++){
                    echo "★";
                }
                echo "</span>";
            }
            echo "</div>";
            echo "<h2>". $critique->getUser()->getPrenom() . " ". $critique->getUser()->getNom()." a testé " . $critique->getRestaurant()->getNom() ." le " . $critique->getDateTest() . "</h2>";
            echo "<p>" . $critique->getMessage() . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }

    function critique_admin(){
        echo "<div class='critique-container'>";
        foreach ($this->objects as $critique){
            echo "<div class='critique'>";
            echo "<div>";
            $end = false;
            echo "<span class='stars'>";
            for ($i = 0; $i<5;$i++){
                if ($i>$critique->getNote()){
                    $end=true;
                    echo "</span>";
                    break;
                } else {
                    echo "★";
                }
            }
            if ($end){
                echo "<span class='no-stars'>";
                for ($i = 0; $i<5-$critique->getNote();$i++){
                    echo "★";
                }
                echo "</span>";
            }
            echo "</div>";
            echo "<h2>". $critique->getUser()->getPrenom() . " ". $critique->getUser()->getNom()." a testé " . $critique->getRestaurant()->getNom() ." le " . $critique->getDateTest() . "</h2>";
            echo "<p>" . $critique->getMessage() . "</p>";
            echo "</div>";
            $this->render_bouton_type_critique($critique);
        }
        echo "</div>";

    }
}


?>