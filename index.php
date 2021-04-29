<?php
	require_once __DIR__.'/lib/db.php';
	require_once __DIR__.'/class/User.php';
    require_once __DIR__.'/class/Article.php';

//    $user = new User($pdo);
//    $user->regist('ningcaichen','111111');
//    $resu = $user->login('ningcaichen', '111111');

    $article = new Article($pdo);
    $res =  $article->add_article(24,'七岁打死想', '七岁打死想七岁打死想七岁打死想七岁打死想');
    print_r($res);