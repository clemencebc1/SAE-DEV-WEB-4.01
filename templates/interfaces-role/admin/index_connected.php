<?php

require_once 'autoloader.php';
Autoloader::register();
use utils\connection\DBConnector;
use utils\connection\UserTools;

UserTools::requireLogin();

?>

