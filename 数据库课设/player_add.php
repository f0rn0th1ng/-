<?php
require './init_login.php'; // 验证是否有登录

if (!empty($_POST)) { // 用户提交了表单
    // 获取表单中输入的数据
    $data = array(); // 用于存储表单中输入的数据的数组
    $data['player_name'] = trim(htmlspecialchars($_POST['player_name'])); // 存储球员姓名
    $data['player_nation'] = trim(htmlspecialchars($_POST['player_nation'])); // 存储球员国籍
    $data['player_age'] = trim(htmlspecialchars($_POST['player_age'])); // 存储球员年龄
    $data['player_position'] = trim(htmlspecialchars($_POST['player_position'])); // 存储球员位置
    $data['coach_num'] = trim(htmlspecialchars($_POST['coach_num'])); // 存储教练编号
    $player_avatar = '';

    // 处理文件上传
    if (isset($_FILES['player_avatar']) && $_FILES['player_avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'C:/Users/f0rn0th1ng/Desktop/database_design/LMS/uploads/';
        $file_name = basename($_FILES['player_avatar']['name']);
        $target_file = $upload_dir . $file_name;

        // 检查目标目录是否存在，如果不存在则创建
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // 移动上传文件到目标目录
        if (move_uploaded_file($_FILES['player_avatar']['tmp_name'], $target_file)) {
            $player_avatar = $file_name;
            $data['player_avatar'] = $player_avatar;
        } else {
            echo "文件上传失败。";
            exit;
        }
    } else {
        $data['player_avatar'] = ''; // 如果没有上传文件，设置为空字符串
    }

    // 连接数据库
    require 'info_db_connect.php';
    $sql = 'INSERT INTO player ( player_name, player_nation, player_age, player_position, coach_num, player_avatar) 
            VALUES (:player_name, :player_nation, :player_age, :player_position, :coach_num, :player_avatar)';
    $stmt = $pdo->prepare($sql); // 预编译 SQL 语句
    $stmt->execute($data); // 执行插入数据的 SQL 语句
    header('Location: ./player_table.php'); // 重定向到主页面
}

require './view/player_add.html';
