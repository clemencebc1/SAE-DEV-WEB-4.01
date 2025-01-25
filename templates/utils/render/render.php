<?php
declare(strict_types=1);
namespace utils\render;

abstract class Render {
    protected mixed $objects;
    
    function __construct(array $objects){
        $this->objects = $objects;
    }
    abstract function render(): void;
}


?>