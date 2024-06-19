<?php
include 'functions.php'; // functions.php でセッションが開始

function connect_to_db()
{
    $dbn = 'mysql:dbname=gs_lab10_01;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('DB Error:' . $e->getMessage());
    }
}

$conn = connect_to_db();
