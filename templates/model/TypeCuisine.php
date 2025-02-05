<?php
declare(strict_types=1);
namespace model;

class TypeCuisine {
    private int $id_type;
    private string $cuisine;
    function __construct(int $id_type, string $cuisine){
        $this->id_type = $id_type;
        $this->cuisine = $cuisine;
    }
    function getId(): int {
        return $this->id_type;
    }
    function getCuisine(): string {
        return $this->cuisine;
    }

}


?>