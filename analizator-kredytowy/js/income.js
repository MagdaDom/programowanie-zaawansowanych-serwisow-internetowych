document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.income-row');

    rows.forEach(row => {
        row.addEventListener('click', function() {
            // ukryj przyciski we wszystkich wierszach
            document.querySelectorAll('.actions').forEach(cell => {
                cell.style.display = 'none';
            });

            // pokazuj przyciski tylko w klikniętym wierszu
            const actionsCell = row.querySelector('.actions');
            actionsCell.style.display = 'table-cell';
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.income-row');

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

            fetch('usun_dochod.php', {
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
                        const row = this.closest('tr');
                        row.remove();
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
