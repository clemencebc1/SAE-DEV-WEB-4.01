<?php 
    session_start();
    require_once 'autoloader.php';
    Autoloader::register();
    use utils\connection\DBconnector;
    $categories = DBConnector::getAllType();
?>

<!DOCTYPE html>
    <html lang="fr">
        <?php
            include 'interfaces-role/global/head.php';
            title_html('Accueil');
            link_to_css('static/accueil.css');
            link_to_js('static/js/boutons-bar.js');
        ?>
        <body>
            <?php include('interfaces-role/global/header.php'); ?>
            <h1>Bienvenue sur <span style="color: orange;">IUTables’O</span>, votre guide culinaire à Orléans !</h1>
            <div class="title"> 
                <h2> Une petite faim ? </h2>
            </div>
            <main>
                <section class="search">
                    <div class="search-bar">
                        <img src="img/loupe.png" alt="Recherche" class="search-icon">
                        <input type="search" id="input-search" placeholder="Rechercher un restaurant" />
                        <button type="submit" id="button-search"><a href="decouverte.php">Rechercher</a></button>
                    </div>
                    <div class="filters">
    

                <div class="dropdown">
                    <button class="dropbtn">🥄 Cuisine ▼</button>
                    <div class="dropdown-content">
                    <?php 
                        $cpt = count($categories);
                        if (count($categories)>5){
                            $cpt = 5;
                        }
                    
                        for ($i = 0; $i < $cpt; $i++) {
                            $cuisine = $categories[$i]->getCuisine();
                            echo "<a href='#' class='category-item' data-cuisine='" . $cuisine . "'>" . $cuisine . "</a>";
                        }?>
                    </div>
                </div>
            </div>

            <div id="selected-filters"></div>
            <svg class="separator" width="600" height="40" viewBox="0 0 100 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,10 Q25,0 50,10 T100,10" stroke="orange" stroke-width="2" fill="none"/>
            </svg>

        
                <section class="categories">
                    <a href="decouverte.php?type=1" class="category-card">
                        <img src="img/restaurants/pizza-orleans.png" alt="Pizzeria à Orléans">
                        <span>Pizzeria, Orléans</span>
                    </a>
                    <a href="decouverte.php?type=1" class="category-card">
                        <img src="img/restaurants/paella-orleans.png" alt="Moules et fruits de mer à Orléans">
                        <span>Paella, Orléans</span>
                    </a>
                    <a href="decouverte.php?type=1" class="category-card">
                        <img src="img/poisson.png" alt="Viandes et grillades à Orléans">
                        <span>Viandard, Orléans</span>
                    </a>
                </section>
    
            </main>
            <?php include('interfaces-role/global/footer.php'); ?>
        </body>
    </html>