<?php
declare(strict_types=1);
namespace utils\connection;
use \PDO;
use \Exception;
use model\Restaurant;
use model\Departement;

class DBConnector {
    private $pdo;
    private $user;
    private $password;
    private $host;
    private $port;
    private $dn;
    public static $instance = null;
    

    private function __construct() {
        $this->user = 'postgres.qwspzcdwzooofvlczlew';
        $this->password = 'sQFn5EbtM4dKt4b4';
        $this->host= 'aws-0-eu-west-3.pooler.supabase.com';
        $this->port = 6543;
        $this->dn = "pgsql:host=".$this->host.";port=". $this->port .";dbname=postgres";
        try {
            self::$instance = new PDO($this->dn, $this->user, $this->password);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    /**
     * Retourne l'instance unique de la connexion à la base de données.
     * @return PDO L'instance de la connexion à la base de données.
     */
    public static function getInstance() {
        if (self::$instance == null) {
            new DBconnector();
        }
        return self::$instance;
    }

    /**
     * Vérifie les informations d'identification de l'utilisateur dans la base de données.
     * @param string $username Le nom d'utilisateur.
     * @param string $hashedPassword Le mot de passe haché.
     * @return mixed Les informations de l'utilisateur si elles sont trouvées, sinon false.
     */
    public static function checkDB($username, $password) {
        $hash = hash('sha1', $password);
        $query = self::getInstance()->prepare('SELECT * FROM public."Visiteur" WHERE MAIL = :username AND PASSWORD = :password');
        $query->execute(array('username' => $username, 'password' => "\x" . $hash));
        $result = $query->fetch();
        return $result;
    }


    /**
     * Récupère le département par son identifiant.
     * @param int $id L'identifiant du département.
     * @return Departement Le département.
     */
    public static function getDepartementById($id) {
        $query = self::getInstance()->prepare('SELECT * FROM public."Departement" WHERE id_region = :idD');
        $query->execute(array('idD' => $id));
        $result = $query->fetch();
        $dep = new Departement($result['id_region'], $result['nom_dep']);
        return $dep;
    }


    /**
     * Récupère le type de cuisine par son identifiant.
     * @param int $id L'identifiant du type de cuisine.
     * @return string Le type de cuisine.
     */
    public static function getTypeCuisineById($id) {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine" WHERE id = :idT');
        $query->execute(array('idT' => $id));
        $result = $query->fetch();
        return $result['cuisine'];
    }

    /**
     * Récupère tous les restaurants de la base de données.
     * @return array[Restaurant]  Les restaurants de la base de données.
     */
    public static function getAllRestaurants() {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant"');
        $query->execute();
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'], 
                $restaurant['adresse'], 
                $restaurant['website'], 
                $restaurant['capacity'], 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0, 
                self::getTypeCuisineById($restaurant['cuisine']),
                self::getDepartementById($restaurant['region_id']));
        }
        return $all_restaurants;
    }

    /**
     * Récupère un restaurant par son identifiant.
     * @param int $id L'identifiant du restaurant.
     * @return Restaurant Le restaurant.
     */
    public static function getRestaurantById($id) {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" WHERE id_resto = :idR');
        $query->execute(array('idR' => $id));
        $result = $query->fetchAll();
        $restaurant = new Restaurant(
            $restaurant['id_resto'], 
            $restaurant['nom'], 
            $restaurant['adresse'], 
            $restaurant['website'], 
            $restaurant['capacity'], 
            $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0, 
            self::getTypeCuisineById($restaurant['cuisine']),
            self::getDepartementById($restaurant['region_id']));
        return $restaurant;
    }

    /**
     * Récupère les restaurants par leur nom.
     * @param string $name Le nom du restaurant.
     * @return array[Restaurant] Les restaurants.
     */
    public static function searchRestaurantByCity($city) {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" WHERE adresse LIKE :city');
        $query->execute(array('city' => '%'.$city.'%'));
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'], 
                $restaurant['adresse'], 
                $restaurant['website'], 
                $restaurant['capacity'], 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0, 
                self::getTypeCuisineById($restaurant['cuisine']),
                self::getDepartementById($restaurant['region_id']));
        }
        return $all_restaurants;
    }

    /**
     * Récupère les restaurants par leur nom.
     * @param string $name Le nom du restaurant.
     * @return array[Restaurant] Les restaurants.
     */
    public static function searchRestaurantByType($type) {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine" WHERE cuisine LIKE :type');
        $query->execute(array('type' => '%'.$type.'%'));
        $types = $query->fetchAll();
        $all_restaurants = [];
        foreach ($types as $idCuisine) {
            $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" WHERE cuisine = :idC');
            $query->execute(array('idC' => $idCuisine['id']));
            $result = $query->fetchAll();
            foreach ($result as $restaurant) {
                $all_restaurants[] = new Restaurant(
                    $restaurant['id_resto'], 
                    $restaurant['nom'], 
                    $restaurant['adresse'], 
                    $restaurant['website'], 
                    $restaurant['capacity'], 
                    $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0, 
                    self::getTypeCuisineById($restaurant['cuisine']),
                    self::getDepartementById($restaurant['region_id']));
            }
        } 
        return $all_restaurants;
    }

    /**
     * Récupère les restaurants par leur nom.
     * @param string $name Le nom du restaurant.
     * @return array[Restaurant] Les restaurants.
     */
    public static function searchRestaurantByName($name) {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" WHERE nom LIKE :name');
        $query->execute(array('name' => '%'.$name.'%'));
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'], 
                $restaurant['adresse'], 
                $restaurant['website'], 
                $restaurant['capacity'], 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0, 
                self::getTypeCuisineById($restaurant['cuisine']),
                self::getDepartementById($restaurant['region_id']));
        }
        return $all_restaurants;
    }
}
?>