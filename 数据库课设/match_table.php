<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$match_num = isset($_GET['match_num']) ? (int)$_GET['match_num'] : 0;
$match_date = isset($_GET['match_date']) ? (int)$_GET['match_date'] : 0;
if ($match_num > 0) {
    $sql = 'SELECT match_num, match_name,competition_area,match_date,team_score,E_team_score FROM match_stats WHERE match_num = :match_num ORDER BY match_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['match_num' => $match_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else if($match_date > 0){
    $sql = 'SELECT match_num, match_name,competition_area,match_date,team_score,E_team_score FROM match_stats WHERE match_name = :match_name ORDER BY match_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['match_date' => $match_date]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
else {
    $sql = 'SELECT match_num,match_name,competition_area,match_date,team_score,E_team_score FROM match_stats ORDER BY match_num ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/match_table.html';
?>
