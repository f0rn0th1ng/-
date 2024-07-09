<?php
require './init_login.php';//验证是否有登录

if (!empty($_POST)) { // 用户提交了表单
    // 获取表单中输入的数据
    $data = array(); // 用于存储表单中输入的数据的数组
    $data['coach_num'] = trim(htmlspecialchars($_POST['coach_num'])); // 存储教练编号
    $data['contract_begin'] = trim(htmlspecialchars($_POST['contract_begin'])); // 存储合同开始日期
    $data['contract_end'] = trim(htmlspecialchars($_POST['contract_end'])); // 存储合同结束日期
    $data['coach_salary'] = trim(htmlspecialchars($_POST['coach_salary'])); // 存储教练薪水

    // 连接数据库
    require 'info_db_connect.php';
    $sql = 'INSERT INTO coach_contract (coach_num, contract_begin, contract_end, coach_salary) 
            VALUES (:coach_num, :contract_begin, :contract_end, :coach_salary)';
    $stmt = $pdo->prepare($sql); // 预编译 SQL 语句
    if ($stmt->execute($data)) { // 执行插入数据的 SQL 语句
        header('Location: ./coach_contract.php'); // 重定向到主页面
        exit;
    } else {
        echo '数据库插入失败。';
    }
}

require './view/contract_add.html';
