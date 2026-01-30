document.querySelector('form').addEventListener('submit', function(e) {
    const hiddenInputs = document.querySelectorAll('input[type="hidden"][required]');

    for(let hidden of hiddenInputs) {
        if(hidden.value === '' || parseFloat(hidden.value) <= 0) {
            e.preventDefault();  // ✅ BLOKUJE SUBMIT
            e.stopPropagation(); // ✅ ZATRZYMUJE EVENT

            // Znajdź display pole
            const displayInput = document.getElementById(hidden.id.replace('-hidden', '-display'));

            // Wizualny feedback JAK NAJWIECEJ jak natywne required
            displayInput.style.border = '2px solid #dc3545';
            displayInput.style.background = '#f8d7da';
            displayInput.style.boxShadow = '0 0 0 0.2rem rgba(220,53,69,0.25)';
            displayInput.title = 'Wypełnij to pole - kliknij "Dodaj" aby uzupełnić';

            // Focus + scroll (jak natywne)
            displayInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            displayInput.focus();

            return false;
        }
    }
});

// Reset błędów po kliknięciu Dodaj
document.querySelectorAll('.add-button').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        // Znajdź pole display (poprawiona logika)
        const displayInput = this.previousElementSibling;
        const hiddenInput = document.getElementById(displayInput.id.replace('-display', '-hidden'));

        const value = prompt('Podaj wartość:');
        if(value !== null && !isNaN(value) && parseFloat(value) > 0) {
            hiddenInput.value = parseFloat(value);
            displayInput.value = parseFloat(value);
            displayInput.disabled = false;

            // Reset błędów wizualnych
            displayInput.style.border = '';
            displayInput.style.background = '';
            displayInput.style.boxShadow = '';
            displayInput.title = '';
        }
    });
});
