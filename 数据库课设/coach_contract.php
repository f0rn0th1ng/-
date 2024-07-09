<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$contract_num = isset($_GET['contract_num']) ? (int)$_GET['contract_num'] : 0;
$coach_num = isset($_GET['coach_num']) ? (int)$_GET['coach_num'] : 0;
if ($contract_num > 0) {
    $sql = 'SELECT contract_num, coach_num,contract_begin, contract_end, coach_salary FROM coach_contract WHERE contract_num = :contract_num ORDER BY contract_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['contract_num' => $contract_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else if($coach_num > 0){
    $sql = 'SELECT contract_num, coach_num,contract_begin, contract_end, coach_salary FROM coach_contract WHERE coach_num = :coach_num ORDER BY contract_num ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['coach_num' => $coach_num]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
else {
    $sql = 'SELECT contract_num,coach_num, contract_begin, contract_end, coach_salary FROM coach_contract ORDER BY contract_num ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/coach_contract.html';
?>
