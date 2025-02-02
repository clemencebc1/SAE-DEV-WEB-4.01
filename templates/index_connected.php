<?php
session_start();
require_once 'utils/autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
UserTools::requireLogin();

$dernier_restaurant = DBConnector::getLatestRestaurant($_SESSION['user']['username']);

$categories = DBConnector::getAllType();
?>

<!DOCTYPE html>
<html lang="fr">
<?php
include('global/head.php'); 
title_html('Connected');
link_to_css('static/index_connected.css');
?>
    <body>
        <?php include('global/header_connected.php'); ?>
        <main>

        <div class="container">
        <div class="last-review">
            <h2>Vous avez testé récemment ? <a href="#">Laissez un avis !</a></h2>
            <div class="restaurant-card">
                <img src=<?php echo "'" . $dernier_restaurant['url'] . "'" ?> alt="">
                <div class="restaurant-info">
                    <h3><?php echo $dernier_restaurant['nom'] ?></h3>
                    <p>Orléans</p>
                </div>
            </div>
        </div>

        <div class="search-section">
            <div class="search-bar">
                <input type="text" id="search" placeholder="Rechercher un restaurant ...">
                <button>Rechercher</button>
            </div>

            <div class="filters">
                <div class="dropdown">
                    <button class="dropbtn">🍽️ Restaurant ▼</button>
                    <div class="dropdown-content">
                        <?php foreach ($categories as $categorie){
                            echo "<a href='#'>" . $categorie['type'] . "</a>";
                            }?>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropbtn">🥄 Cuisine ▼</button>
                    <div class="dropdown-content">
                        <a href="#">Italien</a>
                        <a href="#">Français</a>
                        <a href="#">Végétarien</a>
                    </div>
                </div>

            </div>

            <div class="selected-filters">
                <span class="filter-tag">Italien <span class="close">&times;</span></span>
                <span class="filter-tag">Orléans <span class="close">&times;</span></span>
                <span class="filter-tag">Végétarien <span class="close">&times;</span></span>
            </div>
        </div>
    </div>
    </main>
    <script>
            document.getElementById('search').addEventListener('input', function() {
                let query = this.value.toLowerCase();
                document.querySelectorAll('.category-box').forEach(box => {
                    box.style.display = box.innerText.toLowerCase().includes(query) ? '' : 'none';
                });
            });
    </script>
    <?php include('global/footer.php'); ?>
    </body>
</html>
