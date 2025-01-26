<?php
use model\User;
use PHPUnit\Framework\TestCase;
require_once 'vendor/autoload.php';

class UserTest extends TestCase {
    public function testGetMail(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin");
        $this->assertEquals("user@mail.com", $user->getMail());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur");
        $this->assertEquals("user2@mail.com", $user2->getMail());
    }
    public function testGetNom(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin");
        $this->assertEquals("Doe", $user->getNom());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur");
        $this->assertEquals("Dupont", actual: $user2->getNom());
    }
    public function testGetPrenom(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin");
        $this->assertEquals("John", $user->getPrenom());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur");
        $this->assertEquals("Jean", actual: $user2->getPrenom());
    }
    public function testGetRole(){
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur");
        $this->assertEquals("visiteur", $user2->getRole());
        $user = new User("user@mail.com", "password", "Doe", "John", "admin");
        $this->assertEquals("admin", $user->getRole());
    }
}
?>