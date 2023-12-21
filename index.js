import { addEvent_ajouterPanier } from "./panier.js";
import { addEvent_supprimerCDAdmin, addEvent_infoCD } from "./cd.js";
import { restrictionNombres, restrictionAlphabet } from "./fonctions.js";

restrictionAlphabet(document.getElementById("titre"));
restrictionAlphabet(document.getElementById("auteur"));
restrictionAlphabet(document.getElementById("genre"));
restrictionNombres(document.getElementById("prix"));

var xhr = new XMLHttpRequest();
const search = document.getElementById("search");

search.addEventListener("input", () => {
    xhr.open("GET", `search.php?search=${document.getElementById("search").value}&tag=${document.getElementById("searchTag").value}`, true);
    xhr.send(null);
})
xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
        if (this.status == 200) {
            var resultat = JSON.parse(this.responseText);
            if (resultat.erreur != undefined) {
                document.getElementById('cds').innerHTML = `<h5 class="text-center align-self-center">${resultat.erreur}</h5>`;
                console.error(resultat.erreur, resultat.code);
                return;
            }

            const estConnecte = resultat.estConnecte;
            if (estConnecte != undefined) {
                delete resultat.estConnecte;
            }

            let content = `<div class='row row-cols-1 row-cols-md-4 g-4'>`;
            for (const key in resultat) {
                if (Object.hasOwnProperty.call(resultat, key)) {
                    const cd = resultat[key];

                    content += `<div class="col"><div class="card">
                    <img src='genVignette.php?idImage=${cd.id}' class="card-img-top" alt="">
                    <div class="card-body">
                        <h3 class="card-title">${cd.titre}</h3>
                        <p class="card-text">${cd.auteur}</p>
                        <div class="d-flex justify-content-evenly">`;
                        if (estConnecte) {
                                content += `<button id="SupprimerCDAdmin-${cd.id}" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>`;
                            }
                            content += `
                            <button id="InfoCD-${cd.id}" class="btn btn-primary"><i class="bi bi-info-circle-fill"></i></a>
                            <button id="AjouterCD-${cd.id}" class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#Panier"><i class="bi bi-cart-plus-fill"></i></button>
                        </div>
                    </div>
                    </div></div>`;
                    
                    // Création d'un modal info pour le CD.
                    document.getElementById("infoModals").innerHTML += `
                    <div class="modal fade" id="InfoCDModal-${cd.id}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">${cd.titre}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-center"><img src="./genVignette.php?idImage=${cd.id}"></li>
                                    <li class="list-group-item" id="auteur">${cd.auteur}</li>
                                    <li class="list-group-item" id="genre">${cd.genre}</li>
                                    <li class="list-group-item" id="prix">${cd.prix} €</li>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>`;
                }
            }
            content += "</div>";
            document.getElementById('cds').innerHTML = content;

            addEvent_ajouterPanier();
            addEvent_infoCD()
            if (estConnecte) {
                addEvent_supprimerCDAdmin();
            }

        } else {
            alert("Le serveur n'a pas répondu à la requête : code d'erreur : " + this.status);
        }
    }
}

// On affiche la liste des cd sans aucune recherche préalable
// au chargement de la page.
xhr.open("GET", `search.php?search=${document.getElementById("search").value}&tag=${document.getElementById("searchTag").value}`, true);
xhr.send(null);