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
        foreach($this->data as $resto){
            $name = $resto['name'];
            $capacity = $resto['capacity'];
            $tel = $resto['phone'];
            $siret = $resto['siret'];
            $website = $resto['website'];
            $region = $resto['code_departement'];
            $nbetoile = $resto['stars'] ?? 0;
            $horaires = $resto['opening_hours'];
            $result = DBConnector::insertRestaurant($name, $capacity, $tel, $siret, $website, $region, $nbetoile, $horaires);
            if (!($result)){
                break;
            }
            $this->addCarac($resto);
        }
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
            if ($carac == 'wheelchair'){
                if ($resto[$carac] != 'no'){
                    $nameCarac = 'wheelchair';
                }
            }
            else {
                $nameCarac = $resto[$carac] == 'yes' ? $carac : null;
            }
               
            if ($nameCarac){
                $idCarac = $this->caracByName($nameCarac);
                $idResto = DBConnector::getRestaurantByName($resto['name'])->getId();
                DBConnector::insertCaracteriserRestaurant($idResto, $idCarac);
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

    function addGpsCoordinates(){
        foreach($this->data as $resto){
            $idResto = DBConnector::getRestaurantByName($resto['name'])->getId();
            $lat = $resto['latitude'];
            $long = $resto['longitude'];
            DBConnector::insertCoordinates($idResto, $lat, $long);
        }
    }

}
?>