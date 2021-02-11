<?php







?>




<form action="#" method="POST" id="insertuser">

    <div><input type="text" placeholder="Choisissez un pseudo" id="pseudo" name="pseudo"></div>
    <div><input type="text" placeholder="Entrez votre adresse mail" id="email" name="email"></div>
    <div><input type="text" placeholder="Votre nom" id="nom" name="nom"></div>
    <div><input type="text" placeholder="Votre prénom" id="prenom" name="prenom"></div>
    <div><input type="text" placeholder="Adresse" id="adresse" name="adresse"></div>
    <div><input type="text" placeholder="Code Postal" id="cp" name="cp"></div>
    <div>
        <select name="ville" id="ville">
            <option value="" disabled> -- Choisissez une ville -- </option>
        </select>
    </div>
    <div><input type="submit" value="Ajouter un utilisateur"></div>

</form>