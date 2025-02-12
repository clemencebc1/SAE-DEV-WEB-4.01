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
      <form action="utils/gestion-data/upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Choisissez un fichier (JSON):</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="submit" value="Uploader">
      </form> 
    </main>
    <?php include('interfaces-role/global/footer.php'); ?>
  </body>
</html>