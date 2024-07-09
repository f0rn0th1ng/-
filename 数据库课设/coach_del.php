<?php
// 用于删除内容
require './init_login.php'; // 验证是否有登录
require 'info_db_connect.php'; // 连接数据库

// 启用错误报告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$coach_num = isset($_GET['coach_num']) ? (int)$_GET['coach_num'] : 0; // 获取get传参id值
$data = array(':coach_num' => $coach_num); // 将id值放到data数组中

try {
    // 删除数据的sql语句
    $sql = 'DELETE FROM coach WHERE coach_num = :coach_num';
    // 预处理
    $stmt = $pdo->prepare($sql);

    // 执行sql语句
    if (!$stmt->execute($data)) {
        exit('删除失败: ' . implode('-', $stmt->errorInfo()));
    }

    // 重定向到主页面
    header('Location: coach_table.php');
} catch (PDOException $e) {
    // 判断是否为外键约束错误
    if ($e->getCode() == '23000') {
        exit('删除失败: 请先删除与该教练相关的信息');
    } else {
        exit('删除失败: ' . $e->getMessage());
    }
}
?>
