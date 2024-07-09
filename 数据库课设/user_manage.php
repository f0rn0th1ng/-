<?php
//主页
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = 'SELECT id, username, u_role FROM user WHERE id = :id ORDER BY id ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = 'SELECT id, username, u_role FROM user ORDER BY id ASC';
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require './view/user_manage.html';
?>
