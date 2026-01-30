/*document.querySelector('form').addEventListener('submit', function(e) {
    const readonlyInputs = this.querySelectorAll('input[readonly][required]');

    for(let input of readonlyInputs) {
        if(input.value == 0 || input.value == '') {
            e.preventDefault();
            alert(input.dataset.hint || 'To pole wymaga uzupełnienia przez przycisk "Dodaj"');
            input.focus();
            return false;
        }
    }
});*/
// Pozwól przeglądarce walidować HIDDEN pola naturalnie
document.querySelector('form').addEventListener('submit', function(e) {
    // NIE blokuj - pozwól HTML5 walidować hidden pola
    // Potem tylko wizualnie podkreśl display pole

    setTimeout(() => {
        document.querySelectorAll('input[type="hidden"][required]').forEach(hidden => {
            if(hidden.validity.valid === false) {
                const display = document.getElementById(hidden.id.replace('-hidden', '-display'));
                display.style.border = '2px solid #dc3545';
                display.title = 'Wypełnij to pole - kliknij "Dodaj"';
            }
        });
    }, 10);
});

/*
document.querySelector('form').addEventListener('submit', function(e) {
    // Waliduj HIDDEN pola (są required)
    const hiddenInputs = document.querySelectorAll('input[type="hidden"][required]');

    for(let hidden of hiddenInputs) {
        if(hidden.value === '') {
            //e.preventDefault();
            // Znajdź odpowiadające display pole i pokaż błąd
            const displayInput = document.getElementById(hidden.id.replace('-hidden', '-display'));
            displayInput.setCustomValidity('Kliknij "Dodaj" aby uzupełnić');
            displayInput.reportValidity();
            displayInput.focus();
            return false;
        }
    }
});

// Obsługa przycisków "Dodaj" (placeholder)
document.querySelectorAll('.add-button').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const type = this.previousElementSibling.id.replace('-display', '');
        const hiddenInput = document.getElementById(type + '-hidden');
        const displayInput = document.getElementById(type + '-display');

        // Tymczasowo: prompt (zastąp modalem)
        const value = prompt('Podaj wartość:');
        if(value !== null && !isNaN(value) && value > 0) {
            hiddenInput.value = value;
            displayInput.value = value;
            displayInput.disabled = false;  // Odblokuj display
        }
    });
});*/


/*
// Ustaw custom walidację przy ładowaniu strony
document.querySelectorAll('input[readonly][required]').forEach(input => {
    input.setCustomValidity('Kliknij "Dodaj" aby uzupełnić');

    // Reset walidacji gdy użytkownik wpisze wartość > 0
    input.addEventListener('input', function() {
        if (this.value > 0) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('Kliknij "Dodaj" aby uzupełnić');
        }
    });
});

// Walidacja przy submit (na wszelki wypadek)
document.querySelector('form').addEventListener('submit', function(e) {
    document.querySelectorAll('.input[readonly][required]').forEach(input => {
        if (input.value <= 0 || input.value === '') {
            input.setCustomValidity('Kliknij "Dodaj" aby uzupełnić');
            input.reportValidity();
            e.preventDefault();
            return false;
        }
    });
});
*/
