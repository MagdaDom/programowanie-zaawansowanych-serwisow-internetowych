const input = document.getElementById('wysokosc');

input.addEventListener('keydown', function(e) {
    const step = 100.0;
    const val = parseFloat(input.value) || 0;

    if (e.key === 'ArrowUp') {
        e.preventDefault();
        input.value = (val + step).toFixed(2);
    } else if (e.key === 'ArrowDown') {
        e.preventDefault();
        input.value = Math.max(0, val - step).toFixed(2);
    }
});