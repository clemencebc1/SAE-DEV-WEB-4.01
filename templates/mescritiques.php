<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\critiqueRender;
UserTools::requireLogin();
?>

<!DOCTYPE html>
<html lang="fr">
<?php
include('interfaces-role/global/head.php'); 
title_html('Mes critiques');
link_to_css('static/mescritiques.css');
?>
<body>
        <?php include('interfaces-role/global/header_connected.php'); ?>
        <main>
            <h1>Vos dernières critiques gastronomiques</h1>
            
            <?php
            if (isset($_GET['success'])&&$_GET['success']==1) {
                echo "<p style='color: green;'>Critique supprimée avec succès !</p>";
            }
            elseif (isset($_GET['success'])&&$_GET['success']==2){
                echo "<p style='color: green;'>Critique ajoutée avec succès !</p>";
            } 
            elseif(isset($_GET['success'])&&$_GET['success']==3){
                echo "<p style='color: green;'>Critique modifiée avec succès !</p>";
            } elseif (isset($_GET['error'])) {
                echo "<p style='color: red;'>Erreur lors de la suppression.</p>";
            }
            $critiques = DBConnector::getCritiquesByUser($_SESSION['user']['username']);
            $render = new CritiqueRender($critiques);
            $render->render();
            ?>
        
        </main>

        <?php include('interfaces-role/global/footer.php'); ?>
    </body>
</html>