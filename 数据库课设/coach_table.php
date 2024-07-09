<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$coach_num = isset($_GET['coach_num']) ? (int)$_GET['coach_num'] : 0;

if ($coach_num > 0) {
    $sql = 'SELECT coach_num, coach_name, coach_age, coach_country,coach_avatar FROM coach WHERE coach_num = :coach_num ORDER BY coach_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['coach_num' => $coach_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = 'SELECT coach_num, coach_name, coach_age, coach_country,coach_avatar FROM coach ORDER BY coach_num ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/coach_table.html';
?>
