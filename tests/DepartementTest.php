<?php
use model\Departement;
use PHPUnit\Framework\TestCase;
require_once 'vendor/autoload.php';

class DepartementTest extends TestCase {
    public function testGetId(){
        $departement = new Departement(1, "Paris");
        $this->assertEquals(1, $departement->getId());
        $departement2 = new Departement(2, "Seine-et-Marne");
        $this->assertEquals(2, $departement2->getId());
    }
    public function testGetNomdep(){
        $departement = new Departement(1, "Paris");
        $this->assertEquals("Paris", $departement->getNomdep());
        $departement2 = new Departement(2, "Seine-et-Marne");
        $this->assertEquals("Seine-et-Marne", $departement2->getNomdep());
    }
}

?>