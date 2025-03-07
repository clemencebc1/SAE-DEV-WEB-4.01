<?php
declare(strict_types=1);
namespace classes\model;
use classes\model\Departement;
use classes\model\TypeCuisine;
class Restaurant {
    private int $id;
    private string | null $nom;
    private string | null $website;
    private int | null $capacity;
    private int | null $nbetoile;
    private string | null $adresse;
    private float | null $gps_lat;
    private float | null $gps_long;
    private TypeCuisine | null $type_cuisine;
    private Departement | null $dep;
    private mixed $photos;

    public function __construct(
            int $id, string $nom, 
            string | null $website, 
            int | null $capacity, 
            int | null $nbetoile, 
            float | null $gps_lat, 
            float | null $gps_long, 
            Departement | null $departement,
            mixed $url, 
            TypeCuisine | null  $type_cuisine
        ){
        $this->id = $id;
        $this->nom = $nom;
        $this->website = $website;
        $this->capacity = $capacity;
        $this->nbetoile = $nbetoile;
        $this->gps_lat = $gps_lat;
        $this->gps_long = $gps_long;
        if ($adress !== null) {
            $this->adresse = $adress;
        }else {
            $this->adresse = $this->getCoordinatesAdressFromAPI();
        } 
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
    public function getTypeCuisine(): mixed {
        return $this->type_cuisine;
    }

    /**
     * Get la latitude du restaurant
     * @return float
     */
    public function getGpsLat(): float {
        return $this->gps_lat;
    }

    /**
     * Get la longitude du restaurant
     * @return float
     */
    public function getGpsLong(): float {
        return $this->gps_long;
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

    public function getCoordinatesAdressFromAPI() {
        $data = $this->getRestaurantInfoByCo($this->gps_lat, $this->gps_long);
        return $this->formatAdresse($data);
    }

    function getRestaurantInfoByCo(float $lat, float $lon):array {
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon";
        $options = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: PHP\r\n"
            ]
        ];
        
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        if ($response === FALSE) {
            die('Error');
        }
        
        $dataResto = json_decode($response, true);
        return $dataResto;
    }
    
    function formatAdresse($dataResto):string {
        return ($dataResto["address"]["house_number"] ?? '') ." ".
        ($dataResto["address"]["retail"] ?? 'rue ..?') ." ".
        ($dataResto["address"]["city"] ?? '') ." ".
        ($dataResto["address"]["postcode"] ?? '') ." ".
        ($dataResto["address"]["country"] ?? '');
    }

}

?>


