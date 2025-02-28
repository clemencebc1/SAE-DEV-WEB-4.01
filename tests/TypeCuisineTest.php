<?php
use classes\model\TypeCuisine;
use PHPUnit\Framework\TestCase;
require_once 'vendor/autoload.php';

class TypeCuisineTest extends TestCase {
    public function testGetId(){
        $typeCuisine = new TypeCuisine(1, "fastfood");
        $this->assertEquals(1, $typeCuisine->getId());
        $typeCuisine2 = new TypeCuisine(2, "chinois");
        $this->assertEquals(2, $typeCuisine2->getId());
    }
    public function testGetNom(){
        $typeCuisine = new TypeCuisine(1, "fastfood");
        $this->assertEquals("fastfood", $typeCuisine->getCuisine());
        $typeCuisine2 = new TypeCuisine(2, "chinois");
        $this->assertEquals("chinois", $typeCuisine2->getCuisine());
    }

}
?>