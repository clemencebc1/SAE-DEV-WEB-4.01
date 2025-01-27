<!DOCTYPE html>
<html lang="fr">
<?php include('global/head.php'); 
title_html('Détails');
link_to_css('static/details.css');?>
<body>
    <?php include('global/header.php'); ?>
    <main>
        <section class="titre">
            <h1>Détails du restaurant ...</h1>
        </section>
        <section>
            <div class="image_nom">
                <div class="image">
                </div>
                <div class="nom">
                </div>
            </div>
            <div class="details_lien">
                <div class="details">
                    <p>Adresse : </p>
                    <p>Origine : </p>
                    <p>Inclus : </p>
                    <p>Horaire : </p>
                    <p>Email : </p>
                    <p>Numéro : </p>
                </div>
                <div>
                    <a href="">Inscrivez vous dès maintenant pour voir les avis de ce restaurant !</a>
                </div>
            </div>
        </section>
    </main>
    <?php include('global/footer.php'); ?>
</body>
</html>
