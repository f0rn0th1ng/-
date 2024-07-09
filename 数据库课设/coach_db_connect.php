<?php
//用于管理界面的数据库的连接
//设置DSN数据源
$dsn = 'mysql:host=localhost;dbname=LMS;charset=utf8';
//连接数据库
try {
    $pdo = new PDO($dsn,'root','85585562brs');//通过pdo连接数据源
}catch (PDOException $e){
    echo 'error--'.$e->getMessage();
}
