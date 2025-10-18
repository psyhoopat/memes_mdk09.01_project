<?php

function db_connect(): mysqli {
    try {
        $mysqli = new mysqli(
            "localhost",
            "root",
            "1234",
            "dbmemes"
        );
        if ($mysqli->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit;
        }

        return $mysqli;
    } catch (Exception $ex) {
        printf("Connect failed: %s\n", $ex->getMessage());
        exit;
    }
}

function create_post($name, $desc, $img) {
    try {
        $mysqli = db_connect();

        $sql = "INSERT INTO meme (`name`, `description`, `img`) VALUES 
            ('$name', '$desc', '$img');";

        $result = $mysqli->query($sql);
        $mysqli->close();

        return $result;
    } catch (Exception $ex) {
        printf("Mysql error: %s\n", $ex->getMessage());
        exit;
    }
}

function get_meme() {
    try {
        $mysqli = db_connect();

        $sql = "SELECT * FROM `meme`;";

        $result = $mysqli->query($sql);
        $mysqli->close();

        return $result;
    } catch (Exception $ex) {
        printf("Mysql error: %s\n", $ex->getMessage());
        exit;
    }
}