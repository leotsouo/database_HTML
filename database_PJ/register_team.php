<?php
include 'db_connection.php'; // 連接資料庫的共用腳本

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamName = $_POST['teamName']; // 從表單接收隊伍名稱
    $teamMembers = explode(',', $_POST['teamMembers']); // 用逗號分隔成員名稱並轉成陣列
    $teacherID = $_POST['teacherID']; // 從表單接收 TeacherID

    try {
        // 檢查 TeacherID 是否存在
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Teacher WHERE TeacherID = ?");
        $stmt->execute([$teacherID]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception("指定的 TeacherID 不存在。");
        }

        // 插入隊伍資料到 Team 表
        $stmt = $pdo->prepare("INSERT INTO Team (TeacherID, TeamName, RegistrationDate) VALUES (?, ?, NOW())");
        $stmt->execute([$teacherID, $teamName]);
        $teamID = $pdo->lastInsertId(); // 獲取自動生成的 TeamID

        // 插入每個隊伍成員到 TeamMember 表
        foreach ($teamMembers as $member) {
            $member = trim($member); // 去掉多餘的空格
            $stmt = $pdo->prepare("INSERT INTO TeamMember (TeamID, Name) VALUES (?, ?)");
            $stmt->execute([$teamID, $member]);
        }

        echo "隊伍報名成功！";
    } catch (Exception $e) {
        // 處理資料庫操作失敗的錯誤
        echo "報名失敗：" . $e->getMessage();
    }
} else {
    // 當不是 POST 請求時
    echo "無效的請求方式。";
}
?>
