<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;

?>
<!DOCTYPE html>
<html lang="en">
<?php
include('interfaces-role/global/head.php'); 
title_html('Profil visiteur');
link_to_css('static/profil.css');
?>
    <body>
    <?php include('interfaces-role/global/header_connected.php');
    $user = DBConnector::getUser($_SESSION['user']['username']) ?>
        <main>
            <div class="profile-container">
            <h2>Mon Profil</h2>
            <?php
            if (isset($_GET['success'])) {
                echo "<p style='color: green;'>Profil mis à jour avec succès !</p>";
            } elseif (isset($_GET['error'])) {
                echo "<p style='color: red;'>Erreur lors de la mise à jour.</p>";
            }
            ?>
                <form action="utils/gestion-data/update-profil.php" method="POST">
                    <div class="input-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" value="<?= $user->getPrenom()?>" required>
                    </div>
                    <div class="input-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= $user->getNom() ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" value="<?= $user->getPassword() ?>">
                    </div>
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
            <div class="container">
                <h2>Mon activité</h2>
                <?php $critiques = DBConnector::getCritiquesByUser($_SESSION['user']['username']);
                echo "<p>Il y a " . count($critiques) . "<a href='mescritiques.php'> critiques enregistrées.</a></p>";
                $favoris = $favoris = DBConnector::getFavorisByUser($_SESSION['user']['username']);
                echo "<p>Il y a " . count($favoris) . " restaurants enregistrés dans <a href='favoris.php'> vos favoris.</a></p>";
                $type = DBConnector::typeFavoris($_SESSION['user']['username']);
                if ($type == null){
                    $type = "non renseigné";
                }
                else {
                    $type = $type['cuisine'];
                }
                echo "<p> Votre type favoris est ". $type . "</p>"?>

            </div>
        </main>
    <?php include('interfaces-role/global/footer.php'); ?>
    </body>
</html>