<?php
require './init_login.php';//验证是否有登录
if (!empty($_POST)){//用户提交了表单
    //获取表单中输入的数据
    $data = array();//用于存储表单中输入的数据的数组
    $data['match_name']=trim(htmlspecialchars($_POST['match_name']));//存储教练编号
    $data['competition_area']=trim(htmlspecialchars($_POST['competition_area']));//存储合同开始日期
    $data['match_date']=trim(htmlspecialchars($_POST['match_date']));//存储合同结束日期
    $data['team_score']=trim(htmlspecialchars($_POST['team_score']));//存储合同结束日期
    $data['E_team_score']=trim(htmlspecialchars($_POST['E_team_score']));//存储合同结束日期
    //连接数据库
    require 'info_db_connect.php';
    $sql='insert into match_stats(match_name,competition_area,match_date,team_score,E_team_score) values(:match_name,:competition_area,:match_date,:team_score,:E_team_score)';
    $stmt=$pdo->prepare($sql);//预编译sql语句
    $stmt->execute($data);//执行插入数据的sql语句
    header('Location:./match_table.php');//重定向到主页面
}

require './view/match_add.html';