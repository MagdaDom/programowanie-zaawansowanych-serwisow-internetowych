<?php
require_once __DIR__ . '/../config.php';
session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}

$books = [
    ['title' => 'Chłopki', 'author' => 'Joanna Kuciel-Frydryszak', 'price' => 45.99],
    ['title' => 'Gra o Tron', 'author' => 'George R. R. Martin', 'price' => 69.90],
    ['title' => 'Służące do wszystkiego', 'author' => 'Joanna Kuciel-Frydryszak', 'price' => 47.99],
    ['title' => 'Harry Potter i Czara Ognia', 'author' => 'J.K. Rowling', 'price' => 43.99],
    ['title' => 'Ludowa historia Polski', 'author' => 'Adam Leszczyński', 'price' => 32.31],
    ['title' => 'Atomowe nawyki', 'author' => 'James Clear', 'price' => 30.99],
    ['title' => 'Wiedźmin: Ostatnie życzenie', 'author' => 'Andrzej Sapkowski', 'price' => 39.99],
    ['title' => 'Folwark zwierzęcy', 'author' => 'George Orwell', 'price' => 28.50],
    ['title' => 'Zbrodnia i kara', 'author' => 'Fiodor Dostojewski', 'price' => 35.00],
    ['title' => 'Mały Książę', 'author' => 'Antoine de Saint-Exupéry', 'price' => 25.99],
    ['title' => 'Sto lat samotności', 'author' => 'Gabriel García Márquez', 'price' => 49.99],
    ['title' => 'Przeminęło z wiatrem', 'author' => 'Margaret Mitchell', 'price' => 55.00],
    ['title' => 'Duma i uprzedzenie', 'author' => 'Jane Austen', 'price' => 33.50],
    ['title' => 'Hobbit', 'author' => 'J.R.R. Tolkien', 'price' => 42.99],
    ['title' => 'Cień wiatru', 'author' => 'Carlos Ruiz Zafón', 'price' => 38.99],
    ['title' => 'Mistrz i Małgorzata', 'author' => 'Michaił Bułhakow', 'price' => 46.50],
    ['title' => '1984', 'author' => 'George Orwell', 'price' => 29.99],
    ['title' => 'Władca Pierścieni: Drużyna Pierścienia', 'author' => 'J.R.R. Tolkien', 'price' => 69.50],
    ['title' => 'Cień góry', 'author' => 'Gregory David Roberts', 'price' => 41.99],
    ['title' => 'Miasto ślepców', 'author' => 'José Saramago', 'price' => 37.00],
    ['title' => 'Jane Eyre', 'author' => 'Charlotte Brontë', 'price' => 34.50],
    ['title' => 'Frankenstein', 'author' => 'Mary Shelley', 'price' => 27.99],
    ['title' => 'Opowieść podręcznej', 'author' => 'Margaret Atwood', 'price' => 44.99],
    ['title' => 'Cień wiatru 2', 'author' => 'Carlos Ruiz Zafón', 'price' => 39.50],
    ['title' => 'Sapiens: Od zwierząt do bogów', 'author' => 'Yuval Noah Harari', 'price' => 59.99],
    ['title' => 'Homo Deus', 'author' => 'Yuval Noah Harari', 'price' => 54.99],
    ['title' => 'Zemsta', 'author' => 'Aleksander Fredro', 'price' => 24.50],
    ['title' => 'Pan Tadeusz', 'author' => 'Adam Mickiewicz', 'price' => 31.99],
    ['title' => 'Lalka', 'author' => 'Bolesław Prus', 'price' => 36.50],
    ['title' => 'Potop', 'author' => 'Henryk Sienkiewicz', 'price' => 48.00],
    ['title' => 'Ogniem i mieczem', 'author' => 'Henryk Sienkiewicz', 'price' => 45.50]
];

function searchAuthor($txt) {
    global $books;
    //array_keys(array_column($studenci, 'nazwisko'), 'Kowalski')
    $results = array_filter($books, function($element) use ($txt) {
        return stripos($element['title'], $txt) !== false ||
            stripos($element['author'], $txt) !== false;
    });
    return $results;
}

function searchPositions($txt) {
    global $books;
    $positions = [];
    foreach ($books as $index => $book) {
        if (stripos($book['title'], $txt) !== false ||
                stripos($book['author'], $txt) !== false) {
            $positions[] = $index + 1;  // +1 dla numeracji od 1
        }
    }
    return $positions;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=2" type="text/css">
</head>
<body>
<div class="container">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
    </div>
    <?php if (!empty($_SESSION['user_email'])): ?>
        <div class="user-bar">
            Witaj, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_COMPAT, 'UTF-8'); ?>!
        </div>
    <?php endif; ?>

    <form method="GET">
        <label>Wyszukaj książkę po tytule lub autorze:</label>
        <input type="text" name="lista" id="lista" placeholder="np. Tolkien" required>
        <button type="submit">Zatwierdź</button>
    </form>
    <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['lista'])):
        $txt = $_GET['lista'];
        $results = searchAuthor($txt);
        $positions = searchPositions($txt);
        if (!empty($results)): ?>
            <div class = "result">
                </br><label>Element "<?php echo $txt; ?>" znaleziony na pozycji:  <?php echo implode(", ", $positions); ?>.</label>
                <table>
                    <tr><th>Nr</th><th>Tytuł</th><th>Autor</th><th>Cena</th></tr>
                    <?php
                    foreach ($results as $index=>$book) {
                        $price = number_format($book['price'], 2);
                        $nr = $index + 1;
                        echo "<tr><td>$nr</td><td>$book[title]</td><td>$book[author]</td><td>$price</td></tr>";
                    }
                    ?>
                </table>
            </div>
        <?php else: ?>
            </br><label style="color: #D9534F;">Element nie znajduje się w tablicy.</label>
        <?php endif;
    endif; ?>

    </br><label>Dostępne książki:</label>
    <table><tr><th>Nr</th><th>Tytuł</th><th>Autor</th><th>Cena</th></tr>
        <?php
        $counter = 0;
        foreach ($books as $book) {
            $counter++;
            $price = number_format($book['price'],2);
            echo "<tr><td>$counter.</td><td>{$book['title']}</td><td>{$book['author']}</td><td>{$price} zł</td></tr>";
        }
        ?>
    </table>
    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
