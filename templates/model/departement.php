<?php
declare(strict_types=1);
namespace model;

class Departement {
    private int $id;
    private string $nomdep;
    function __construct(int $id, string $nomdep){
        $this->id = $id;
        $this->nomdep = $nomdep;
    }
    function getId(): int {
        return $this->id;
    }
    function getNomdep(): string{
        return $this->nomdep;
    }
}
?>