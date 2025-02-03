<?php
declare(strict_types=1);
namespace utils\connection;
use \PDO;
use \Exception;
use model\Restaurant;

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

    public static function subscribe($username, $password, $nom, $prenom, $visiteur): bool {
        $hash = hash('sha1', $password);
        $query = self::getInstance()->prepare('INSERT INTO public."Visiteur" (MAIL, PASSWORD, NOM, PRENOM, ROLE) VALUES (:username, :password, :nom, :prenom, :visiteur)');
        $result = $query->execute(array('username' => $username, 'password' => "\x" . $hash, 'nom' => $nom, 'prenom' => $prenom, 'visiteur' => $visiteur));
        return $result;
    }

    public static function getAllRestaurants(): array {
        $query = self::getInstance()->prepare('SELECT * FROM public."Restaurant"');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
    public static function getAllType(): array {
        $query = self::getInstance()->prepare('SELECT * FROM public."TypeCuisine"');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function getLatestRestaurant($user): array {
        $query = self::getInstance()->prepare('SELECT nom, id_resto, url FROM public."Critique" natural join public."Restaurant" natural join public."Photo" WHERE mail_user=:user ORDER BY date_test DESC LIMIT 1');
        $query->execute(['user' => $user]);
        $result = $query->fetch();
        return $result;
    }

    public static function getCritiquesByUser($user): array {
        $query = self::getInstance()->prepare('SELECT nom, id_resto, message, date_test, id_critique FROM public."Critique" natural join public."Restaurant" WHERE mail_user=:user ORDER BY date_test DESC');
        $query->execute(['user' => $user]);
        $result = $query->fetch();
        return $result;
    }

}
?>