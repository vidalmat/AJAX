<?php
// Pour rappel : deux types de controllers (fonctionalités) : 
// - Ceux qui font appel à un template (affichage - HTML)
// - Ceux qui redirigent vers un affichage

// FONCTIONS "CONTROLERS" = traitements appellés

function ajoutDisque() {
    // Contient tous les traitements nécessaires à l'ajout d'un disque 
    //echo "J'ajoute un disque";

    // Je dispose des données transmises par l'utilisateur dans $_POST

    if(isset($_POST['token']) && $_POST['token'] == sha1(SALT)) {
        // 1. J'insère mon label
        //a. Instanciation d'un objet Label (pour pouvoir utiliser ses fonctionnalités)
        //b. Appels aux setters pour renseigner les propriétés de notre modèle
        //c. Appel de la méthode insert() de l'objet pour déclencher l'insertion des données (propriétés) du modèle
        //var_dump($_POST);
        $label = new Models\Label();
        if(preg_match("#^.{1,50}$#", trim($_POST["label"]))) {
            $label->setNom($_POST["label"]);
            if(!$label->select()) {
                $label = $label->insert();
            }
        } else {
            echo "Format label incorrect";
        }
    

        //var_dump($label);

        // 2. J'insère mon artiste
        $artiste = new Models\Artiste();
        if(preg_match("#^[\w\àâäéèêëïîôöùûüçñÀÂÄÉÈËÏÔÖÙÛÜŸÇÑæœÆŒ'( )]{1,50}$#", trim($_POST["artiste"]))) {
            $artiste->setNom($_POST["artiste"]);
            if(!$artiste->selectByNom()) {
                $artiste = $artiste->insert();
            }
        } else {
            echo "Format artiste incorrect";
        }

        //var_dump($artiste);

        // Format pour la référence : 
        // 2 lettres majuscules, suivie de 2 chiffres, suivi de deux chiffres ou lettres minuscules
        // 3. J'insère mon disque
        $disque = new Models\Disque();
        if($artiste && $label && preg_match("#^[A-Z]{2}[0-9]{2}[a-z0-9]{2}$#", trim($_POST["reference"])) && preg_match("#^.{1,50}$#", trim($_POST["titre"])) && preg_match("#^[12]{1}[0-9]{3}$#", trim($_POST["annee"]))) {
            $disque->setReference($_POST["reference"]);
            $disque->setTitre($_POST["titre"]);
            $disque->setAnnee($_POST["annee"]);
            $disque->setNom($label->getNom());
            $disque = $disque->insert();
        } else {
            echo "Format disque incorrect";
        }

        //var_dump($disque);

        // 4. J'insère la relation disque-artiste
        if($disque && $artiste) {
            $enr = new Models\Enregistrer();
            $enr->setIdArtiste($artiste->getIdArtiste());
            $enr->setReference($disque->getReference());
            $enr->insert();
        }
    
    } else {
        echo "Le formulaire a expiré";
    }
   
    // Résultat souhaité : l'enregistrement des données dans la base de données OK  
    header("Location:index.php?route=showformdisk");
  
}

function showFormDisque() {

    $label = new Models\Label();
    $labels = $label->selectAll();

    $disque = new Models\Disque();
    $disques = $disque->selectAll();
    
    return [
        "template" => "formulaire.php",
        "labels" => $labels,
        "disques" => $disques,
        "action" => "show"
];

}

function showModDisque() {

    $label = new Models\Label();
    $labels = $label->selectAll();

    $disque = new Models\Disque();
    $disque->setReference($_GET["disk"]);
    $disk = $disque->select();

    $enr = new Models\Enregistrer;
    $enr->setReference($_GET["disk"]);
    $idartistes = $enr->selectByRefDisque();

    var_dump($idartistes);

    $artistes = [];

    foreach($idartistes as $art) {
        $artiste = new Models\Artiste();
        $artiste->setIdArtiste($art["id_artiste"]);
        array_push($artistes, $artiste->select());
    }

    var_dump($artistes);

    return [
        "template" => "formulaire.php",
        "action" => "mod",
        "labels" => $labels,
        "disque" => $disk,
        "artistes" => $artistes
    ];
}

function modDisque() {

    $label = new Models\Label();
    if(preg_match("#^.{1,50}$#", trim($_POST["label"]))) {
        $label->setNom($_POST["label"]);
        if(!$label->select()) {
            $label = $label->insert();
        }
    } else {
        echo "Format label incorrect";
    }

    $artiste = new Models\Artiste();
    if(preg_match("#^[\w\àâäéèêëïîôöùûüçñÀÂÄÉÈËÏÔÖÙÛÜŸÇÑæœÆŒ'( )]{1,50}$#", trim($_POST["artiste"]))) {
        $artiste->setNom($_POST["artiste"]);
        if(!$artiste->selectByNom()) {
            $artiste = $artiste->insert();
        }
    } else {
        echo "Format artiste incorrect";
    }

    if($label && $artiste) {
        $disque = new Models\Disque();
        $disque->setReference($_POST["reference"]);
        $disque->setTitre($_POST["titre"]);
        $disque->setAnnee($_POST["annee"]);
        $disque->setNom($label->getNom());
        $disque = $disque->update();
    }

    if($disque && $artiste) {
        $enr = new Models\Enregistrer();
        $enr->setReference($disque->getReference());

        $lignes = $enr->selectByRefDisque();
        foreach($lignes as $ligne) {
            $enr->setIdArtiste($ligne['id_artiste']);
            $enr->delete();
        }

        $enr->setIdArtiste($artiste->getIdArtiste());
        $enr->insert();
    }
    
    header("Location:index.php?route=showformdisk");
}

function suppDisque() {

    //var_dump($_GET);
    $enr = new Models\Enregistrer();
    $enr->setReference($_GET["disk"]);
    $lignes = $enr->selectByRefDisque();

    foreach($lignes as $ligne) {
        $enr->setReference($_GET["disk"]);
        $enr->delete();
    }

    $disque = new Models\Disque();
    $disque->setReference($_GET["disk"]);
    $verif = $disque->delete();

    if(!$verif) {
        foreach($lignes as $ligne) {
            $enr->setReference($ligne["reference"]);
            $enr->setReference($ligne["id_artiste"]);
            $enr->insert();
        }
    }

    header("Location:index.php?route=showformdisk");
}

function sendViaAjax() {

    //sleep(5);

    $label = new Models\Label();
    $labels = $label->selectAll();

    echo json_encode($labels);
    exit;
}



function showFormUser() {

    return [
        "template" => "insertuser.php"
    ];

}