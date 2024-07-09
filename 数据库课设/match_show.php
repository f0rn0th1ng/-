<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$match_num = isset($_GET['match_num']) ? (int)$_GET['match_num'] : 0;

if ($match_num > 0) {
    $sql = 'SELECT p.player_num, p.player_name, p.player_nation, p.player_age, p.player_position
            FROM player_matches pm
            JOIN player p ON pm.player_num = p.player_num
            WHERE pm.match_num = :match_num
            ORDER BY pm.match_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['match_num' => $match_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
else {
    $sql = 'SELECT p.player_num, p.player_name, p.player_nation, p.player_age, p.player_position
            FROM player_matches pm
            JOIN player p ON pm.player_num = p.player_num
            ORDER BY pm.match_num ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/match_show.html';
?>
