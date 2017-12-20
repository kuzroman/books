<?php
// парсим список книг, проверка на имя в поле в базе (параметр поля name - unique)

include "conf.php";


//$html = file_get_html('http://english-e-books.net/elementary/');
//$html = file_get_html('http://english-e-books.net/pre-intermediate/');
//$html = file_get_html('http://english-e-books.net/intermediate/');
//$html = file_get_html('http://english-e-books.net/upper-intermediate/');
$html = file_get_html('http://english-e-books.net/advanced/');

$model = [];

$td = $html->find('table td');

foreach ($td as $key => $element) {

    if ($key % 2 == 0) {

        $model[$key] = [
            'name' => html_entity_decode(trim($element->plaintext)),
            'href' => trim($element->find('a')[0]->attr['href']),
        ];
    }
}

// поле которое должно быть уникальным в mysql делаем unique, а в этом запросе добавляем IGNORE, чтобы корректно работало (игнорит ошибки php)
$sql = "INSERT IGNORE INTO list (`name`, `href`) VALUES ";
$valuesArr = array();

foreach($model as $row){

    $name = $row['name'];
    $href = $row['href'];
    $valuesArr[] = "('$name', '$href')";
}

$sql .= implode(',', $valuesArr);
$mysqli->query($sql);

//var_dump($model);
var_dump($sql);