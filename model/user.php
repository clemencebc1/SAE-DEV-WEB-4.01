<?php
declare(strict_types=1);
namespace model;

class User {
    private string $mail;
    private string $password;
    private string $nom;
    private string $prenom;
    private string $role;
    function __construct(string $mail, string $password, string $nom, string $prenom, string $role){
        $this->mail =$mail;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    function getMail(): string {
        return $this->mail;
    }
    function getNom(): string {
        return $this->nom;
    }
    function getPrenom():string{
        return $this->prenom;
    }
    function getRole():string {
        return $this->role;
    }
}
?>