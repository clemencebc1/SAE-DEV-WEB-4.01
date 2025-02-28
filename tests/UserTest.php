<?php
use classes\model\User;
use PHPUnit\Framework\TestCase;
require_once 'vendor/autoload.php';

class UserTest extends TestCase {
    public function testGetMail(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin", array());
        $this->assertEquals("user@mail.com", $user->getMail());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur", array());
        $this->assertEquals("user2@mail.com", $user2->getMail());
    }
    public function testGetNom(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin", array());
        $this->assertEquals("Doe", $user->getNom());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur", array());
        $this->assertEquals("Dupont", actual: $user2->getNom());
    }
    public function testGetPrenom(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin", array());
        $this->assertEquals("John", $user->getPrenom());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur", array());
        $this->assertEquals("Jean", actual: $user2->getPrenom());
    }
    public function testGetRole(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin", array());
        $this->assertEquals("admin", $user->getRole());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur", array());
        $this->assertEquals("visiteur", $user2->getRole());
    }

    public function testGetTester(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin", array());
        $this->assertEquals(array(), $user->getTester());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur", array());
        $this->assertEquals(array(), $user2->getTester());
    }

    public function testGetPassword(){
        $user = new User("user@mail.com", "password", "Doe", "John", "admin", array());
        $this->assertEquals("password", $user->getPassword());
        $user2 = new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur", array());
        $this->assertEquals("motdepasse", $user2->getPassword());
    }
}
?>