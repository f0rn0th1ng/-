<?php
// 用于删除内容
require './init_login.php'; // 验证是否有登录
require 'info_db_connect.php'; // 连接数据库

// 启用错误报告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$contract_num = isset($_GET['contract_num']) ? (int)$_GET['contract_num'] : 0; // 获取get传参id值
$data = array(':contract_num' => $contract_num); // 将id值放到data数组中

// 删除数据的sql语句
$sql = 'DELETE FROM coach_contract WHERE contract_num = :contract_num';
// 预处理
$stmt = $pdo->prepare($sql);

// 执行sql语句
if (!$stmt->execute($data)) {
    exit('删除失败: ' . implode('-', $stmt->errorInfo()));
}

// 重定向到主页面
header('Location: coach_contract.php');
?>
