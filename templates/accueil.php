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
                <img id = "dessin" src="" alt="">
            </div>
            <main>
                <section class="search">
                    <div class="search-bar">
                        
                    </div>
                    <div class="search-filter">
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li><button src="" type="button" onclick="#"></button></li>
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