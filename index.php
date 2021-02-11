<?php
// Point d'entrée des données UTILISATEUR (GET, POST, COOKIES...)
// Ces données sont reçues AUTOMATIQUEMENT par PHP dans les structures $_GET, $_POST, $_COOKIE...

// On utilise pour différencier les traitements à effectuer un paramètre : le paramètre de routage
//var_dump($_GET);
//var_dump($_POST);

require_once "conf/fonctions.php";
require_once "controlers.php";
require_once "conf/global.php";

// ROUTER 
$routeok = (isset($_GET["route"]))? $_GET["route"] : "showformdisk";
// Traduction avec if :
// if(isset($_GET["route"])) {
//     $routeok = $_GET["route"];
// } else {
//     $routeok = "default";
// }

// Regarder la route transmise via GET, et appeler les traitements correspondants (fonction "controler")
// SI route=ajoutdisque on appelle les traitements pour ajouter un disque
switch($routeok) {
    case "showformdisk" : $toTemplate = showFormDisque();
    break;
    case "ajoutdisque" : ajoutDisque();
    break;
    case "showmoddisque" : $toTemplate = showModDisque();
    break;
    case "ajax" : sendViaAjax();
    break;
    case "moddisque" : modDisque();
    break;
    case "suppdisque" : suppDisque();
    break;
    default : // fonction par défaut...
}

// AFFICHAGE (réponse HTTP)
//var_dump($toTemplate);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CD'thèque</title>
</head>
<body>
    

    <!-- Contenu spécifique de chacune des pages -->
    <?php require $toTemplate["template"] ?>


    <div id="modContent"></div>
    
    <script src="js/ajax.js"></script>
</body>
</html>
    