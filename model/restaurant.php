<?php
declare(strict_types=1);
namespace model;
use model\Departement;
class Restaurant {
    private int $id;
    private string $nom;
    private string $adresse;
    private string $website;
    private int $capacity;
    private int $nbetoile;
    private array $type_cuisine;
    private Departement $dep;
    private array $typecuisine;


    public function __construct(int $id, string $nom, string $adresse, string $website, int $capacity, int $nbetoile, array $type_cuisine, Departement $departement, array $typecuisine){
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->website = $website;
        $this->capacity = $capacity;
        $this->nbetoile = $nbetoile;
        $this->type_cuisine = $type_cuisine;
        $this->dep = $departement;
        $this->typecuisine = $typecuisine;
    }

    public function getNom(): string {
        return $this->nom;
    }
    public function getId(): int{
        return $this->id;
    }
    public function getAdresse(): string {
        return $this->adresse;
    }
    public function getWebsite(): string {
        return $this->website;
    }
    public function getCapacity(): int{
        return $this->capacity;
    }
    public function getNbEtoile(): int {
        return $this->nbetoile;
    }
    public function getTypeCuisine(): array {
        return $this->type_cuisine;
    }
    public function getDepartement(): Departement {
        return $this->dep;
    }


}

?>