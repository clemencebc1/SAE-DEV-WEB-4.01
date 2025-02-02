<?php
namespace utils\connection;
// use \PDO;
use utils\connection\DBconnector;


class UserTools {

    /**
     * cree une connexion avec la base de données
     * @param mixed $username 
     * @param mixed $password
     */
    private static function checkDB($username, $password): mixed {
        $result = DBconnector::checkDB($username, $password);
        return $result;
    }

    /**
     * connecte l'utilisateur à la base de données (à son compte)
     * @param mixed $username
     * @param mixed $password
     * @return bool true si possède un compte/bon mdp, false sinon
     */
    public static function login($username, $password): bool {
        $user = self::checkDB($username, $password);
        $status = false;
        if ($user) {
            $_SESSION['user'] = array('username' => $username, 'token' => self::generateToken(), 'role' => $user['role']);
            $status = true;
        }
        return $status;
    }
 
    /**
     * genere un token pour l'utilisateur
     * @return string
     */
    public static function generateToken(): string {
        $token = bin2hex(random_bytes(length: 32));
        setcookie('token', $token, time() + 3600);
        return $token;
    }

    /**
     * verifie la validité du token
     * @param mixed $token
     * @return bool
     */
    public static function checkTokenValidity($token): bool {
        $validity = true;
        if (empty($_COOKIE['token'])) {
            $validity = false;
        }else if ($token !== $_COOKIE['token']) {
            $validity = false;
        }
        return $validity;
    }

    /**
     * deconnexion de l'utilisateur
     * @return void
     */
    public static function logout(): bool {
        unset($_SESSION['user']);
        return true;
    }


    public static function isLogged(): bool {
        return isset($_SESSION['user']);
    }

    /**
     * verifie si l'utilisateur est connecté pour acceder a la page
     * @return void
     */
    public static function requireLogin(): void {
        if (!self::isLogged()) {
            header('Location: connexion.php');
            exit();
        }
    }


    // Getters
    public static function getUserToken(): mixed {
        return $_SESSION['user']['token'];
    }

    public static function getUserRole(): mixed {
        return $_SESSION['user']['role'];
    }
}
?>