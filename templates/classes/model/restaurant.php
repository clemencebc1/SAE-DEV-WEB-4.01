<?php
declare(strict_types=1);
namespace classes\model;
use classes\model\Departement;
use classes\model\TypeCuisine;
class Restaurant {
    private int $id;
    private string $nom;
    private string $adresse;
    private string $website;
    private int $capacity;
    private int $nbetoile;
    private TypeCuisine $type_cuisine;
    private Departement $dep;
    private mixed $photos;

    public function __construct(int $id, string $nom, string $adresse, string $website, int $capacity, int $nbetoile, Departement $departement, mixed $url, TypeCuisine $type_cuisine){
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->website = $website;
        $this->capacity = $capacity;
        $this->nbetoile = $nbetoile;
        $this->type_cuisine = $type_cuisine;
        $this->dep = $departement;
        $this->photos = $url;
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
    public function getTypeCuisine(): TypeCuisine {
        return $this->type_cuisine;
    }
    public function getDepartement(): Departement {
        return $this->dep;
    }

    public function getRegion(): string {
        return $this->dep->getNomdep();
    }  
    public function getPhotos(): mixed {
        return $this->photos;
    }

    public function __toString(): string {
        return $this->nom;
    }


    public function equals(Restaurant $restaurant): bool {
        return $this->id === $restaurant->getId();
    }

}

?>


