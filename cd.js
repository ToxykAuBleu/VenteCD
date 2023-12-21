function addEvent_supprimerCDAdmin() {
    // On ajoute un événement à chaque bouton Supprimer.
    for (const bouton of document.querySelectorAll(`[id^="SupprimerCDAdmin-"]`)) {
        bouton.addEventListener("click", () => {
            const id = bouton.id.split("-")[1];
            // On modifie l'action du formulaire de suppression.
            let formSupprimer = document.getElementById("formSupprimer");
            formSupprimer.action = `gererCd.php?action=supprimer&id=${id}`;

            // Afficher le modal.
            const modal = new bootstrap.Modal(document.getElementById("supprimerCDModal"));
            modal.show();
        })
    }
}

function addEvent_infoCD() {
    // On ajoute un événement à chaque bouton Supprimer.
    for (const bouton of document.querySelectorAll(`[id^="InfoCD-"]`)) {
        bouton.addEventListener("click", () => {
            const id = bouton.id.split("-")[1];

            // Afficher le modal.
            const modal = new bootstrap.Modal(document.getElementById(`InfoCDModal-${id}`));
            modal.show();
        })
    }
}

export { addEvent_supprimerCDAdmin, addEvent_infoCD }