<?php
//用于编辑内容
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$contract_num = isset($_GET['contract_num']) ? (int)$_GET['contract_num'] : 0; //获取GET传参contract_num值
if ($contract_num <= 0) {
    exit('Invalid contract_num');
}

$data = array('contract_num' => $contract_num); //将contract_num值放到data数组中

// 查询语句
$sql = 'SELECT contract_num, player_num, contract_begin, contract_end, player_salary FROM player_contract WHERE contract_num = :contract_num';
$stmt = $pdo->prepare($sql); //编译查询语句
if (!$stmt->execute($data)) { //执行查询语句
    exit('查询失败: ' . implode(' ', $stmt->errorInfo())); //输出查询失败原因
}

$data = $stmt->fetch(PDO::FETCH_ASSOC); //将查询结果存储在数组data中
if (empty($data)) {
    exit('contract_num不存在');
}

// 数据修改
if (!empty($_POST)) {
    $update_data = array(
        'contract_num' => trim(htmlspecialchars($_POST['contract_num'])),
        'player_num' => trim(htmlspecialchars($_POST['player_num'])),
        'contract_begin' => trim(htmlspecialchars($_POST['contract_begin'])),
        'contract_end' => trim(htmlspecialchars($_POST['contract_end'])),
        'player_salary' => trim(htmlspecialchars($_POST['player_salary'])),
        'original_contract_num' => $contract_num //使用GET参数中的contract_num作为条件
    );

    // 检查新的 player_num 是否存在于 coach 表中
    $check_coach_sql = 'SELECT player_num FROM player WHERE player_num = :player_num';
    $check_stmt = $pdo->prepare($check_coach_sql);
    $check_stmt->execute(['player_num' => $update_data['player_num']]);
    if ($check_stmt->rowCount() == 0) {
        exit('不存在此教练编号');
    }

    // 将数据写入到数据库中（update）
    $sql = 'UPDATE player_contract SET contract_num = :contract_num, player_num = :player_num, contract_begin = :contract_begin, contract_end = :contract_end, player_salary = :player_salary WHERE contract_num = :original_contract_num';
    $stmt = $pdo->prepare($sql); //预编译SQL语句
    try {
        if (!$stmt->execute($update_data)) { //执行更新语句
            exit('更新失败: ' . implode(' ', $stmt->errorInfo()));
        } else {
            echo '更新成功';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // 外键约束失败的错误代码
            exit('不存在此球员编号');
        } else {
            exit('更新失败: ' . $e->getMessage());
        }
    }
}

require './view/player_contract_edit.html';
?>
