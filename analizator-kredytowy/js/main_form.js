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
document.querySelector('form').addEventListener('submit', function(e) {
    document.querySelectorAll('input[readonly][required]').forEach(input => {
        input.setCustomValidity('To pole wymaga uzupełnienia przez przycisk "Dodaj"');

        input.addEventListener('input', function() {
            if (this.value > 0) {
                this.setCustomValidity('dfa');
            }
        });
    });
});


