<?php
session_start();
require_once '../../autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;

$search = isset($_GET['query']) ? trim($_GET['query']) : "";
$restaurants = DBConnector::searchRestaurantByCity($search);
$name = DBConnector::searchRestaurantByName($search);

if (count($restaurants) > 0) {
    echo "<ul>";
    foreach ($restaurants as $resto) {
        echo "<li>" . htmlspecialchars($resto->getNom(), ENT_QUOTES) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun restaurant trouvé.</p>";
}
?>