<?php
session_start();
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBconnector;
use utils\connection\UserTools;
use classes\model\Departement;
use classes\model\Restaurant;
use classes\model\Critique;
use utils\render\Restaurant_render;

function renderSuggestionsForm() {
    $html = "<form action='' method='GET'>";
    $html .= suggestionProposition($_GET['search'], 5);
    $html .= "</form>";
    return $html;
}

function renderSuggestionsButton($value) {
    return "<button type='submit' name='search' value='$value'>$value</button>";
}

function suggestionProposition($initialSequence, $limit){
    $suggestions = DBconnector::getSuggestions($initialSequence, $limit);
    $html = "";
    foreach ($suggestions as $suggestion) {
        $html .= renderSuggestionsButton($suggestion['nom']);
    }
    return $html;
}

if (isset($_GET['inc'])) {
    $limit = intval($_GET['inc']);
}
else {
    $limit = 10;
}
$restaurants = [];
$all_types = DBconnector::getAllType();

if (!(empty($_GET["search"]))) {
    $restaurants = [];
    $byType = DBconnector::searchRestaurantByType($_GET["search"]);
    $byName = DBconnector::searchRestaurantByName($_GET["search"]);
    $byCity = DBconnector::searchRestaurantByCity($_GET["search"]);
    $restaurants = array_merge($byName, $byType, $byCity);
    if (!empty($_GET["type"])) {
        for ($i = 0; $i < count($restaurants); $i++) {
            $typeCuisine = $restaurants[$i]->getTypeCuisine();
            if ($typeCuisine !== null) {
                $condition = ($_GET["type"] == $typeCuisine->getId());
                echo var_dump($condition);
                if ($condition) {
                    unset($restaurants[$i]);
                }
            }
        }
    }  
}else if (empty($_GET["search"]) && empty($_GET["type"])) {
    $restaurants = DBconnector::getAllRestaurants($limit, $type=null);
} else if (empty($_GET["search"]) && (!empty($_GET["type"]))) {
    $restaurants = DBconnector::getAllRestaurants($limit, $_GET["type"]);
}  


$render = new Restaurant_render($restaurants);
?>

<!DOCTYPE html>
<html lang="fr">
<?php 
include 'interfaces-role/global/head.php'; 
title_html('Découverte');
link_to_css('static/decouverte.css');
?>
<body>
    <?php 
    if (UserTools::isLogged()){
        include('interfaces-role/global/header_connected.php');
     }
     else {
        include('interfaces-role/global/header.php');
     } ?>
    <main>
        <section>
            <div class="titles-container">
                <h1>Découvrir des restaurants</h1>
                <h2>selon vos envies</h2>
            </div>
            <div id="search-container">
                <form action="" method="get">
                    <div id=sarch-box>
                        <input type="text" name="search" id="search" placeholder="Ville, Restaurant, type de cuisine.." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
                        <select name="type" id="type">
                            <option value="">Type de cuisine</option>
                            <?php foreach ($all_types as $type) : ?>
                                <option value="<?php echo $type->getId(); ?>"><?php echo $type->getCuisine(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Rechercher</button>
                    </div>
                </form>
            </div>
            <?php if (!empty($_GET['search'])) :?>
            <div id="search-suggestions">
                <form action="" method="GET">
                    <div id="suggestions">
                        <h3>Vous cherchez ?</h3>
                        <?php echo renderSuggestionsForm();?>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </section>
        <section>
        <div class="titles-container">
                <h1>Pas d’idées ? </h1>
                <h2>Nos suggestions du moment</h2>
            </div>
        </section>
        <section>
            <?php
            echo $render->decouvrir();
            ?>
        </section>
        <div class="more">
                <form method="GET" action="decouverte.php" >
                    <?php echo "<input type='hidden' name='inc' value='". $limit+10 ."'>"; ?>
                    <button type="submit" class="more-btn"><span class="text">Voir plus</span><span>Découvrir </span></button>
                </form>
        </div>
        <section>
            <h2>Les grands favoris</h2>
            <?php 
            $restaurants_moyenne = DBConnector::getFavorisByStars();
            $render_moyenne = new Restaurant_render($restaurants_moyenne);
            $render_moyenne->moyenne();
            ?>
        </section>
    </main>
    <?php include('interfaces-role/global/footer.php') ?>
</body>
</html>
