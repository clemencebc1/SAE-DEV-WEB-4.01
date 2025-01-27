<?php
declare(strict_types=1);
namespace model;

class Caracteristique {
    private int $id_carac;
    private string $caracteristique;
    function __construct(int $id_carac, string $caracteristique){
        $this->caracteristique = $caracteristique;
        $this->id_carac = $id_carac;
    }
    function getId():int{
        return $this->id_carac;
    }
    function getMessage(): string{
        return $this->caracteristique;
    }
}

?>