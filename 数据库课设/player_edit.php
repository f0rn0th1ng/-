<?php
//用于编辑内容
require './init_login.php'; //验证是否有登录
require 'info_db_connect.php'; //连接数据库

$player_num = isset($_GET['player_num']) ? (int)$_GET['player_num'] : 0; //获取GET传参player_num值
if ($player_num <= 0) {
    exit('Invalid player_num');
}

$data = array('player_num' => $player_num); //将player_num值放到data数组中

// 查询语句
$sql = 'SELECT player_num, player_name, player_nation, player_age, player_position, coach_num, player_avatar FROM player WHERE player_num = :player_num';
$stmt = $pdo->prepare($sql); //编译查询语句
if (!$stmt->execute($data)) { //执行查询语句
    exit('查询失败: ' . implode(' ', $stmt->errorInfo())); //输出查询失败原因
}

$data = $stmt->fetch(PDO::FETCH_ASSOC); //将查询结果存储在数组data中
if (empty($data)) {
    exit('player_num不存在');
}

// 数据修改
if (!empty($_POST)) {
    $update_data = array(
        'player_name' => trim(htmlspecialchars($_POST['player_name'])),
        'player_nation' => trim(htmlspecialchars($_POST['player_nation'])),
        'player_age' => trim(htmlspecialchars($_POST['player_age'])),
        'player_position' => trim(htmlspecialchars($_POST['player_position'])),
        'coach_num' => trim(htmlspecialchars($_POST['coach_num'])),
        'original_player_num' => $player_num //使用GET参数中的player_num作为条件
    );

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
            $update_data['player_avatar'] = $player_avatar;
        } else {
            echo "文件上传失败。";
            exit;
        }
    } else {
        $update_data['player_avatar'] = $data['player_avatar']; // 保持原有头像
    }

    // 检查新的 coach_num 是否存在于 coach 表中
    $check_coach_sql = 'SELECT coach_num FROM coach WHERE coach_num = :coach_num';
    $check_stmt = $pdo->prepare($check_coach_sql);
    $check_stmt->execute(['coach_num' => $update_data['coach_num']]);
    if ($check_stmt->rowCount() == 0) {
        exit('不存在此教练编号');
    }

    // 将数据写入到数据库中（update）
    $sql = 'UPDATE player SET player_name = :player_name, player_nation = :player_nation, player_age = :player_age, player_position = :player_position, coach_num = :coach_num, player_avatar = :player_avatar WHERE player_num = :original_player_num';
    $stmt = $pdo->prepare($sql); //预编译SQL语句
    try {
        if (!$stmt->execute($update_data)) { //执行更新语句
            exit('更新失败: ' . implode(' ', $stmt->errorInfo()));
        } else {
            echo '更新成功';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // 外键约束失败的错误代码
            exit('不存在此教练编号');
        } else {
            exit('更新失败: ' . $e->getMessage());
        }
    }
}

require './view/player_edit.html';
?>
