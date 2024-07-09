<?php
require './init_login.php'; // 验证是否有登录

if (!empty($_POST)) { // 用户提交了表单
    // 获取表单中输入的数据
    $data = array(); // 用于存储表单中输入的数据的数组
    $data['coach_name'] = trim(htmlspecialchars($_POST['coach_name'])); // 存储教练姓名
    $data['coach_country'] = trim(htmlspecialchars($_POST['coach_country'])); // 存储教练国籍
    $data['coach_age'] = trim(htmlspecialchars($_POST['coach_age'])); // 存储教练年龄
    $coach_avatar = '';

    // 处理文件上传
    if (isset($_FILES['coach_avatar']) && $_FILES['coach_avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'C:/Users/f0rn0th1ng/Desktop/database_design/LMS/uploads/';
        $file_name = basename($_FILES['coach_avatar']['name']);
        $target_file = $upload_dir . $file_name;

        // 检查目标目录是否存在，如果不存在则创建
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // 移动上传文件到目标目录
        if (move_uploaded_file($_FILES['coach_avatar']['tmp_name'], $target_file)) {
            $coach_avatar = $file_name;
            $data['coach_avatar'] = $coach_avatar;
        } else {
            echo "文件上传失败。";
            exit;
        }
    } else {
        $data['coach_avatar'] = ''; // 如果没有上传文件，设置为空字符串
    }

    // 连接数据库
    require 'info_db_connect.php';
    $sql = 'INSERT INTO coach (coach_name, coach_country, coach_age, coach_avatar) 
            VALUES (:coach_name, :coach_country, :coach_age, :coach_avatar)';
    $stmt = $pdo->prepare($sql); // 预编译 SQL 语句
    if ($stmt->execute($data)) { // 执行插入数据的 SQL 语句
        header('Location: ./coach_table.php'); // 重定向到主页面
        exit;
    } else {
        echo '数据库插入失败。';
    }
}

require './view/coach_add.html';
?>
