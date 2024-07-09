<?php
//用于编辑内容
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$coach_num = isset($_GET['coach_num']) ? (int)$_GET['coach_num'] : 0; //获取get传参coach_num值
$data = array('coach_num' => $coach_num); //将coach_num值放到data数组中

$sql = 'SELECT coach_num, coach_name, coach_age, coach_country FROM coach WHERE coach_num = :coach_num'; //查询语句
$stmt = $pdo->prepare($sql); //编译查询语句
if (!$stmt->execute($data)) { //执行查询语句
    exit('查询失败: ' . implode(' ', $stmt->errorInfo())); //输出查询失败原因
}
$data = $stmt->fetch(PDO::FETCH_ASSOC); //将查询结果存储在数组data中
if (empty($data)) {
    exit('coach_num不存在');
}

//数据修改
if (!empty($_POST)) {
    $update_data = array(
        'coach_name' => trim(htmlspecialchars($_POST['coach_name'])),
        'coach_age' => trim(htmlspecialchars($_POST['coach_age'])),
        'coach_country' => trim(htmlspecialchars($_POST['coach_country'])),
        'coach_num' => $coach_num //使用GET参数中的coach_num作为条件
    );

    //将数据写入到数据库中（update）
    $sql = 'UPDATE coach SET coach_num=:coach_num,coach_name = :coach_name, coach_age = :coach_age, coach_country = :coach_country WHERE coach_num = :coach_num';
    $stmt = $pdo->prepare($sql); //预编译SQL语句
    if (!$stmt->execute($update_data)) { //执行更新语句
        exit('更新失败: ' . implode(' ', $stmt->errorInfo()));
    } else {
        echo '更新成功';
    }
}

require './view/edit.html';
?>
