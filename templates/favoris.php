<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\Restaurant_render;
UserTools::requireLogin();

?>
<!DOCTYPE html>
<html lang="en">
<?php
include('global/head.php'); 
title_html('Favoris');
link_to_css('static/favoris.css');
?>
<body>
<?php include('global/header_connected.php'); ?>
<main>

</main>
<?php include('global/footer.php'); ?>
</body>
</html>