<?php 
session_start()

?>

<!DOCTYPE html>
    <html lang="fr">
        <?php
            include 'global/head.php';
            title_html('Accueil');
            link_to_css('static/accueil.css');
        ?>
        <body>
            <?php include('global/header.php'); ?>
            <div class="title"> 
                <h2> Une petite faim ? </h2>
                <img id = "dessin" src="img/deco_vague.jpg" alt="">
            </div>
            <main>
                <section class="search">
                    <div class="search-bar">
                        <input type="search" id="input-search" placeholder=" Rechercher un restaurant" />
                        <button type="submit" id="button-search"> Rechercher</button>
                    </div>
                    <div class="search-filter">
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li><button id="filters" type="button" onclick="#"><img src="img/more.png" alt=""></button></li>
                            <div class="more-filter">

                            </div>
                        </ul>
                    </div>
                    <hr/>
                    <div class="applied-filter">
                        <ul>
                            <?php
                                //foreach filter applied
                            ?>
                        </ul>
                    </div>
                </section>
                <section class="search-restaurants">
                    <ul>
                        <?php 
                            //foreach restaurants popular (environ 3)
                            //img + name on it (cliquable et consultable)
                        ?>
                    </ul>
                </section>

            </main>
        </body>
    </html>