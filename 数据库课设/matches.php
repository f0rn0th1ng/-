<?php
// 连接数据库
require './init_login.php';
require 'info_db_connect.php';

// 获取当前日期
$current_date = date('Y-m-d');
echo "当前日期: " . $current_date . "<br>";

// 查询离今天最近的两个比赛信息
$sql = 'SELECT match_date, match_name 
        FROM match_stats 
        WHERE match_date >= :current_date 
        ORDER BY match_date ASC 
        LIMIT 2';
$stmt = $pdo->prepare($sql);
$stmt->execute(['current_date' => $current_date]);
$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 检查查询结果
if (!empty($matches)) {
    echo "查询到的比赛信息:<br>";
    foreach ($matches as $match) {
        echo "比赛日期: " . $match['match_date'] . " - 比赛名称: " . $match['match_name'] . "<br>";
    }
} else {
    echo "没有即将到来的比赛。<br>";
}

// 将数据传递到HTML
include '..view/index.html';
?>
