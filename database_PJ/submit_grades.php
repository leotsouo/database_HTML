//評分提交處理腳本
<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamName = $_POST['teamName'];
    $workTitle = $_POST['workTitle'];
    $score = $_POST['gradeScore'];
    $comments = $_POST['comments'];

    try {
        // 查找隊伍ID
        $stmt = $pdo->prepare("SELECT TeamID FROM Team WHERE TeamName = ?");
        $stmt->execute([$teamName]);
        $teamID = $stmt->fetchColumn();

        if ($teamID) {
            $stmt = $pdo->prepare("INSERT INTO Score (TeamID, Criterion, ScoreValue, Comment) VALUES (?, ?, ?, ?)");
            $stmt->execute([$teamID, $workTitle, $score, $comments]);

            echo "評分提交成功！";
        } else {
            echo "找不到該隊伍，請確認隊伍名稱是否正確。";
        }
    } catch (PDOException $e) {
        echo "提交評分失敗：" . $e->getMessage();
    }
}
?>
