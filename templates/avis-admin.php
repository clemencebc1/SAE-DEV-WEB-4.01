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
link_to_css('static/mescritiques.css');
?>
    <body>
        <?php include 'interfaces-role/global/header_connected.php'; ?>
        <main>
            <?php 
            if (isset($_GET['success'])&&$_GET['success']==1) {
                echo "<p style='color: green;'>Critique supprimée avec succès !</p>";
            }
            f (isset($_GET['error'])&&$_GET['error']==1) {
                echo "<p style='color: red;'>Erreur lors de la suppression</p>";
            }
            $critiques = DBConnector::getCritiques();
            $render = new CritiqueRender($critiques);
            $render->critique_admin();
            ?>
        </main>
        <?php include 'interfaces-role/global/footer.php';  ?>
    </body>
</html>