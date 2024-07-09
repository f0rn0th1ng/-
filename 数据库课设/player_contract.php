<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$contract_num = isset($_GET['contract_num']) ? (int)$_GET['contract_num'] : 0;
$player_num = isset($_GET['player_num']) ? (int)$_GET['player_num'] : 0;

if ($contract_num > 0) {
    $sql = 'SELECT contract_num, player_num,contract_begin, contract_end, player_salary FROM player_contract WHERE contract_num = :contract_num ORDER BY contract_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['contract_num' => $contract_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else if($player_num>0){
    $sql = 'SELECT contract_num, player_num,contract_begin, contract_end, player_salary FROM player_contract WHERE player_num = :player_num ORDER BY contract_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['player_num' => $player_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
else {
    $sql = 'SELECT contract_num,player_num, contract_begin, contract_end, player_salary FROM player_contract ORDER BY contract_num ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/player_contract.html';
?>
