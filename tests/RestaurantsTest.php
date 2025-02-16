<?php
use classes\model\TypeCuisine;
use PHPUnit\Framework\TestCase;
use classes\model\Restaurant;
use classes\model\Departement;
require_once 'vendor/autoload.php';


class RestaurantsTest extends TestCase {
    public function testGetId(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals(1, $restaurant->getId());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals(2, $restaurant2->getId());
    }
    public function testGetNom(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals("McDonald's", $restaurant->getNom());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals("KFC", $restaurant2->getNom());
    }
    public function testGetAdresse(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals("1 rue de la paix", $restaurant->getAdresse());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals("2 rue de la paix", $restaurant2->getAdresse());
    }
    public function testGetWebsite(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals("www.mcdonalds.fr", $restaurant->getWebsite());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals("www.kfc.fr", $restaurant2->getWebsite());
    }
    public function testGetCapacity(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals(100, $restaurant->getCapacity());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals(100, $restaurant2->getCapacity());
    }
    public function testGetNbEtoile(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals(0, $restaurant->getNbEtoile());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals(0, $restaurant2->getNbEtoile());

    }
    public function testGetTypeCuisine(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals(new TypeCuisine(1, 'fastfood'), $restaurant->getTypeCuisine());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals(new TypeCuisine(1, 'fastfood'), $restaurant2->getTypeCuisine());
    }
    public function testGetDepartement(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals(new Departement(75, "Paris"), $restaurant->getDepartement());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals(new Departement(75, "Paris"), $restaurant2->getDepartement());
    }

    public function testGetRegion(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals("Paris", $restaurant->getRegion());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals("Paris", $restaurant2->getRegion());
    }
    
    public function testGetPhotos(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals('', $restaurant->getPhotos());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals('', $restaurant2->getPhotos());
    }

    public function testToString(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertEquals("McDonald's", $restaurant->__toString());
        $restaurant2 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertEquals("KFC", $restaurant2->__toString());
    }
    public function testEquals(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $restaurant2 = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 0,  new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood'));
        $this->assertTrue($restaurant->equals($restaurant2));
        $restaurant3 = new Restaurant(2, "KFC", "2 rue de la paix", "www.kfc.fr", 100, 0, new Departement(75, "Paris"), '', new TypeCuisine(1, 'fastfood') );
        $this->assertFalse($restaurant->equals($restaurant3));
    }
    
}
?>