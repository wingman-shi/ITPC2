<?php
function getPDO(): PDO {
    $host = '127.0.0.1';
    $db   = 'student_login';
    $user = 'db_user';
    $pass = 'db_pass';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    return new PDO($dsn, $user, $pass, $opt);
}
