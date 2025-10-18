<?php

function decode_path_img(string $full_path): string {
    $date = date("Y-m-d");
    $time = date("H-i-s");
    $random = rand(100, 200);
    $path = md5($full_path);

    $fileExt = strtolower(pathinfo($full_path, PATHINFO_EXTENSION));
    return "static/img/($random)-$date-($time)-$path.$fileExt";
}

function write_file($name, $desc, $file) {
    $f = fopen('static/data.txt', 'a');
    $str = "Имя: $name, Описание: $desc, Файл: $file \n";
    fwrite($f, $str);
}