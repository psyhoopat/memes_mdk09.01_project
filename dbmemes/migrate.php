<?php

require_once __DIR__ . "/../lib/mysqli.php";

try {
    $mysql = db_connect();

    $sql = "CREATE TABLE IF NOT EXISTS `meme` (
              `id` int NOT NULL AUTO_INCREMENT,
              `name` varchar(45) NOT NULL,
              `description` longtext NOT NULL,
              `img` varchar(200) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `id_UNIQUE` (`id`)
            );";
    $mysql->query($sql);

    $result = $mysql->query("SELECT * FROM `meme`");
    if($result->num_rows == 0) {
        // seed data
        $sql = "INSERT INTO `meme` (`id`, `name`, `description`, `img`) VALUES 
               (1,'Дуалинго','Птичка дуалинго','/static/img/img1.jpg'),
               (2,'Скебоб','Кто такой скебоб.','/static/img/img2.jpg'),
               (3,'Супчик', 'Откуда дым?','/static/img/img3.jpg');
            ";
        $mysql->query($sql);
    }

    $mysql->close();

    printf("Миграция таблиц успешна!");
} catch (Exception $ex) {
    printf("Mysql error: %s\n", $ex->getMessage());
    exit;
}