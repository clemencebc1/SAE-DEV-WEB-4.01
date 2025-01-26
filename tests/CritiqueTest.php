<?php
use model\Critique;
use model\Departement;
use model\Restaurant;
use model\User;
use PHPUnit\Framework\TestCase;
require_once 'vendor/autoload.php';

class CritiqueTest extends TestCase {
    public function testGetId(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris")), new User("user@mail.com", "password", "Doe", "John", "admin"));
        $this->assertEquals(1, $critique->getId());
        $critique2 = new Critique(2, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris")), new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur"));
        $this->assertEquals(2, $critique2->getId());
    }
    public function testGetMessage(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris")), new User("user@mail.com", "password", "Doe", "John", "admin"));
        $this->assertEquals("C'était délicieux", $critique->getMessage());
        $critique2 = new Critique(2, "C'était pas très bon", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris")), new User("user2@mail.com", "motdepasse", "Dupont", "Jean", "visiteur"));
        $this->assertEquals("C'était pas très bon", $critique2->getMessage());
    }
}
?>