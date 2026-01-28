<?php

function getQuery($query) {
    $db = new mysqli("localhost", "user", "pass", "kalkulatorkredytowy");
    $db->set_charset("utf8mb4");
    $result = $db->query($query);
    $db->close();
    return $result;
}
function otworz_polaczenie() {
    global $polaczenie;
    $serwer = "127.0.0.1";
    $uzytkownik = "root";
    $haslo = "";
    $baza = "kalkulatorkredytowy";
    $polaczenie = mysqli_connect($serwer, $uzytkownik, $haslo)
    or exit("Nieudane połączenie z serwerem");

    mysqli_select_db($polaczenie, $baza);
    mysqli_set_charset($polaczenie, "utf8");
    //return $polaczenie;
}
function zamknij_polaczenie() {
    global $polaczenie;
    mysqli_close($polaczenie);
}
function utworz_baze() {
    $polaczenie = mysqli_connect("127.0.0.1", "root", "")
    or exit("Nieudane połączenie z serwerem");
    $baza = 'kalkulatorkredytowy';
    echo "Tworzę bazę danych '$baza' ... <br>";
    mysqli_query($polaczenie, "CREATE DATABASE `$baza` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;")
    or exit("Błąd w zapytaniu tworzącym bazę");
}
function utworz_tabele() {
    global $polaczenie;
    $rozkaz = "create table uzytkownicy" .
    "(id int NOT NULL AUTO_INCREMENT ," .
    "imie varchar(32), " .
    "nazwisko varchar(32), " .
        "email varchar(32), " .
        "password varchar(32),".
    "PRIMARY KEY (`id`))";
    mysqli_query($polaczenie, $rozkaz)
    or exit("Błąd w zapytaniu: ".$rozkaz);
/*
    $rozkaz = "create table studenci " .
    "(numer int NOT NULL AUTO_INCREMENT ," .
    "imie varchar(32), " .
    "nazwisko varchar(32), " .
    "PRIMARY KEY (`numer`))";
    mysqli_query($polaczenie, $rozkaz)

    or exit("Błąd w zapytaniu: ".$rozkaz);

    $rozkaz = "create table oceny " .
    "(nr_stud int NOT NULL, " .
    "nr_przed int NOT NULL, " .
    "ocena float )";
    mysqli_query($polaczenie, $rozkaz)

    or exit("Błąd w zapytaniu: ".$rozkaz);*/
}
function wstaw_dane_testowe() {
    global $polaczenie;
    mysqli_set_charset($polaczenie, "utf8");

    $rozkazy = array("insert into przedmioty values(null, 'Programowanie', 30);",
    "insert into przedmioty values(null, 'Szydełkowanie', 20);",
    "insert into przedmioty values(null, 'Pływanie', 50);");

    foreach($rozkazy as $rozkaz)
        mysqli_query($polaczenie, $rozkaz)
    or exit("Błąd w zapytaniu: ".$rozkaz);

    $rozkazy = array("insert into studenci values(null, 'Jan', 'Smith');",
    "insert into studenci values(null, 'Agnieszka', 'Bond');",
    "insert into studenci values(null, 'Monika', 'Ratownik');");

    foreach($rozkazy as $rozkaz)
        mysqli_query($polaczenie, $rozkaz)
    or exit("Błąd w zapytaniu: ".$rozkaz);

    $rozkazy = array("insert into oceny values(1, 1, 4.0);",
    "insert into oceny values(1, 2, 5.5);",
    "insert into oceny values(3, 3, 5.0);");

    foreach($rozkazy as $rozkaz)
        mysqli_query($polaczenie, $rozkaz)
    or exit("Błąd w zapytaniu: ".$rozkaz);
}
?>
