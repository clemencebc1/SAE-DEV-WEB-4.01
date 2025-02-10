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
    function getTester(): array {
        return $this->tester;
    }
}
?>