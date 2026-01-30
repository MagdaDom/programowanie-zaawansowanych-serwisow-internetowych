<?php

function readCsvToTable($file) {
    $result = [];
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $result[$row[0]] = (float)str_replace(',', '.', $row[1]);
        }
        fclose($handle);
    }
    return $result;
}

?>
