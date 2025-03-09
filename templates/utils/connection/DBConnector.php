<?php
declare(strict_types=1);
namespace utils\connection;
use classes\model\Caracteristique;
use classes\model\critique;
use \PDO;
use \Exception;
use classes\model\restaurant;
use classes\model\departement;
use classes\model\TypeCuisine;
use classes\model\user;

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
            new DBConnector();
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
        $query = self::getInstance()->prepare('INSERT INTO public."Visiteur" (MAIL, PASSWORD, NOM_USER, PRENOM, ROLE) VALUES (:username, :password, :nom, :prenom, :visiteur)');
        $result = $query->execute(array('username' => $username, 'password' => "\x" . $hash, 'nom' => $nom, 'prenom' => $prenom, 'visiteur' => $visiteur));
        return $result;
    }

    /**
     * get tous les users dans la base de donnees
     */
    public static function get_users(): array{
        $query = self::getInstance()->prepare('Select * from public."Visiteur"');
        $query->execute();
        $result = $query->fetchAll();
        $all_users = [];
        foreach ($result as $user){
            $all_users[] = new User($user['mail'], $user['password'], $user['nom_user'], $user['prenom'], $user['role'], array());
        }
        return $all_users;
    }

    /**
     * Recupere un utilisateur
     * @param string $username L'adresse mail de l'utilisateur.
     * @param string $nom Le nom de l'utilisateur.
     * @param string $prenom Le prénom de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @return User l'utilisateur
     */
    public static function getUser($username): User {
        $query = self::getInstance()->prepare('SELECT * FROM public."Visiteur" WHERE MAIL = :username');
        $query->execute(array('username' => $username));
        $result = $query->fetch();
        $user = new User($result['mail'], $result['password'], $result['nom_user'], $result['prenom'], $result['role'], array());
        return $user;
    }

    public static function updateUser($username, $nom, $prenom, $password): bool {
        $user = DBConnector::getUser($username);
        if ($user->getPassword() == $password) {
            $hash = $user->getPassword();
        }
        $query = self::getInstance()->prepare('UPDATE public."Visiteur" SET NOM_USER=:nom, PRENOM=:prenom, PASSWORD=:password WHERE MAIL=:username');
        $result = $query->execute(array('nom' => $nom, 'prenom' => $prenom, 'password' => $hash, 'username' => $username));
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
     * @return mixed Le type de cuisine.
     */
    public static function getTypeCuisineById($id): mixed {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine" WHERE id = :idT');
        $query->execute(array('idT' => $id));
        $result = $query->fetch();
        if ($result) {
            $typeCuisine = new TypeCuisine($result['id'], $result['cuisine']);
        } else {
            $typeCuisine = null;
        }
        return $typeCuisine;
    }

    /**
     * recupère le type de cuisine par son nom
     * @param mixed $name nom de la cuisine
     * @return mixed objet type cuisine
     */
    public static function getTypeCuisineByName($name): mixed {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine" WHERE cuisine = :name');
        $query->execute(array('name' => $name));
        $result = $query->fetch();
        $typeCuisine = null;
        if ($result){
            $typeCuisine = new TypeCuisine($result['id'], $result['cuisine']);
        }
        return $typeCuisine;
    }

    /**
     * recupere la caracteristique par son nom
     * @param mixed $name nom de la caracteristique
     * @return mixed objet caracteristique
     */
    public static function getCaracteristiqueByName($name): mixed {
        $query = self::getInstance()->prepare('SELECT * FROM public."Caractéristique" WHERE carac = :name');
        $query->execute(array('name' => $name));
        $result = $query->fetch();
        if ($result){
            $caracteristique = new Caracteristique($result['id_carac'], $result['carac']);
            return $caracteristique;
        }
        return null;
    }

    /**
     * get toutes les caracteristiques
     * @return array
     */
    public static function getCaracteristique():array{
        $sql = 'SELECT * FROM public."Caractéristique"';
        $stmt = self::getInstance()->query($sql);
        $rows = $stmt->fetchAll();
        $all_carac = [];
        foreach ($rows as $result) {
            $all_carac[] = new Caracteristique($result['id_carac'], $result['carac']);
        return $all_carac;
        }
    }

    /**
    * get toutes les caracteristiques d'un restaurant donné
    * @return array
    */
    public static function getCaracteristiquesByRestaurant(int $restaurant_id): array {
        $caracteristiques = [];
        $sql = 'SELECT c.id_carac, c.carac FROM public."Caractéristique" c JOIN public."Caracteriser" cr ON c.id_carac = cr.id_carac WHERE cr.id_resto = :restaurant_id';      
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute(['restaurant_id' => $restaurant_id]);
        $rows = $stmt->fetchAll();
        foreach ($rows as $result) {
            $caracteristiques[] = new Caracteristique($result['id_carac'], $result['carac']);
        }
        return $caracteristiques;
    }
    
    /**
     * Récupère tous les restaurants de la base de données.
     * @return array[Restaurant]  Les restaurants de la base de données.
     */
    public static function getAllRestaurants(int | null  $limit, int | null $type): array {
        if ($limit == null){
            $limit = 10;
        }
        if (!empty($type)) {
            $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" WHERE id_cuisine = :type ORDER BY nom Limit :limit');
            $query->execute(array('type' => $type, 'limit' => $limit));
        } else {
            $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" ORDER BY nom Limit :limit');
            $query->execute(array('limit' => $limit));
        }
        // $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" ORDER BY nom Limit :limit');
        // $query->execute(array('limit' => $limit));
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'], 
                $restaurant['website'] ?? '', 
                $restaurant['capacity'] ?? 0, 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0,
                $restaurant['adresse'] ?? null,
                (float) $result['gps_lat'] ?? null,
                (float) $result['gps_long'] ?? null,
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'] ?? '',
                self::getTypeCuisineById($restaurant['id_cuisine']) ?? new TypeCuisine(0, ''));
        }
        return $all_restaurants;
    }

    /**
     * Récupère un restaurant par son identifiant.
     * @param int $id L'identifiant du restaurant.
     * @return mixed Le restaurant.
     */
    public static function getRestaurantById($id): mixed {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" WHERE id_resto = :idR');
        $query->execute(array('idR' => $id));
        $result = $query->fetch();
        if (!$result) {
            return null;
        }
        $restaurant = new Restaurant(
            $result['id_resto'], 
            $result['nom'], 
            $result['website'] ?? '', 
            (int) $result['capacity'] ?? 0, 
            $result['nb_etoile'] != 0 ? $result['nb_etoile'] : 0,
            $restaurant['adresse'] ?? null,
            (float) $result['gps_lat'] ?? null,
            (float) $result['gps_long'] ?? null,
            self::getDepartementById($result['region_id']),
            $result['url'] ?? '',
            self::getTypeCuisineById($result['id_cuisine']));
        return $restaurant;
    }

    /**
     * recupere le restaurant par son nom
     * @param mixed $name nom du restaurant
     * @return mixed objet restaurant
     */
    public static function getRestaurantByName($nom): mixed {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" WHERE nom = :nom');
        $query->execute(array('nom' => $nom));
        $result = $query->fetch();
        if ($result){
            $restaurant = new Restaurant(
                $result['id_resto'], 
                $result['nom'], 
                $result['website'] ?? '', 
                $result['capacity'] ?? 0, 
                $result['nb_etoile'] != 0 ? $result['nb_etoile'] : 0,
                $restaurant['adresse'] ?? null,
                (float) $result['gps_lat'] ?? null,
                (float) $result['gps_long'] ?? null,
                self::getDepartementById($result['region_id']),
                $result['url'] ?? '',
                self::getTypeCuisineById($result['id_cuisine']) ?? new TypeCuisine(0, ''));
                return $restaurant;
        } 
        return null;
    }


    public static function getRestaurantByType($id_type){
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" WHERE id_cuisine = :idT');
        $query->execute(array('idT' => $id_type));
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'], 
                $restaurant['website'] ?? '', 
                $restaurant['capacity'] ?? 0, 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0,
                (float) $result['gps_lat'] ?? null,
                (float) $result['gps_long'] ?? null,
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'] ?? '',
                self::getTypeCuisineById($restaurant['id_cuisine']));
        }
        return $all_restaurants;
    }

    /**
     * Récupère les restaurants par leur nom.
     * @param string $name Le nom du restaurant.
     * @return array[Restaurant] Les restaurants.
     */
    public static function searchRestaurantByCity($city) {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant"  natural left join public."Photo" WHERE adresse LIKE :city');
        $query->execute(array('city' => '%'.$city.'%'));
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'],  
                $restaurant['website'] ?? '', 
                $restaurant['capacity'] ?? 0, 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0,
                $restaurant['adresse'] ?? null,
                (float) $result['gps_lat'] ?? null,
                (float) $result['gps_long'] ?? null,
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'] ?? '',
                self::getTypeCuisineById($restaurant['id_cuisine']));
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
            $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" WHERE id_cuisine = :idC');
            $query->execute(array('idC' => $idCuisine['id']));
            $result = $query->fetchAll();
            foreach ($result as $restaurant) {
                $all_restaurants[] = new Restaurant(
                    $restaurant['id_resto'], 
                    $restaurant['nom'],  
                    $restaurant['website'] ?? '', 
                    $restaurant['capacity'] ?? 0, 
                    $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0, 
                    $restaurant['adresse'] ?? null,
                    (float) $result['gps_lat'] ?? null,
                    (float) $result['gps_long'] ?? null,
                    self::getDepartementById($restaurant['region_id']),
                    $restaurant['url'] ?? '',
                    self::getTypeCuisineById($restaurant['id_cuisine'])
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
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant" natural left join public."Photo" WHERE nom LIKE :name');
        $query->execute(array('name' => '%'.$name.'%'));
        $result = $query->fetchAll();
        $all_restaurants = [];
        foreach ($result as $restaurant) {
            $all_restaurants[] = new Restaurant(
                $restaurant['id_resto'], 
                $restaurant['nom'], 
                $restaurant['website'] ?? '', 
                $restaurant['capacity'] ?? 0, 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0,
                $restaurant['adresse'] ?? null,
                (float) $result['gps_lat'] ?? null,
                (float) $result['gps_long'] ?? null,
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'] ?? '',
                self::getTypeCuisineById($restaurant['id_cuisine']));
        }
        return $all_restaurants;
    }    
    
    /**
     * recupere tous les types de cuisine
     * @return TypeCuisine[] tableau de type de cuisine
     */
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
     * @return mixed le restaurant en question.
     */
    public static function getLatestRestaurant($user): mixed {
        $query = self::getInstance()->prepare('SELECT nom, id_resto, url, adresse, website, capacity, nb_etoile, id_cuisine, region_id FROM public."Critique" natural join public."Restaurant"  natural left join public."Photo" WHERE mail_user=:user ORDER BY date_test DESC LIMIT 1');
        $query->execute(['user' => $user]);
        $result = $query->fetch();
        if (!$result) {
            return null;
        }
        $restaurant = new Restaurant(
            $result['id_resto'], 
            $result['nom'],  
            $result['website'] ?? '', 
            $result['capacity'] ?? 0, 
            $result['nb_etoile'] != 0 ? $result['nb_etoile'] : 0, 
            (float) $result['gps_lat'] ?? null,
            (float) $result['gps_long'] ?? null,
            self::getDepartementById($result['region_id']),
            $result['url'] ?? '',
            self::getTypeCuisineById($result['id_cuisine']));
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

    /**
     * Récupère les critiques 
     */
    public static function getCritiques():array{
        $query = self::getInstance()->prepare('SELECT * FROM public."Critique" natural join public."Restaurant" join public."Visiteur" on public."Visiteur".mail=public."Critique".mail_user');
        $query->execute();
        $result = $query->fetchAll();
        $all_critiques = [];
        foreach ($result as $critique) {
            $all_critiques[] = new Critique($critique['id_critique'], $critique['message'], new Restaurant($critique['id_resto'],$critique['nom'], '', '', 0, 0, new Departement(0, ''), '', new TypeCuisine(0, '')), new User($critique['mail'], '', $critique['nom_user'], $critique['prenom'], '', array()), $critique['date_test'], $critique['etoiles']);
        }
        return $all_critiques;
    }


    /**
     * recupere une critique en fonction de son id
     * @param mixed $id_critique
     * @return Critique
     */
    public static function getCritique($id_critique): Critique{
        $query = self::getInstance()->prepare('SELECT * FROM public."Critique" WHERE id_critique=:id');
        $query->execute(['id' => $id_critique]);
        $result = $query->fetch();
        $critique = new Critique($result['id_critique'], $result['message'], new Restaurant($result['id_resto'],'', '', '', 0, 0, new Departement(0, ''), '', new TypeCuisine(0, '')), new User('', '', '', '', '', array()), $result['date_test'], $result['etoiles']);
        return $critique;
    }


    /**
     * get les critiques en fonction du restaurant
     * @param mixed $id_resto id restaurant
     * @return Critique[] liste des critiques
     */
    public static function getCritiqueByRestaurant($id_resto): array{
        $query = self::getInstance()->prepare('SELECT * from public."Critique" natural join public."Visiteur" natural join public."Restaurant" where public."Visiteur".mail=public."Critique".mail_user and id_resto=:id');
        $query->execute(['id' => $id_resto]);
        $result = $query->fetchAll();
        $all_critiques = array();
        foreach ($result as $critique) {
            array_push($all_critiques,new Critique($critique['id_critique'], $critique['message'], new Restaurant($critique['id_resto'],$critique['nom'], '', 0, 0, '', 0.0, 0.0, new Departement(0, ''), '', new TypeCuisine(0, '')), new User($critique['mail'], '', $critique['nom_user'], '', '', array()), $critique['date_test'], $critique['etoiles']));
        }
        return $all_critiques;
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
                $restaurant['website'] ?? '', 
                $restaurant['capacity'] ?? 0, 
                $restaurant['nb_etoile'] != 0 ? $restaurant['nb_etoile'] : 0,
                $restaurant['adresse'] ?? null,
                (float) $result['gps_lat'] ?? null,
                (float) $result['gps_long'] ?? null,
                self::getDepartementById($restaurant['region_id']),
                $restaurant['url'] ?? '',
                self::getTypeCuisineById($restaurant['id_cuisine']));
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

   /**
    * ajoute un restaurant à la base de donées
    * @param mixed $name nom du restaurant
    * @param mixed $capacity capacité du restaurant
    * @param mixed $tel numéro de téléphone
    * @param mixed $siret numéro siret
    * @param mixed $website site web
    * @param mixed $typesCuisine type de cuisine
    * @param mixed $region région
    * @param mixed $etoiles nombre d'étoiles
    * @param mixed $horaires horaires
    * @return bool true si l'ajout a réussi, false sinon.
    */
   public static function insertRestaurant($name, $capacity, $tel, $siret, $website, $region, $etoiles, $horaires, $gps_lat, $gps_long, $idCuisine, $adress): bool{
    $query = self::getInstance()->prepare('INSERT INTO public."Restaurant" (nom, capacity, tel, siret, website, region_id, nb_etoile, horaires, gps_lat, gps_long, id_cuisine, adresse) VALUES (:name, :capacity, :tel, :siret, :website, :region, :etoiles, :horaires, :gps_lat, :gps_long, :cuisine, :adress)');
    $result = $query->execute(array('name' => $name, 'capacity' => $capacity, 'tel' => $tel, 'siret' => $siret, 'website' => $website, 'region' => $region, 'etoiles' => $etoiles, 'horaires' => $horaires, 'gps_lat' => $gps_lat, 'gps_long' => $gps_long, 'cuisine' =>  $idCuisine, 'adress' => $adress));
    return $result;
   }

   public static function getOrInsertTypeCuisineByName($name): TypeCuisine  {
    $type = self::getTypeCuisineByName($name);
    if ($type == null) {
        $query = self::getInstance()->prepare('INSERT INTO public."TypeCuisine" (cuisine) VALUES (:name)');
        $result = $query->execute(array('name' => $name));
        if ($result) {
            $type = self::getTypeCuisineByName($name);
        }
    }
    return $type;
   }

   /**
    * insertions des carac d'un restaurants dans la db
    * @param mixed $id_resto id du resto
    * @param mixed $id_carac id de la carac
    * @return bool true si l'ajout a réussi, false sinon.
    */
   public static function insertCaracteriserRestaurant($id_resto, $id_carac): bool{
    if (!isset($id_resto) || !isset($id_carac)){
        return false;
   }
    $query = self::getInstance()->prepare('INSERT INTO public."Caracteriser" (id_carac, id_resto) VALUES (:id_carac, :id_resto)');
    $result = $query->execute(array('id_carac' => $id_carac, 'id_resto' => $id_resto));
    return $result;
   }

   /**
    * get le maximum des id des critiques
    * @return int
    */
   public static function maxCritiqueId():int{
    $query = self::getInstance()->prepare('SELECT MAX(id_critique) FROM public."Critique"');
    $query->execute();
    $result = $query->fetch();
    if ($result['max']== null){
        return 0;
    }
    return $result['max'];
   }

   /**
    * ajout une critique à la base de données
    * @param mixed $id_resto id du resto
    * @param mixed $id_critique id critique
    * @param mixed $message l'avis
    * @param mixed $date la date test
    * @param mixed $etoiles le nb etoiles
    * @param mixed $mail mail user
    * @return bool true si l'ajout a réussi, false sinon.
    */
   public static function addCritique($id_resto, $id_critique, $message, $etoiles, $mail){
    $query = self::getInstance()->prepare('INSERT INTO public."Critique" (id_resto, id_critique, message, date_test, etoiles, mail_user) VALUES (:id_resto, :id_critique, :message, CURRENT_DATE, :etoiles, :mail)');
    $result = $query->execute(array('id_resto' => $id_resto, 'id_critique' => $id_critique, 'message' => $message, 'etoiles' => $etoiles, 'mail' => $mail));
    return $result;
   }

   /**
    * ajout d'un restaurant aux favoris
    * @param mixed $id_resto id du resto
    * @param mixed $mail mail user
    * @return bool true si l'ajout a réussi, false sinon.
    */
   public static function addFavoris($id_resto, $mail):bool{
    $query = self::getInstance()->prepare('INSERT INTO public."aimer" (id_resto, mail) VALUES (:id_resto, :mail)');
    $result = $query->execute(array('id_resto' => $id_resto, 'mail' => $mail));
    return $result;
   }

   /**
    *  get le type favoris (le plus présent dans les favoris)
    * @param mixed $mail mail user
    * @return mixed id du type de cuisine
    */
   public static function typeFavoris($mail){
    $query = self::getInstance()->prepare('SELECT r.id_cuisine, typeC.cuisine, COUNT(*) AS nombre_fav
    FROM public."Restaurant" r
    JOIN public."TypeCuisine" typeC ON r.id_cuisine = typeC.id
    JOIN public."aimer" a ON r.id_resto = a.id_resto
    WHERE a.mail = :mail
    GROUP BY r.id_cuisine, typeC.cuisine
    ORDER BY nombre_fav DESC
    LIMIT 1;    
    ');
    $query->execute(['mail' => $mail]);
    $result = $query->fetch();
    return $result;
   }

   /**
    * recupere les meilleurs restaurants en faisant la moyenne des etoiles des critiques sur un restaurant
    * @return array
    */
   public static function getFavorisByStars(){
    $stmt =   'SELECT r.id_resto, r.nom, r.adresse, COALESCE(AVG(c.etoiles), 0) AS moyenne_etoiles, COALESCE(COUNT(c.id_critique), 0) AS nombre_critiques
    FROM public."Restaurant" r
    LEFT JOIN public."Critique" c ON r.id_resto = c.id_resto
    GROUP BY r.id_resto, r.nom
    ORDER BY moyenne_etoiles DESC limit 10;
    ';
    $query = self::getInstance()->prepare($stmt);
    $query->execute();
    $result = $query->fetchAll();
    return $result;
}

    /**
     * propose des nom de restaurant en suggestion
     * @return array String nom des restaurants
     */
   public static  function getSuggestions($initialSequence, $limit) {
    $stmt = 'SELECT nom FROM public."Restaurant" WHERE nom LIKE :initialSequence LIMIT :limit';
    $query = self::getInstance()->prepare($stmt);
    $query->execute(['initialSequence' => $initialSequence . '%', 'limit' => $limit]);
    $result = $query->fetchAll();
    return $result;
   }
}
?>