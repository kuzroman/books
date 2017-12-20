<?php
// парсим страницу

include "conf.php";


$showResult = true;

// получить данные из базы
//$listUrl = [];
//$res = $mysqli->query("SELECT `href` FROM `list` WHERE 1 LIMIT 203, 60");
//$res->data_seek(0);
//while ($row = $res->fetch_assoc()) {
//    echo $row['href'] . "<br>";
//    $model = parseBook($row['href'], $showResult);
//    insertToDB($model, $mysqli);
//}

$model = parseBook('http://english-e-books.net/the-grass-is-singing-doris-lessing/', $showResult);
//insertToDB($model, $mysqli);

function parseBook($html, $showResult) {

    $html = file_get_html($html); // one book

    $model = ['name'=>'','author'=>'','level'=>'','genre'=>'','length'=>'','english'=>'','imgpath'=>'','desc'=>'',
        'total-words'=>'','unique-words'=>'', 'reed-epub'=>'', 'reed-mobi'=>'', 'reed-fb2'=>'', 'reed-rtf'=>'', 'reed-txt'=>'',
        'mp3'=>'', 'torrent'=>''];

    $metarea = $html->find('#metarea a');
    $model['name'] = $metarea ? html_entity_decode(trim($metarea[0]->plaintext)) : '';
    $model['author'] = $metarea ? html_entity_decode(trim($metarea[1]->plaintext)) : '';
    $model['level'] = $metarea ? html_entity_decode(trim($metarea[3]->plaintext)) : '';
    $model['genre'] = $metarea ? html_entity_decode(trim($metarea[5]->plaintext)) : '';
    $model['length'] = $metarea ? html_entity_decode(trim($metarea[7]->plaintext)) : '';
    $model['english'] = $metarea ? html_entity_decode(trim($metarea[9]->plaintext)) : '';

    foreach ($html->find('.entry p') as $key => $p) {

        if (empty($model['imgpath'])) {
            $img = $p->find('img');
            $model['imgpath'] = $img ? 'http://english-e-books.net' . $img[0]->attr['src'] : '' ;
        }

        if (empty($model['desc'])) {
            $desc = trim($p->plaintext);
            $model['desc'] = !empty($desc) ? $desc : '';
        }

        if ($p->find('strong') || $p->find('b')) {
            getCountWords($p, $model);
        }

        // адреса для скачивания книжных форматов
        foreach ($p->find('a') as $key2 => $a) {

            if (array_key_exists('title', $a->attr) && array_key_exists('href', $a->attr)) {

                $title = $a->attr['title'];
                $href = $a->attr['href'];

                if (empty($model['reed-epub']) && strpos($title, 'epub') !== false ) {
                    $model['reed-epub'] = $href;
                }
                else if (empty($model['reed-mobi']) && strpos($title, 'mobi') !== false ) {
                    $model['reed-mobi'] = $href;
                }
                else if (empty($model['reed-fb2']) && strpos($title, 'fb2') !== false ) {
                    $model['reed-fb2'] = $href;
                }
                else if (empty($model['reed-rtf']) && strpos($title, 'rtf') !== false ) {
                    $model['reed-rtf'] = $href;
                }
                else if (empty($model['reed-txt']) && strpos($title, 'txt') !== false ) {
                    $model['reed-txt'] = $href;
                }
                else if (empty($model['mp3']) && strpos($title, 'in mp3') !== false ) {
                    $model['mp3'] = $href;
                }
                else if (empty($model['torrent']) && strpos($title, 'via torrent') !== false ) {
                    $model['torrent'] = $href;
                }
            }
        }

    }


    if ($showResult) {
        // визуальная проверка
        foreach ($model as $key => $value) {
            if (empty($value)) echo "<div style='font-size: 40px'>Поле $key не заполнено</div>";
        }
        var_dump($model);
    }

    return $model;
}

function getCountWords($p, &$model) {
    $textWithHTML = $p->innertext;
    $textOnly = $p->plaintext;

    if (strpos($textWithHTML, 'Film version') !== false) {
        return false;
    }

    if (strpos($textWithHTML, 'Total words') !== false && strpos($textWithHTML, 'Unique words') !== false) {

        $pieces = explode("\n", $textOnly);

        $wordsTotal = strip_tags($pieces[0]);
        $wordsUnique = strip_tags($pieces[1]);

        $model['total-words'] = trim(explode(':', $wordsTotal)[1]);
        $model['unique-words'] = trim(explode(':', $wordsUnique)[1]);
    }
    else if (strpos($textWithHTML, 'Total words') !== false && strpos($textWithHTML, 'Unique words') === false) {
        $pieces = explode(':', $textOnly);
        $model['total-words'] = trim($pieces[1]);
    }
    else if (strpos($textWithHTML, 'Total words') === false && strpos($textWithHTML, 'Unique words') !== false) {
        $pieces = explode(':', $textOnly);
        $model['unique-words'] = trim($pieces[1]);
    }
};

function insertToDB($model, $mysqli) {
    // запись в базу
    $columns = "'" . implode("','",array_values($model)) . "'"; // важно чтобы порядок полей совпадал с массивом $columns ($model)
    // поле которое должно быть уникальным в mysql делаем unique, а в этом запросе добавляем IGNORE, чтобы корректно работало (игнорит ошибки php)
    $sql = "INSERT IGNORE INTO `main` (`name`, `author`, `level`, `genre`, `length`, `english`, `imgpath`, `description`, `total-words`, `unique-words`, 
        `reed-epub`, `reed-mobi`, `reed-fb2`, `reed-rtf`, `reed-txt`, `mp3`, `torrent`) 
        VALUES ($columns)";
    $mysqli->query($sql); if ($mysqli->errno) {echo "error: (" . $mysqli->errno . ") " . $mysqli->error;}
}



//var_dump( $html->find('.entry a[title=Review]')[0]->attr['href'] ); // ссылка на амазон - изучаем апи амазона и делаем свои реферальные ссылки! эти не используем!
// изучить апи кинопоиска и добавить их ссылки