<?php

    // 引入数据库文件
    require_once __DIR__.'/config.php';

    try {
        $pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE.';',USER,PWD);
        if ($pdo) {
            return $pdo;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
