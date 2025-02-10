<!DOCTYPE html>
<html lang="fr">
<?php 
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
include('interfaces-role/global/head.php'); 
title_html('Inscription');
link_to_css('static/inscription.css');
if (!empty($_POST)){
    $subscribe = DBConnector::subscribe($_POST['email'],$_POST['password'], $_POST['name'], $_POST['prenom'], 'visiteur');
}
?>
<body>
    <?php include('interfaces-role/global/header_connected.php'); ?>
    <main>
        <section class="form-section">
            <div class="form-container">
                <h1>Inscription</h1>
                <form action="" method="post">
                    <label for="name">Nom </label>
                    <input type="text" id="name" name="name" placeholder="Votre nom" required>

                    <label for="name">Prénom</label>
                    <input type="text" id="prenom" name = "prenom" placeholder="Votre prénom" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

                    <button type="submit">Submit</button>
                </form>
                <p><?php if ($subscribe) {
                            $login = UserTools::login($_POST['email'], $_POST['password']);
                            header('Location: index_connected.php');
                        } else {
                            $_GET['error'] = true;
                            echo "<p>Vous avez déjà un compte avec ". $_POST['email'] ."</p>";
                        }
                        session_start();
                        $status = UserTools::isLogged();
                    ?></p>
            </div>
        </section>
    </main>
    <?php include('interfaces-role/global/footer.php'); ?>
</body>
</html>
