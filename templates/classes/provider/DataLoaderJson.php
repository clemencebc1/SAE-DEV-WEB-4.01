<?php
namespace classes\provider;
use classes\provider\DataLoaderInterface;

final class DataLoaderJson implements DataLoaderInterface {
    private $data;
    private $url;
    public function __construct(String $source){
        $content = file_get_contents($source);
        $this->data = json_decode($content);
    }
    function getData(){
        return $this->data;
    
    }
    function insertData($pdo){
        foreach($this->data as $question){
            var_dump($question);
        }
    }
}
?>