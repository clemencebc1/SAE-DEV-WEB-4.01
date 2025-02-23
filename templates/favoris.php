<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\Restaurant_render;
UserTools::requireLogin();

$favoris = DBConnector::getFavorisByUser($_SESSION['user']['username']);
$favoris_render = new Restaurant_render($favoris);

?>
<!DOCTYPE html>
<html lang="en">
<?php
include('interfaces-role/global/head.php'); 
title_html('Favoris');
link_to_css('static/favoris.css');
?>
<body>
<?php include('interfaces-role/global/header_connected.php'); ?>
    <main>
        <div id="restaurants-favoris">
            <?php $favoris_render->iconRestaurant(true)?>
        </div>
        <h3>Un coup de foudre ?</h3>
        <h3 id="enregistrer">Enregistrer un <a href='decouverte.php'>nouveau coup de coeur</a></h3>

        
    </main>
<?php include('interfaces-role/global/footer.php'); ?>
</body>
</html>