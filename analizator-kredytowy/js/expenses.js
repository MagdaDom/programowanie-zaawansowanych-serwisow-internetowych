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


document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.expenses-row');

    rows.forEach(row => {
        row.addEventListener('click', function() {
            document.querySelectorAll('.actions').forEach(cell => {
                cell.style.display = 'none';
            });

            const actionsCell = row.querySelector('.actions');
            actionsCell.style.display = 'table-cell';
        });
    });

    // USUŃ BEZ FORMULARZA
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();

            const id = this.getAttribute('data-id');

            if (!confirm('Czy na pewno usunąć ten dochód?')) {
                return;
            }

            fetch('usun_wydatek.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': id
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Błąd usuwania');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Błąd połączenia');
                });
        });
    });
});
