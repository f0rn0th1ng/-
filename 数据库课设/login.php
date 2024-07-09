<?php
header('content-type:text/html;charset=utf-8');
//登录界面
require 'login_db_connect.php'; // 连接数据库

// 判断表单是否提交,用户名密码是否提交
if (isset($_POST['username']) && isset($_POST['password'])) { // 登录表单已提交
    
    // 获取用户输入的验证码
    $captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
    // 获取Session中的验证码
    session_start();
    if (empty($_SESSION['captcha'])) {  // 如果Session中不存在验证码，则退出
        exit('验证码已经过期，请返回并刷新页面重试。');
    }
    // 获取验证码并清除Session中的验证码
    $true_captcha = $_SESSION['captcha'];
    unset($_SESSION['captcha']); // 限制验证码只能验证一次，防止重复利用
    // 忽略字符串的大小写，进行比较
    if (strtolower($captcha) !== strtolower($true_captcha)) {
        exit('您输入的验证码不正确！请返回并刷新页面重试。');
    }
    // 验证码验证通过，继续判断用户名和密码
    // 获取用户输入的用户名密码
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $sql = "SELECT id, username, password FROM user_view WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $pwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) === 0) { // 若返回条目不存在则证明该账号不存在或者密码输入错误
        echo "<script>alert('账号不存在或密码错误，点击前往注册');location='./register.php'</script>";
    } else { // 存在返回条目证明用户账号密码匹配，进入主页面
        session_start();
        $_SESSION['username'] = $_POST['username'];
        echo "<script>alert('欢迎');location='./index.php'</script>";
    }
}

require './view/login.html';
