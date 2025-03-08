<?php
require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBconnector;
use utils\connection\UserTools;
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

?>