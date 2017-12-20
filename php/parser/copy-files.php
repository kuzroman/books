<?php

set_time_limit(1000);

include "conf.php";
//phpinfo();

$pathToLoad = [
    'img'=>'../../src/img/books/',
    'epub'=>'../../src/books/epub/',
    'mobi'=>'../../src/books/mobi/',
    'fb2'=>'../../src/books/fb2/',
    'rtf'=>'../../src/books/rtf/',
    'txt'=>'../../src/books/txt/',
    'mp3'=>'../../src/books/mp3/',
    'torrent'=>'../../src/books/torrent/',
];

//$res = $mysqli->query("SELECT `id`, `imgpath`, `reed-epub`, `reed-mobi`, `reed-fb2`, `reed-rtf`, `reed-txt`, `mp3`, `torrent` FROM `main` WHERE id > 164 LIMIT 100");
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    var_dump($row);

    if (!empty($row['imgpath'])) {
        copy(htmlspecialchars_decode($row['imgpath']), $pathToLoad['img'] . $row['id'] . '.jpg' );
    }
    if (!empty($row['reed-epub'])) {
        copy(htmlspecialchars_decode($row['reed-epub']), $pathToLoad['epub'] . $row['id'] . '.epub' );
    }
    if (!empty($row['reed-mobi'])) {
        copy(htmlspecialchars_decode($row['reed-mobi']), $pathToLoad['mobi'] . $row['id'] . '.mobi' );
    }
    if (!empty($row['reed-fb2'])) {
        copy(htmlspecialchars_decode($row['reed-fb2']), $pathToLoad['fb2'] . $row['id'] . '.fb2' );
    }
    if (!empty($row['reed-rtf'])) {
        copy(htmlspecialchars_decode($row['reed-rtf']), $pathToLoad['rtf'] . $row['id'] . '.rtf' );
    }
    if (!empty($row['reed-txt'])) {
        copy(htmlspecialchars_decode($row['reed-txt']), $pathToLoad['txt'] . $row['id'] . '.txt' );
    }
//    if (!empty($row['mp3'])) {
////        echo $row['mp3'] . '---' . $pathToLoad['mp3'] . "<br>";
//        copy(htmlspecialchars_decode($row['mp3']), $pathToLoad['mp3'] . $row['id'] . '.mp3' );
//    }
    if (!empty($row['torrent'])) {
        $pathToFile = $row['torrent'];
        if (strpos($row['torrent'], 'english-e-reader.net') === false) {
            $pathToFile = 'http://english-e-books.net' . $row['torrent'];
        }
        copy(htmlspecialchars_decode($pathToFile), $pathToLoad['torrent'] . $row['id'] . '.torrent' );
    }
}

//$img = 'http://english-e-books.net/books/elementary/At_the_Worlds_End-Irene_Trimble/At_the_Worlds_End-Irene_Trimble.jpg';
//copy($img, '../../src/img/books/1.jpg');