<?php
require './init_login.php';//验证是否有登录
if (!empty($_POST)){//用户提交了表单
    //获取表单中输入的数据
    $data = array();//用于存储表单中输入的数据的数组
    $data['match_num']=trim(htmlspecialchars($_POST['match_num']));//存储合同编号
    $data['player_num']=trim(htmlspecialchars($_POST['player_num']));//存储教练编号
    //连接数据库
    require 'info_db_connect.php';
    $sql='insert into player_matches(match_num,player_num) values(:match_num,:player_num)';
    $stmt=$pdo->prepare($sql);//预编译sql语句
    $stmt->execute($data);//执行插入数据的sql语句
    header('Location:./match_table.php');//重定向到主页面
}

require './view/match_show_add.html';