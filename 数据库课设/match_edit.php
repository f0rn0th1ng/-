<?php
//用于编辑内容
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$match_num = isset($_GET['match_num']) ? (int)$_GET['match_num'] : 0; //获取get传参match_num值
$data = array('match_num' => $match_num); //将match_num值放到data数组中

$sql = 'SELECT match_num, match_date, competition_area, match_name,team_score,E_team_score FROM match_stats WHERE match_num = :match_num'; //查询语句
$stmt = $pdo->prepare($sql); //编译查询语句
if (!$stmt->execute($data)) { //执行查询语句
    exit('查询失败: ' . implode(' ', $stmt->errorInfo())); //输出查询失败原因
}
$data = $stmt->fetch(PDO::FETCH_ASSOC); //将查询结果存储在数组data中
if (empty($data)) {
    exit('match_num不存在');
}

//数据修改
if (!empty($_POST)) {
    $update_data = array(
        'match_date' => trim(htmlspecialchars($_POST['match_date'])),
        'competition_area' => trim(htmlspecialchars($_POST['competition_area'])),
        'match_name' => trim(htmlspecialchars($_POST['match_name'])),
        'team_score' => trim(htmlspecialchars($_POST['team_score'])),
        'E_team_score' => trim(htmlspecialchars($_POST['E_team_score'])),
        'match_num' => $match_num //使用GET参数中的match_num作为条件
    );

    //将数据写入到数据库中（update）
    $sql = 'UPDATE match_stats SET match_num=:match_num,match_date = :match_date, competition_area = :competition_area, match_name = :match_name,team_score=:team_score,E_team_score=:E_team_score WHERE match_num = :match_num';
    $stmt = $pdo->prepare($sql); //预编译SQL语句
    if (!$stmt->execute($update_data)) { //执行更新语句
        exit('更新失败: ' . implode(' ', $stmt->errorInfo()));
    } else {
        echo '更新成功';
    }
}

require './view/match_edit.html';
?>
