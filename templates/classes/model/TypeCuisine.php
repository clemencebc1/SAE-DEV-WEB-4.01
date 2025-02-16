<?php
declare(strict_types=1);
namespace classes\model;

class TypeCuisine {
    private int $id_type;
    private string $cuisine;
    public function __construct(int $id_type, string $cuisine){
        $this->id_type = $id_type;
        $this->cuisine = $cuisine;
    }

    /**
     * Get l'id du type de cuisine
     * @return int
     */
    function getId(): int {
        return $this->id_type;
    }

    /**
     * Get le type de cuisine
     * @return string
     */
    function getCuisine(): string {
        return $this->cuisine;
    }

}


?>