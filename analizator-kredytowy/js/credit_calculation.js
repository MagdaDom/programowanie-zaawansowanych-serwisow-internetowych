
//wyświetlanie panelu ładowania / widoku oczekiwania (spinner) podczas obliczania zdolności kredytowej
document.getElementById('creditForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    document.getElementById('loadingPane').style.display = 'block';

    fetch('oblicz_zdolnosc.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'podsumowanie.php';
            } else {
                alert('Błąd: ' + data.message);
                document.getElementById('loadingPane').style.display = 'none';
            }
        })
        .catch(() => {
            alert('Błąd połączenia');
            document.getElementById('loadingPane').style.display = 'none';
        });
});