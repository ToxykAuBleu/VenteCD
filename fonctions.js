// Restriction des caractères dans les champs numériques
function restrictionNombres(element, limite = 0) {
    element?.addEventListener("input", function (event) {
        this.value = this.value.replace(/[^0-9]/g, "");
        if (limite != 0 && this.value.length > limite) {
            this.value = this.value.slice(0, limite);
        }
    });
};

// Restriction des caractères dans le champ alphabétique
function restrictionAlphabet(element) {
    element?.addEventListener("input", function (event) {
        this.value = this.value.replace(/[^a-zA-Z]/g, "");
    });
}

export { restrictionNombres, restrictionAlphabet };