// Récupère l'élément cible, dont le contenu sera modifié
//var elem = document.getElementById('modContent');
// Met une image animée afin de montrer le chargement en cours du contenu
//elem.innerHTML = '<img src="img/loading.gif" alt="Chargement" />';

//-----------------------------------------------

function getRequest() {
    
    //Récupère la connexion au serveur http
    var request;
    if (window.XMLHttpRequest) {
    request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
          request = new ActiveXObject("Msxml2.XMLHTTP"); // IE version > 5
        } catch (e) {
          request = new ActiveXObject("Microsoft.XMLHTTP");
        }
    } else {
        request = false;
    }
    return request;

}

var formulaire = document.getElementById("insertuser");
formulaire.addEventListener("submit", function (event) {

    event.preventDefault(); // arrête l'évènement 

    console.log("Le formulaire a été soumi");
    // 1. Effectuer une première vérification des données (NON SUFFISANTE)
    let pseudo = document.getElementById("pseudo").value;
    let email = document.getElementById("email").value;
    let nom = document.getElementById("nom").value;
    let prenom = document.getElementById("prenom").value;
    let adresse = document.getElementById("adresse").value;
    let cp = document.getElementById("cp").value;
    let ville = document.getElementById("ville").value;

    console.log(pseudo);
    console.log(email);
    console.log(nom);
    console.log(prenom);
    console.log(adresse);
    console.log(cp);
    console.log(ville);

    let request = getRequest();

    request.open("POST", "index.php?route=xhrinsertuser"); // route differe pour éviter un amalgame avec le insertuser en php avec les classes 
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("pseudo=" +pseudo+"&email="+email+"&nom="+nom+"&prenom="+prenom+"&adresse="+adresse+"&cp="+cp+"&ville="+ville);
    // Sous la forme param=valeur&param2=valeur2...

});

//----------------------------------------------------------------------------------------
var cpinput = document.getElementById("cp");
cpinput.addEventListener("keyup", function (event) {

    console.log(event.target.value);
    if(event.target.value.length == 5) {

        console.log("J'ai bien 5 caractères.");

        let cp = event.target.value;
        let request = getRequest();

        // Procédure par étape 
        //1. 
        request.open("GET", "https://api.zippopotam.us/FR/" + cp);  // Ne pas oublier "https://" sinon ça ne marchera pas 

        //2. 
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        //3.
        request.send();

        request.onreadystatechange = function (event) {
            if(request.readyState == 4 && request.status == 200) {

                // Dans ce cas, on peut modifier le select pour faire
                // apparaître le nom des villes une fois le code postal tapé
                let select = document.getElementById("ville");
                let datas = JSON.parse(request.response);
                console.log(datas);
                let html = "";
                for(let place of datas.places) {
                    html += "<option value='" + place["place name"] + "'>" + place["place name"] + "</option>";
                }
                console.log(html);

                select.innerHTML = html;
            }
        }
    }

});
//----------------------------------------------------------------------------------------




// function changeContent(url, param, id_elem) {
    
    var elem = document.getElementById("modContent");
    elem.innerHTML = '<img src="img/loading.gif" alt="Chargement">';
    
    var request = getRequest();
    // Ouvre la connexion en mode asynchrone avec le serveur http avec comme adresse url
    request.open('POST', "index.php?route=ajax", true);

    // Envoie des entêtes pour l'encodage
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    //Envoie les paramètres (même vide) et la requête et active les évènements en mode assynchrone
    request.send();

    request.onreadystatechange = function() {

        if(request.readyState == 4 && request.status == 200) {
            let elem2 = document.getElementById("modContent");

            let datas = JSON.parse(request.responseText);

            let html = "<ul>";
            for(let data of datas) {
                html += "<li>"+ data.nom + "</li>";
            }
            html += "</ul>"

            console.log(datas);
            elem2.innerHTML = html;
        }
    }



    console.log(request);

//     // Exécution en mode asynchrone de la fonction anonyme dès que l'on obtient une réponse du serveur http
//     request.onreadystatechange = function() {
//         // Teste si le serveur a tout reçu (200) et que le serveur ait fini (4)
//         if (request.status == 200 && request.readyState == 4) {
//           elem.innerHTML = request.responseText; // Modifie l'élément cible
//         }
//     };
// }



