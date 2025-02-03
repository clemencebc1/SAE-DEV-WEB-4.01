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
                <svg xmlns="http://www.w3.org/2000/svg" width="20%" height="50" viewBox="0 0 100 10" preserveAspectRatio="none">
                    <path d="M0,5 Q20,0 40,5 T100,5" fill="none" stroke="orange" stroke-width="1.5" />
                </svg>
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