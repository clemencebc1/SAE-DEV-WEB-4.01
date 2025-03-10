<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\UserTools;
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $login = UserTools::login($_POST['email'], $_POST['password']);
    if ($login == true) {
        header('Location: index_connected.php');
    } else {
        header('Location: connexion.php?error=1');
    }
} else if (!empty($_POST['login']) || !empty($_POST['password'])) {
    header('Location: connexion.php?error=2');
}

?>

<!DOCTYPE html>
<html lang="fr">
<?php 
include 'interfaces-role/global/head.php'; 
title_html('Connexion');
link_to_css('static/connexion.css');
?>
<body>
    <?php include('interfaces-role/global/header.php') ?>
    <main>
        <section id="login">
            <div class="form-section">
                <h1>Connexion</h1>
                <form action="" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"placeholder="Votre email" required>

                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                    
                    <input type="submit" id="login-btn" value="Se connecter">
                    <?php
                    if (!(empty($_GET["error"]))) {
                        $message = '<p id="error">%s</p>';
                        switch ($_GET["error"]) {
                            case 1:
                                echo sprintf($message, htmlspecialchars("Login ou mot de passe incorrect"));
                                break;
                            case 2:
                                echo sprintf($message, htmlspecialchars("Veuillez remplir tous les champs"));
                                break;
                            default:
                                break;
                        }
                    }   
                    ?>
                </form>
                <p class="inscrire">Pas de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>
                
            </div>
        </section>
    </main>
    <?php include('interfaces-role/global/footer.php') ?>
</body>
</html>
