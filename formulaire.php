<?php
//var_dump($toTemplate);
// $toTemplate["labels"] contient les données récupérées dans la BDD
// $toTemplate["disques"] contient les données récupérées dans la BDD
$datas = $toTemplate["labels"];
ch_entities($labels);

if(isset($toTemplate["disques"])) {
    $disques = $toTemplate["disques"];
    ch_entities($disques);
    $label = "";
    $titre = "";
    $reference = "";
    $annee = "";
    $artiste = "";
}

if(isset($toTemplate["disque"])) {
    $disque = $toTemplate["disque"];
    ch_entities($disque);
    $label = $disque["nom"];
    $titre = $disque["titre"];
    $reference = $disque["reference"];
    $annee = $disque["annee"];
    ch_entities($toTemplate["artistes"]);
    $artiste = $toTemplate["artistes"][0]["nom"];
}

?>

<?php $route = ($toTemplate["action"] == "show")? "ajoutdisque" : "moddisque"; ?>
<form action="index.php?route=<?= $route ?>" method="POST">
    <select name="label">
        <?php foreach($datas as $data): ?>
            <option><?= $data['nom'] ?></option>
        <?php endforeach ?>
    </select>
    <div>
        <input type="text" placeholder="Label du disque" name="label" value="<?= $label ?>">
    </div>
    <div>
        <input type="text" placeholder="Titre de l'album" name="titre" value="<?= $titre ?>">
    </div>
    <div>
        <input type="text" placeholder="Année" name="annee" value="<?= $annee ?>">
    </div>
    <div>
        <?php if($toTemplate["action"] == "mod"): ?>
        (Référence disque : <?= $reference ?>)
        <input type="hidden" name="reference" value="<?= $reference ?>">
        <?php else: ?>
        <input type="text" placeholder="Référence du disque" name="reference" value="">
        <?php endif ?>
    </div>
    <div>
        <input type="text" placeholder="Artiste" name="artiste" value="<?= $artiste ?>">
    </div>
    <div>
        <input type="hidden" value="<?= sha1(SALT) ?>" name="token">
    </div>
    <div>
        <?php $value = ($toTemplate["action"] == "show")? "Ajouter un disque" : "Modifier le disque"; ?>
        <input type="submit" value="<?= $value ?>">
    </div>
</form>

<?php if($toTemplate["action"] == "show"): ?>
<ul>
    <?php foreach($disques as $disk): ?>
        <li>
            <?= $disk['titre'] ?> (Label : <?= $disk['nom'] ?>) [<?= $disk['annee'] ?>] 
            <a href="index.php?route=showmoddisque&disk=<?= $disk['reference'] ?>">Modifier</a> 
            <a href="index.php?route=suppdisque&disk=<?= $disk['reference'] ?>">Supprimer</a>
        </li>

    <?php endforeach ?>
</ul>
<?php endif ?>