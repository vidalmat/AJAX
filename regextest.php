<?php

$str1 = "Bonjour tout le monde !";

// $cps = [
//     "25698",
//     "czalb",
//     "459863",
//     "4568",
//     "$!58+"
// ];

// foreach($cps as $cp) {
//     if(preg_match("#^[0-9]{5}$#", $cp)) {
//         echo "Le code postal $cp est correct.<br>";
//         // On peut ajouter le cp à la base de données
//     } else {
//         echo "Le code postal $cp est incorrect.<br>";
//         // On ne peut pas ajouter le cp à la base de donnée
//     }
// }

$noms = [
    "Dupont",
    "Dupont123",
    "Dupont#",
    "L'hôtelier",
    "Bernard-Martin",
    "De machin",
    "Lebœuf",
    "azertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiop",
    "O"
];

foreach($noms as $nom) {
    if (preg_match("#^[a-zA-Z-àâäéèêëïîôöùûüçñÀÂÄÉÈËÏÔÖÙÛÜŸÇÑæœÆŒ'( )]{1,50}$#", $nom)) {
        echo "Le nom $nom est correct.<br>";
        // On peut ajouter le nom à la base de données
    } else {
        echo "Le nom $nom est incorrect.<br>";
        // On ne peut pas ajouter le nom à la base de donnée
    }
}