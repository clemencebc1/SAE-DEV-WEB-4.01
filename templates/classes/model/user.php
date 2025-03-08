<?php
declare(strict_types=1);
namespace classes\model;

class User {
    private string $mail;
    private string $password;
    private string $nom;
    private string $prenom;
    private string $role;
    private array $tester;
    function __construct(string $mail, string $password, string $nom, string $prenom, string $role, array $tester){
        $this->mail =$mail;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->tester = $tester;
    }

    /**
     * Get le mail user
     * @return string
     */
    function getMail(): string {
        return $this->mail;
    }

    /**
     * Get le password user
     * @return string
     */
    function getPassword(): string {
        return $this->password;
    }

    /**
     * Get le nom user
     * @return string
     */
    function getNom(): string {
        return $this->nom;
    }

    /**
     * Get le prenom user
     * @return string
     */
    function getPrenom():string{
        return $this->prenom;
    }

    /**
     * Get le role user
     * @return string
     */
    function getRole():string {
        return $this->role;
    }

    /**
     * Get les restaurants testes par l'utilisateur
     * @return array
     */
    function getTester(): array {
        return $this->tester;
    }
}
?>