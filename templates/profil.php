<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();

?>
<!DOCTYPE html>
<html lang="en">
<?php
include('interfaces-role/global/head.php'); 
title_html('Profil visiteur');
link_to_css('static/profil.css');
?>
    <body>
    <?php include('interfaces-role/global/header_connected.php'); ?>
        <main>
            <div class="profile-container">
            <h2>Mon Profil</h2>
                <form action="update_profile.php" method="POST">
                    <div class="input-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="input-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </main>
    <?php include('interfaces-role/global/footer.php'); ?>
    </body>
</html>