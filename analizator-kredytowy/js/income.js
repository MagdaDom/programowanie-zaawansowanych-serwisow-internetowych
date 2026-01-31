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
