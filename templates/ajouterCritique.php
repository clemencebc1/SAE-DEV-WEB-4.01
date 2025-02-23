<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
UserTools::requireLogin();
?>

<!DOCTYPE html>
<html lang="fr">
<?php
include('interfaces-role/global/head.php'); 
title_html('Ajouter critique');
link_to_css('static/modifierCritique.css');
?>
<body>
        <?php include('interfaces-role/global/header_connected.php'); 
        $id_resto = intval($_GET['id']);
        $restaurant = DBConnector::getRestaurantById($id_resto)?>
        <main>
            <div class="container">
            <h1>Ajouter critique</h1>
            <form method="POST" action="utils/gestion-data/add-critique.php">
                <input type="hidden" name="id_resto" value="<?= $restaurant->getId() ?>">
                <h2>Restaurant <?php echo $restaurant->getNom(); ?></h2>
                <label>Votre avis</label>
                <textarea name="message" rows="4" cols="50"></textarea><br>
                <label for="etoiles">Etoiles</label>
                <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <input type="radio" id="star<?= $i ?>" name="note" value="<?= $i ?>">
                    <label for="star<?= $i ?>">★</label>
                <?php endfor; ?>
                </div><br>
                <button type="submit">Enregistrer la critique</button>
            </form>
            <a href="decouverte.php">Annuler</a>
            </div>
        </main>

        <?php include('interfaces-role/global/footer.php'); ?>
    </body>
</html>