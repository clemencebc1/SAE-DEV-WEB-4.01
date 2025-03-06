<?php 
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;
use utils\render\Restaurant_render;

$dernier_restaurant = DBConnector::getLatestRestaurant($_SESSION['user']['username']);
$dernier_restau_render = new Restaurant_render([$dernier_restaurant]);
link_to_css('static/index_connected.css');
link_to_css('static/decouverte.css');
include('utils/render/searchRender.php');

$all_types = DBconnector::getAllType();
?>
    <div class="container">
        <div class="last-review">
            <?php if ($dernier_restaurant != null) { ?>
            <h2>Vous avez testé récemment <a href="ajouterCritique.php?id=<?= $dernier_restaurant->getId() ?>">et donné un avis</a></h2>
            <?php $dernier_restau_render->iconRestaurant(false);}?>
        </div>
        <div id="search-container">
                <form action="decouverte.php" method="get">
                    <div id='search-box'>
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
        </div>
   <h3 id="decouverte">Pas d'idées ? <a href="decouverte.php">Faites des découvertes !</a></h3>

