<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$player_num = isset($_GET['player_num']) ? (int)$_GET['player_num'] : 0;

if ($player_num > 0) {
    $sql = 'SELECT player_num, player_name, player_nation, player_age, player_position, coach_num, player_avatar FROM player WHERE player_num = :player_num ORDER BY player_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['player_num' => $player_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = 'SELECT player_num, player_name, player_nation, player_age, player_position, coach_num, player_avatar FROM player ORDER BY player_num ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/player_table.html';
?>
