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
<html lang="fr">
<?php
include('interfaces-role/global/head.php'); 
title_html('Connected');
link_to_css('static/index_connected.css');
?>
    <body>
        <?php include('interfaces-role/global/header_connected.php'); ?>
    <main>
        <?php if (UserTools::isVisiteur()){
            include('interfaces-role/visiteur/index_connected.php');
        }
        if (UserTools::isAdmin()){
            include('interfaces-role/admin/index_connected.php');
        } ?>
    </main>
    <script>
            document.getElementById('search').addEventListener('input', function() {
                let query = this.value.toLowerCase();
                document.querySelectorAll('.category-box').forEach(box => {
                    box.style.display = box.innerText.toLowerCase().includes(query) ? '' : 'none';
                });
            });
    </script>
    <?php include('interfaces-role/global/footer.php'); ?>
    </body>
</html>
