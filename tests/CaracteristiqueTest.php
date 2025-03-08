<?php
use classes\model\Caracteristique;
use PHPUnit\Framework\TestCase;
class CaracteristiqueTest extends TestCase {
    public function testGetId(){
        $caracteristique = new Caracteristique(1, "wifi");
        $this->assertEquals(1, $caracteristique->getId());
        $caracteristique2 = new Caracteristique(2, "terrasse");
        $this->assertEquals(2, $caracteristique2->getId());
    }
    public function testGetNom(){
        $caracteristique = new Caracteristique(1, "wifi");
        $this->assertEquals("wifi", $caracteristique->getMessage());
        $caracteristique2 = new Caracteristique(2, "terrasse");
        $this->assertEquals("terrasse", $caracteristique2->getMessage());
    }

}
?>