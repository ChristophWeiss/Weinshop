<?php

require_once 'DB/Database.php';
require_once 'models/Bestellung.php';
require_once 'models/Bestellung_hat_Wein.php';
require_once 'models/Kunden.php';
require_once 'models/Weine.php';

require_once 'controller/Controller.php';


$aktion = isset($_GET['action'])?$_GET['action']:'alleWeine';

$controller = new Controller();

if (method_exists($controller, $aktion)){
    $controller->run($aktion);
}



?>


