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

    /**
     * Get le nom du restaurant
     * @return string
     */
    public function getNom(): string {
        return $this->nom;
    }

    /**
     * Get l'id du restaurant
     * @return int
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * Get l'adresse du restaurant
     * @return string
     */
    public function getAdresse(): string {
        return $this->adresse;
    }

    /**
     * Get le site web du restaurant
     * @return string
     */
    public function getWebsite(): string {
        return $this->website;
    }

    /**
     * Get la capacité du restaurant
     * @return int
     */
    public function getCapacity(): int{
        return $this->capacity;
    }

    /**
     * Get le nombre d'étoile du restaurant
     * @return int
     */
    public function getNbEtoile(): int {
        return $this->nbetoile;
    }

    /**
     * Get le type de cuisine du restaurant
     * @return TypeCuisine
     */
    public function getTypeCuisine(): TypeCuisine {
        return $this->type_cuisine;
    }

    /**
     * Get le département du restaurant
     * @return Departement
     */
    public function getDepartement(): Departement {
        return $this->dep;
    }

    /**
     * Get la région du restaurant
     * @return string
     */
    public function getRegion(): string {
        return $this->dep->getNomdep();
    }  

    /**
     * Get les photos du restaurant
     * @return mixed liste ou simple photo (url)
     */
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


