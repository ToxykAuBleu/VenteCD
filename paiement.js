import { restrictionNombres, restrictionAlphabet } from "./fonctions.js";
var paiementModal = new bootstrap.Modal(document.getElementById('paiementModal'), {});

restrictionNombres(document.getElementById("numCarte"), 16);
restrictionNombres(document.getElementById("dateExpiration"), 4);
restrictionNombres(document.getElementById("crypto"), 3);

restrictionAlphabet(document.getElementById("nom"));

// Ajout automatique du "/" dans le champ de la date d'expiration
document.getElementById("dateExpiration").addEventListener("input", function (event) {
    this.value = this.value.replace(/[^0-9]/g, "");
    if (this.value.length > 2) {
        this.value = this.value.slice(0, 2) + "/" + this.value.slice(2);
    }
});