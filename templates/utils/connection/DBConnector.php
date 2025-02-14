<?php
declare(strict_types=1);
namespace utils\connection;
use classes\model\Critique;
use \PDO;
use \Exception;
use classes\model\Restaurant;
use classes\model\Departement;
use classes\model\TypeCuisine;
use classes\model\User;

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
    public static function getInstance(): PDO {
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
    public static function checkDB($username, $password): mixed {
        $hash = hash('sha1', $password);
        $query = self::getInstance()->prepare('SELECT * FROM public."Visiteur" WHERE MAIL = :username AND PASSWORD = :password');
        $query->execute(array('username' => $username, 'password' => "\x" . $hash));
        $result = $query->fetch();
        return $result;
    }

    /**
     * inscrit un nouveau visiteur
     * @param mixed $username mail
     * @param mixed $password mot de passe en clair
     * @param mixed $nom nom visiteur
     * @param mixed $prenom prenom visiteur
     * @param mixed $visiteur role
     * @return bool true si inscrit sinon false (existe deja ou erreur)
     */
    public static function subscribe($username, $password, $nom, $prenom, $visiteur): bool {
        $hash = hash('sha1', $password);
        $query = self::getInstance()->prepare('INSERT INTO public."Visiteur" (MAIL, PASSWORD, NOM, PRENOM, ROLE) VALUES (:username, :password, :nom, :prenom, :visiteur)');
        $result = $query->execute(array('username' => $username, 'password' => "\x" . $hash, 'nom' => $nom, 'prenom' => $prenom, 'visiteur' => $visiteur));
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
    public static function getTypeCuisineById($id): TypeCuisine {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine" WHERE id = :idT');
        $query->execute(array('idT' => $id));
        $result = $query->fetch();
        $typeCuisine = new TypeCuisine($result['id'], $result['cuisine']);
        return $typeCuisine;
    }

    /**
     * Récupère tous les restaurants de la base de données.
     * @return array[Restaurant]  Les restaurants de la base de données.
     */
    public static function getAllRestaurants(): array {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo"');
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
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'],
                self::getTypeCuisineById($restaurant['cuisine']));
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
        $result = $query->fetch();
        $restaurant = new Restaurant(
            $result['id_resto'], 
            $result['nom'], 
            $result['adresse'], 
            $result['website'], 
            $result['capacity'], 
            $result['nb_etoile'] != 0 ? $result['nb_etoile'] : 0,
            self::getDepartementById($result['region_id']),
            $result['url'],
            self::getTypeCuisineById($result['cuisine']));
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
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'],
                self::getTypeCuisineById($restaurant['cuisine']));
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
                    self::getDepartementById($restaurant['region_id']),
                    $restaurant['url'],
                    self::getTypeCuisineById($restaurant['cuisine'])
);
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
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'],
                self::getTypeCuisineById($restaurant['cuisine']));
        }
        return $all_restaurants;
    }    
    
    public static function getAllType(): array {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine"');
        $query->execute();
        $result = $query->fetchAll();
        $all_type = [];
        foreach ($result as $type) {
            $all_type[] = new TypeCuisine($type['id'], $type['cuisine']);
        }
        return $all_type;
    }

    /**
     * Récupere le dernier restaurant visité par un utilisateur.
     * @param string $user L'adresse mail de l'utilisateur.
     * @return Restaurant le restaurant en question.
     */
    public static function getLatestRestaurant($user): Restaurant {
        $query = self::getInstance()->prepare('SELECT nom, id_resto, url, adresse, website, capacity, nb_etoile, cuisine, region_id FROM public."Critique" natural join public."Restaurant"  natural join public."Photo" WHERE mail_user=:user ORDER BY date_test DESC LIMIT 1');
        $query->execute(['user' => $user]);
        $result = $query->fetch();
        $restaurant = new Restaurant(
            $result['id_resto'], 
            $result['nom'], 
            $result['adresse'], 
            $result['website'], 
            $result['capacity'], 
            $result['nb_etoile'] != 0 ? $result['nb_etoile'] : 0, 
            self::getDepartementById($result['region_id']),
            $result['url'],
            self::getTypeCuisineById($result['cuisine']));
        return $restaurant;
    }

    /**
     * Récupère les critiques d'un utilisateur.
     * @param string $user L'adresse mail de l'utilisateur.
     * @return array Les critiques de l'utilisateur.
     */
    public static function getCritiquesByUser($user): array {
        $query = self::getInstance()->prepare('SELECT nom, id_resto, message, date_test, id_critique, etoiles FROM public."Critique" natural join public."Restaurant" WHERE mail_user=:user ORDER BY date_test DESC');
        $query->execute(['user' => $user]);
        $result = $query->fetchAll();
        return $result;
    }

    public static function getCritique($id_critique): Critique{
        $query = self::getInstance()->prepare('SELECT * FROM public."Critique" WHERE id_critique=:id');
        $query->execute(['id' => $id_critique]);
        $result = $query->fetch();
        $critique = new Critique($result['id_critique'], $result['message'], new Restaurant($result['id_resto'],'', '', '', 0, 0, new Departement(0, ''), '', new TypeCuisine(0, '')), new User('', '', '', '', '', array()), $result['date_test'], $result['etoiles']);
        return $critique;
    }

    /** 
    * Récupère les favoris d'un utilisateur.
    * @param string $user L'adresse mail de l'utilisateur.
    * @return array Les favoris de l'utilisateur.
    */
    public static function getFavorisByUser($user): array {
        $query = self::getInstance()->prepare('Select * from public."aimer" natural join public."Restaurant" natural left join public."Photo" where mail=:user');
        $query->execute(['user' => $user]);
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
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'],
                self::getTypeCuisineById($restaurant['cuisine']));
        }
        return $all_restaurants;
    }

    /** 
    * Supprime un restaurant favoris
    * @param string $user L'adresse mail de l'utilisateur.
    * @param int $id_resto L'identifiant du restaurant.
    * @return bool true si la suppression a réussi, false sinon.
    */
    public static function deleteFavoris($user, $id_resto): bool {
        $query = self::getInstance()->prepare('DELETE FROM public."aimer" WHERE mail=:user AND id_resto=:id');
        $result = $query->execute(['user' => $user, 'id' => $id_resto]);
        return $result;
    }

    /**  supprime une critique
    * @param int $id_critique L'identifiant de la critique.
    * @return bool true si la suppression a réussi, false sinon.
    */
    public static function deleteCritique($id_critique): bool {
        $query = self::getInstance()->prepare('DELETE FROM public."Critique" WHERE id_critique=:id');
        $result = $query->execute(['id' => $id_critique]);
        return $result;
    }

    /** modifie une critique
    * @param int $id_critique L'identifiant de la critique.
    * @param string $message Le message de la critique.
    * @param int $etoiles Le nombre d'étoiles de la critique.
    * @return bool true si la modification a réussi, false sinon.
    */
    public static function modifyCritique($id_critique, $message, $etoiles): bool {
        $query = self::getInstance()->prepare('UPDATE public."Critique" SET message=:message, etoiles=:etoiles WHERE id_critique=:id');
        $result = $query->execute(['message' => $message, 'etoiles' => $etoiles, 'id' => $id_critique]);
        return $result;
    }

}
?>