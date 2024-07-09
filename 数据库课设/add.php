<?php
require './init_login.php';//验证是否有登录
if (!empty($_POST)){//用户提交了表单
    //获取表单中输入的数据
    $data = array();//用于存储表单中输入的数据的数组
    $data['title']=trim(htmlspecialchars($_POST['title']));//存储书名
    $data['author']=trim(htmlspecialchars($_POST['author']));//存储作者名
    $data['country']=trim(htmlspecialchars($_POST['country']));//存储国籍
    $data['content']=trim(htmlspecialchars($_POST['content']));//存储简介
    //连接数据库
    require 'info_db_connect.php';
    $sql='insert into info(title,author,country,content) values(:title,:author,:country,:content)';
    $stmt=$pdo->prepare($sql);//预编译sql语句
    $stmt->execute($data);//执行插入数据的sql语句
    header('Location:./index.php');//重定向到主页面
}

require './view/add.html';