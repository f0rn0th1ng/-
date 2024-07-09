<?php
//内容详情页
require './init_login.php';//判断是否登录
require 'info_db_connect.php';//连接数据库

$id=isset($_GET['id'])?(int)$_GET['id']:0;//获取get传参id值
$data=array('id'=>$id);//将id值放到data数组中

$sql='select id,title,content,author,country,addtime from info where id=:id';//:id占位符
$stmt=$pdo->prepare($sql);//对于查询语句进行编译PDOStatement对象
if (!$stmt->execute($data)){//执行查询语句
    exit('查询失败'.implode(' ', $stmt->errorInfo()));//输出查询失败原因
}
$data = $stmt->fetch(PDO::FETCH_ASSOC);//将查询结果存储在数组data中
if(empty($data)){
    echo ('编号不存在');
}


require './view/show.html';
