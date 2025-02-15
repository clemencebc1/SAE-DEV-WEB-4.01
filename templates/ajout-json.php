<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
?>

<!DOCTYPE html>
<html lang="fr">
  <?php
include('interfaces-role/global/head.php'); 
title_html('Ajout JSON');
link_to_css('static/ajout-json.css');
?>
  <body>
    <?php include('interfaces-role/global/header_connected.php')?>
    <main>
      <div>
        <?php if (isset($_GET['upload']) && $_GET['upload'] == 'success') {
          echo "<p class='success' style='color: green;'>Le fichier a été téléchargé et mis en base de données avec succès</p>";
        } else if (isset($_GET['upload']) && $_GET['upload'] == 'error') {
          echo "<p class='error' style='color: red;'>Erreur lors du téléchargement du fichier</p>";
        }
        else if (isset($_GET['upload']) && $_GET['upload'] == 'nofile')  {
          echo "<p class='error' style='color: red;'>Aucun fichier n'a été téléchargé</p>";
        }
        ?>
        <h2>Ajout de données à partir d'un fichier</h2>
      </div>
      <div id="formulaire">
        <form action="utils/gestion-data/upload.php" method="post" enctype="multipart/form-data">
          <label for="file">Choisissez un fichier (JSON):</label>
          <input type="file" name="file" id="file">
          <input type="submit" name="submit" value="Uploader">
        </form> 
      </div>
    </main>
    <?php include('interfaces-role/global/footer.php'); ?>
  </body>
</html>