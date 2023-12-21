var xhrPanier = new XMLHttpRequest();
xhrPanier.onreadystatechange = function () {
    if (this.readyState == 4) {
        if (this.status == 200) {
            const resultat = JSON.parse(this.responseText);
            if (resultat.erreur != undefined) {
                document.getElementById('PanierContenu').innerHTML = `<h5 class="text-center align-self-center">${resultat.erreur}</h5>`;
                console.error(resultat.erreur, resultat.code);
                return;
            }

            delete resultat.estConnecte;
            
            let contenuPanier = "";
            // Le panier est vide.
            if (resultat === 0) {
                contenuPanier = `<div class="text-center"><i class="bi bi-cart-x"></i><br/><h5>Votre panier est vide</h5></div>`;
            } else {
                let total = resultat.prixTotal; delete resultat.prixTotal;
                // Affichage du contenu du panier.
                contenuPanier = `<ul class="list-group flex-grow-1">`;
                for (const key in resultat) {
                    if (Object.hasOwnProperty.call(resultat, key)) {
                        const cd = resultat[key];
                        contenuPanier +=
                            `<div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    ${cd["titre"]}, ${cd["auteur"]}
                                    <small>${cd["quantite"]}x ${cd["prix"]} €</small>
                                </div>
                                <p class="mb-1">Sous total: ${cd["quantite"] * cd["prix"]}€</p>
                                <div class="input-group">
                                    <button id="PanierCDRemove-${cd["id"]}" class="btn btn-outline-secondary" type="button">-</button>
                                    <input type="text" class="form-control" placeholder="Quantite" min=0 value="${cd["quantite"]}" disabled readonly>
                                    <button id="PanierCDAdd-${cd["id"]}" class="btn btn-outline-secondary" type="button">+</button>
                                </div>
                            </div>`;
                    }
                }
                contenuPanier += `</ul>`;

                // Ajout du total du panier.
                contenuPanier += 
                    `<h4 class="mt-2 text-center">Total: ${total}€</h4>`;

                // Affichage des boutons Vider et Paiement.
                contenuPanier += 
                    `<div class="mt-2 text-center">
                        <button type="button" id="ViderPanier" class="btn btn-outline-danger">Vider le panier</button>
                        <a href="paiement.php"><button type="button" id="Payer" class="btn btn-success">Payer</button></a>
                    </div>`;


            }
            // Actualisation de l'élément HTML.
            document.getElementById("PanierContenu").innerHTML = contenuPanier;

            // Ajout des évenements.
            addEvent_viderPanier();
            addEvent_quantiteMoinsArticle();
            addEvent_quantitePlusArticle();
        } 
    }
}

function addEvent_ajouterPanier() {
    // On ajoute un évenement à chaque bouton Ajouter au panier.
    for (const bouton of document.querySelectorAll(`[id^="Ajouter"]`)) {
        bouton.addEventListener("click", () => {
            const id = bouton.id.split("-")[1];

            xhrPanier.open("GET", `gererPanier.php?action=ajouter&id=${id}`, true);
            xhrPanier.send(null);
        })
    }
}

function addEvent_viderPanier() {
    // On ajoute un évenement au bouton Vider le panier.
    document.getElementById("ViderPanier")?.addEventListener("click", () => {
        xhrPanier.open("GET", `gererPanier.php?action=vider`, true);
        xhrPanier.send(null);
    })
}

function addEvent_quantiteMoinsArticle() {
    // On ajoute un évenement à chaque bouton - des articles du panier.
    for (const bouton of document.querySelectorAll(`[id^="PanierCDRemove-"]`)) {
        bouton.addEventListener("click", () => {
            const id = bouton.id.split("-")[1];
            xhrPanier.open("GET", `gererPanier.php?action=retirer&id=${id}`, true);
            xhrPanier.send(null);
        })
    }
}

function addEvent_quantitePlusArticle() {
    // On ajoute un évenement à chaque bouton + des articles du panier.
    for (const bouton of document.querySelectorAll(`[id^="PanierCDAdd-"]`)) {
        bouton.addEventListener("click", () => {
            const id = bouton.id.split("-")[1];
            xhrPanier.open("GET", `gererPanier.php?action=ajouter&id=${id}`, true);
            xhrPanier.send(null);
        })
    }
}

// On affiche le contenu du panier au chargement de la page.
xhrPanier.open("GET", `gererPanier.php?action=afficher`, true);
xhrPanier.send(null);

export { addEvent_ajouterPanier };