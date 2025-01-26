<?php
use PHPUnit\Framework\TestCase;
use model\Restaurant;
use model\Departement;
require_once 'vendor/autoload.php';


class RestaurantsTest extends TestCase {
    public function testGetId(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(1, $restaurant->getId());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(2, $restaurant2->getId());
    }
    public function testGetNom(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals("McDonald's", $restaurant->getNom());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals("KFC", $restaurant2->getNom());
    }
    public function testGetAdresse(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals("1 rue de la paix", $restaurant->getAdresse());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals("2 rue de la paix", $restaurant2->getAdresse());
    }
    public function testGetWebsite(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals("www.mcdonalds.fr", $restaurant->getWebsite());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals("www.kfc.fr", $restaurant2->getWebsite());
    }
    public function testGetCapacity(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(100, $restaurant->getCapacity());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(100, $restaurant2->getCapacity());
    }
    public function testGetNbEtoile(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(1, $restaurant->getNbEtoile());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(1, $restaurant2->getNbEtoile());
    }
}
?>