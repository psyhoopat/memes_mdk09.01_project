<?php

function write_upload_file(
    string $file_tmp, 
    string $file_path
): bool {
    return move_uploaded_file($file_tmp, $file_path);
}

function write_file($name, $desc, $file) {
    $f = fopen('static/data.txt', 'a');
    $str = "Имя: $name, Описание: $desc, Файл: $file \n";
    fwrite($f, $str);
}