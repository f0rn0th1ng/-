<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>球队管理系统</title>
<link rel="stylesheet" href="css/style.css"/>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    .box {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .top {
        background-color: #007BFF;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    .title {
        color: #fff;
        font-size: 24px;
        text-align: center;
        margin: 0;
    }
    .nav {
        margin-top: 20px;
        text-align: center;
    }
    .nav a {
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #0056b3;
        border-radius: 5px;
        margin: 0 5px;
        display: inline-block;
    }
    .nav a:hover {
        background-color: #003d80;
    }
    .main {
        padding: 20px;
    }
    .section {
        margin-bottom: 20px;
    }
    .section h2 {
        margin-top: 0;
    }
    .stats, .calendar {
        margin-top: 20px;
    }
    .calendar table {
        width: 100%;
        border-collapse: collapse;
    }
    .calendar th, .calendar td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }
    .profile {
        text-align: center;
        margin-top: 20px;
    }
    .profile img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }
    .profile p {
        margin-top: 10px;
        font-size: 16px;
        color: #333;
    }
    .details-button {
        display: inline-block;
        padding: 5px 10px;
        margin-left: 10px;
        background-color: #007BFF;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
    }
    .details-button:hover {
        background-color: #0056b3;
    }
    .finances {
        margin-top: 20px;
    }
    .finances table {
        width: 100%;
        border-collapse: collapse;
    }
    .finances th, .finances td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }
</style>
</head>
<body>
<div class="box">
    <div class="top">
        <div class="title">球队管理系统</div>
        <div class="nav">
            <a href="logout.php">退出登录</a>
            <a href="coach_table.php">教练模块</a>
            <a href="player_table.php">球员模块</a>
            <a href="match_table.php">赛事模块</a>
            <a href="user_manage.php">用户管理</a>
        </div>
    </div>
    <div class="main">
        <div class="section">
            <h2>欢迎来到球队管理系统</h2>
            <p>在这里你可以管理球队的教练和球员，查看最新消息和公告，以及了解球队的相关统计数据。</p>
        </div>
        <div class="section">
            <h2>最新消息和公告</h2>
            <ul>
                <li>2024年6月12日 - 球队将参加地上足球市级比赛。</li>
                <li>2024年6月15日 - 新教练李老八加入<a href="./view/laoba.html" class="details-button">查看详情</a></li>
                <!-- 更多消息 -->
            </ul>
        </div>
        <div class="section calendar">
            <h2>球队赛历</h2>
            <table>
                <tr>
                    <th>日期</th>
                    <th>事件</th>
                </tr>
                <?php
                // 连接数据库
                require 'init_login.php';
                require 'info_db_connect.php';

                // 获取当前日期
                $current_date = date('Y-m-d');

                // 查询离今天最近的两个比赛信息
                $sql = 'SELECT match_date, match_name 
                        FROM match_stats 
                        WHERE match_date >= :current_date 
                        ORDER BY match_date ASC 
                        LIMIT 2';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['current_date' => $current_date]);
                $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 检查查询结果
                if (!empty($matches)) {
                    foreach ($matches as $match) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($match['match_date']) . '</td>';
                        echo '<td>' . htmlspecialchars($match['match_name']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">没有即将到来的比赛</td></tr>';
                }

                // 调用存储过程查询教练薪资总和
                $stmt = $pdo->prepare("CALL CalculateTotalCoachSalary(@total_coach_salary)");
                $stmt->execute();
                $stmt = $pdo->query("SELECT @total_coach_salary AS total_coach_salary");
                $total_coach_salary = $stmt->fetch(PDO::FETCH_ASSOC)['total_coach_salary'];

                // 调用存储过程查询球员薪资总和
                $stmt = $pdo->prepare("CALL CalculateTotalPlayerSalary(@total_player_salary)");
                $stmt->execute();
                $stmt = $pdo->query("SELECT @total_player_salary AS total_player_salary");
                $total_player_salary = $stmt->fetch(PDO::FETCH_ASSOC)['total_player_salary'];
                ?>
            </table>
        </div>
        <div class="section finances">
            <h2>球队资金情况</h2>
            <table>
                <tr>
                    <th>教练薪资总和</th>
                    <th>球员薪资总和</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($total_coach_salary); ?></td>
                    <td><?php echo htmlspecialchars($total_player_salary); ?></td>
                </tr>
            </table>
        </div>
        <div class="section profile">
            <h2>社交媒体</h2>
            <img src="./images/f0rn0th1ng.png" alt="Profile Picture">
            <p>邮箱: f0rn0th1ng@163.com</p>
        </div>
    </div>
</div>
</body>
</html>
