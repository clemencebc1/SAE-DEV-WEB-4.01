<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\CritiqueRender;
UserTools::requireLogin();

?>

<!DOCTYPE html>
<html lang="fr">
<?php 
include 'interfaces-role/global/head.php'; 
title_html('Connexion');
link_to_css('');
?>
    <body>

    </body>
</html>