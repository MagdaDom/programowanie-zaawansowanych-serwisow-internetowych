function capitalize(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('rodzaj');
    const label  = document.getElementById('income-label');

    select.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const opis = selectedOption.getAttribute('data-opis');

        if (opis) {
            label.textContent = capitalize(opis) + ' w zł:';
        } else {
            label.textContent = 'Wysokość w zł';
        }
    });

    // opcjonalnie: ustaw początkowy opis, jeśli jest coś zaznaczone (tryb edycji)
    if (select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const opis = selectedOption.getAttribute('data-opis');
        if (opis) {
            label.textContent = opis + ':';
        }
    }
});
