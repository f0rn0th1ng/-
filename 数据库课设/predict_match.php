<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['players'])) {
    $selected_players = $_POST['players'];

    // 连接数据库
    require 'info_db_connect.php';

    // 获取选定球员的统计数据
    $placeholders = implode(',', array_fill(0, count($selected_players), '?'));
    $sql = 'SELECT player_num, player_name, goals, assists FROM player WHERE player_num IN (' . $placeholders . ')';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($selected_players);
    $player_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 简单的预测逻辑 (这里只是一个示例，可以根据实际需求调整)
    $total_goals = 0;
    $total_assists = 0;

    foreach ($player_stats as $stats) {
        $total_goals += $stats['goals'];
        $total_assists += $stats['assists'];
    }

    $predicted_score = round($total_goals / 13); // 假设每场比赛有13名球员
    $predicted_assists = round($total_assists / 13);

    echo '<h3>预测结果</h3>';
    echo '<p>预期进球数: ' . $predicted_score . '</p>';
    echo '<p>预期助攻数: ' . $predicted_assists . '</p>';
} else {
    echo '<p>请选择至少一个球员。</p>';
}
require './view/predict_match.html';
?>
