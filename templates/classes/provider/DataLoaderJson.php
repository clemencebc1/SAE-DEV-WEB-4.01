<?php
namespace classes\provider;
use classes\provider\DataLoaderInterface;
use utils\connection\DBConnector;

final class DataLoaderJson implements DataLoaderInterface {
    private $data;
    private $url;
    public function __construct(String $source){
        $content = file_get_contents($source);
        $this->data = (array) json_decode($content, true);
        $this->url = $source;
    }
    function getData(){
        return $this->data;
    }

    /**
     * ajout des données dans la base de données
     * @param mixed $pdo pour ajouter les données dans la base de données
     * @return void
     */
    function insertData(){
        $allCuisine = array();
        $Allresto = array();
        $Allcarac = array();

        foreach($this->data as $resto){
            $name = $resto['name'];
            $capacity = $resto['capacity'];
            $tel = $resto['phone'];
            $siret = $resto['siret'];
            $website = $resto['website'];
            $region = $resto['code_departement'];
            $nbetoile = $resto['stars'] ?? 0;
            $horaires = $resto['opening_hours'];
            $gps_lat = isset($resto['geo_point_2d']['lat']) ? (float) $resto['geo_point_2d']['lat'] : null;
            $gps_long = isset($resto['geo_point_2d']['lon']) ? (float) $resto['geo_point_2d']['lon'] : null;
            $idCuisine = null;
           
            if (isset($resto['cuisine'])) {

                $type_cuisine = $resto['cuisine'];

                error_log("type_cuisine: " . var_export($type_cuisine, true));

                foreach ($type_cuisine as $cuisine){
                    if (!in_array($cuisine, $allCuisine)){
                        array_push($allCuisine, $cuisine);
                        $cuisineObject = DBConnector::getOrInsertTypeCuisineByName($cuisine);
                    }
                    if (!in_array($name, $Allresto)){
                        array_push($Allresto, $name);

                    }
                    $idCuisine = $cuisineObject->getId();
                }
                error_log("idCuisine From DB: " . var_export($idCuisine, true));
            }
            

            //Debugging statements
            error_log("gps_lat: " . var_export($gps_lat, true));
            error_log("gps_long: " . var_export($gps_long, true));
            error_log("gps_lat type: " . gettype($gps_lat));
            error_log("gps_long type: " . gettype($gps_long));
           
            
            $result = DBConnector::insertRestaurant($name, $capacity, $tel, $siret, $website, $region, $nbetoile, $horaires, $gps_lat, $gps_long,  $idCuisine);
            if (!($result)){
                break;
            }
            $this->addCarac($resto);
        }
        error_log("allCuisine: " . var_export($allCuisine, true));
        error_log("resto: ". var_export($Allresto, true));

    }

    /**
     * ajoute les caracteristiques des restaurants dans la base de donnees
     * @param mixed $resto
     * @param mixed $pdo
     * @return void
     */
    public function addCarac($resto){
        $caracteristiques = ['wheelchair', 'vegetarian', 'vegan', 'delivery', 'takeaway', 'internet_access', 'stars', 'smoking'];
        foreach ($caracteristiques as $carac){
            $nameCarac = false;
            $caracCondition = $resto[$carac] != null;
            if ($caracCondition){
                if ($resto[$carac] == "yes"){
                    $nameCarac = $carac;
                    $idCarac = $this->caracByName($nameCarac);
                    $idResto = DBConnector::getRestaurantByName($resto['name'])->getId();
                    DBConnector::insertCaracteriserRestaurant($idResto, $idCarac);
                }
            }
        }
    }
    /**
     * get les id caracteristiques en fonction du nom
     * @param mixed $carac nom caracteristique
     * @param mixed $pdo dbconnector
     */
    function caracByName($carac): int|null{
        $carac = DBConnector::getCaracteristiqueByName($carac);
        if (isset($carac)){
            return $carac->getId();
        }
        return null;
    }

}
?>