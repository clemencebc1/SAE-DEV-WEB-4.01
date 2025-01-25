<?php
use PHPUnit\Framework\TestCase;
use model\Restaurant;

class testsRestaurants extends TestCase {
    public function testGetId(){
        $restaurant = new Restaurant(1, "McDonald's", "1 rue de la paix", "www.mcdonalds.fr", 100, 1, ["fastfood"], new Departement(1, "Paris"));
        $this->assertEquals(1, $restaurant->getId());
    }
}
?>