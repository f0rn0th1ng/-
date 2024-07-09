<?php
// 验证是否有登录，无登录则跳转登录界面
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// 连接数据库
require 'login_db_connect.php';

// 获取当前用户的角色
$username = $_SESSION['username'];
$sql = "SELECT role FROM user WHERE username = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $role);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// 检查用户是否为 admin 角色
if ($role !== 'admin') {
    exit('无访问权限。');
}

// 如果是 admin 角色，继续执行后续代码
?>
