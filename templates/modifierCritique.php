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
include('interfaces-role/global/head.php'); 
title_html('Modifier critique');
link_to_css('static/modifierCritique.css');
?>
<body>
        <?php include('interfaces-role/global/header_connected.php'); 
        if (isset($_POST['id_critique'])) {
            $id_critique = intval($_POST['id_critique']);
        }
        else {
            $id_critique = intval($_GET['id_critique']);
        }
        $critique = DBConnector::getCritique($id_critique)?>
        <main>
            <div class="container">
            <h1>Modifier critique</h1>
            <form method="POST" action="utils/gestion-data/modify-critique.php">
                <input type="hidden" name="id_critique" value="<?= $id_critique; ?>">
                <textarea name="message" rows="4" cols="50"><?= htmlspecialchars($critique->getMessage()); ?></textarea><br>
                <label for="etoiles">Etoiles</label>
                <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <input type="radio" id="star<?= $i ?>" name="note" value="<?= $i ?>" <?= ($critique->getNote() == $i) ? 'checked' : '' ?>>
                    <label for="star<?= $i ?>">★</label>
                <?php endfor; ?>
                </div><br>
                <button type="submit">Enregistrer les modifications</button>
            </form>
            <a href="critiques.php">Annuler</a>
            </div>
        </main>

        <?php include('interfaces-role/global/footer.php'); ?>
    </body>
</html>