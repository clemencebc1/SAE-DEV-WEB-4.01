<?php
use classes\model\Critique;
use classes\model\Departement;
use classes\model\Restaurant;
use classes\model\TypeCuisine;
use classes\model\User;
use PHPUnit\Framework\TestCase;
require_once 'vendor/autoload.php';

class CritiqueTest extends TestCase {
    public function testGetId(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), '2024-09-10', 5);
        $this->assertEquals(1, $critique->getId());
        $critique2 = new Critique(2, "C'était mauvais", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), '2024-10-10', 1);
        $this->assertEquals(2, $critique2->getId());
    }
    public function testGetMessage(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), '2024-09-10', 5);
        $this->assertEquals("C'était délicieux", $critique->getMessage());
        $critique2 = new Critique(2, "C'était mauvais", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), '2024-10-10', 1);
        $this->assertEquals("C'était mauvais", $critique2->getMessage());
    }

    public function testGetRestaurant(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), '2024-09-10', 5);
        $this->assertEquals(new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), $critique->getRestaurant());
        $critique2 = new Critique(2, "C'était mauvais", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), '2024-10-10', 1);
        $this->assertEquals(new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), $critique2->getRestaurant());
        }
    

    public function testGetNote(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), '2024-09-10', 5);
        $this->assertEquals(5, $critique->getNote());
        $critique2 = new Critique(2, "C'était mauvais", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), '2024-10-10', 1);
        $this->assertEquals(1, $critique2->getNote());
    }

    public function testGetDateTest(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), '2024-09-10', 5);
        $this->assertEquals('2024-09-10', $critique->getDateTest());
        $critique2 = new Critique(2, "C'était mauvais", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), '2024-10-10', 1);
        $this->assertEquals('2024-10-10', $critique2->getDateTest());
    }

    public function testGetUser(){
        $critique = new Critique(1, "C'était délicieux", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), '2024-09-10', 5);
        $this->assertEquals(new User('joe@mail.com', 'mdp', 'joe', 'dupont', 'visiteur', array()), $critique->getUser());
        $critique2 = new Critique(2, "C'était mauvais", new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1,  new Departement(1, "Paris"), '', new TypeCuisine(1, 'fastfood')), new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), '2024-10-10', 1);
        $this->assertEquals(new User('kevin@mail.com', 'mdp', 'kevin', 'dupont', 'visiteur', array()), $critique2->getUser());
    }
}
?>