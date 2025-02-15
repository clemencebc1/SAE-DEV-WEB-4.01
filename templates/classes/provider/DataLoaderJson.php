<?php
namespace classes\provider;
use classes\provider\DataLoaderInterface;

final class DataLoaderJson implements DataLoaderInterface {
    private $data;
    private $url;
    public function __construct(String $source){
        $content = file_get_contents($source);
        $this->data = (array) json_decode($content);
        $this->url = $source;
    }
    function getData(){
        return $this->data;
    }

    /**
     * ajout des données dans la base de données
     * @param mixed $pdo pour ajouter les données dans la base de données
     * @return void
     */
    function insertData($pdo){
        foreach($this->data as $question){
            var_dump($question);
            echo "<br>";
        }
    }
}
?>