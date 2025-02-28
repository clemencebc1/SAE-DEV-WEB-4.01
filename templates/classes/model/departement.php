<?php
declare(strict_types=1);
namespace classes\model;

class Departement {
    private int $id;
    private string $nomdep;
    function __construct(int $id, string $nomdep){
        $this->id = $id;
        $this->nomdep = $nomdep;
    }

    /**
     * Get la valeur id departement
     * @return int
     */
    function getId(): int {
        return $this->id;
    }
    /**
     * Get le nom departement
     * @return string
     */
    function getNomdep(): string{
        return $this->nomdep;
    }
}
?>