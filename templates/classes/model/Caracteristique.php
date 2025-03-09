<?php
declare(strict_types=1);
namespace classes\model;

class Caracteristique {
    private int $id_carac;
    private string $caracteristique;
    function __construct(int $id_carac, string $caracteristique){
        $this->caracteristique = $caracteristique;
        $this->id_carac = $id_carac;
    }

    /**
     * Get la valeur id_carac
     * @return int
     */
    function getId():int{
        return $this->id_carac;
    }

    /**
     * Get la valeur caracteristique
     * @return string
     */
    function getMessage(): string{
        return $this->caracteristique;
    }
}

?>