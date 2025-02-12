<?php 
declare(strict_types=1);
namespace utils\render;

class CritiqueRender extends Render {
    function __construct(array $critiques){
        parent::__construct($critiques);
    }
    function render(): void{
        echo "<div>";
        foreach ($this->objects as $critique){
            echo "<div class='critique'><h2>Vous avez testé " . $critique['nom'] ." le " . $critique['date'] . "</h2>";
            echo "<p>" . $critique['message'] . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }
}


?>