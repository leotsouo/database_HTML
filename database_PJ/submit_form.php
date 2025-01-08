<?php
require_once 'db_connection.php'; // 引入資料庫連接文件
// 測試接收到的資料
echo "<pre>";
print_r($_POST);
echo "</pre>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 第一步：從表單獲取資料
        $teacher_id = $_POST['teacher_id']; // 選擇的老師 ID
        $team_name = $_POST['team_name']; // 隊伍名稱
        $registration_date = $_POST['registration_date']; // 報名日期
        $members = $_POST['members']; // 隊員資料（假設是陣列形式）

        // 第二步：插入到 team 表
        $sql_team = "INSERT INTO team (TeamName, RegistrationDate, TeacherID) 
                     VALUES (:team_name, :registration_date, :teacher_id)";
        $stmt_team = $pdo->prepare($sql_team);
        $stmt_team->bindParam(':team_name', $team_name);
        $stmt_team->bindParam(':registration_date', $registration_date);
        $stmt_team->bindParam(':teacher_id', $teacher_id);
        $stmt_team->execute();

        // 獲取插入的 TeamID
        $team_id = $pdo->lastInsertId();

        // 第三步：插入到 teammember 表
        $sql_member = "INSERT INTO teammember (TeamID, Name, StudentID, Gender, Phone, Email) 
                       VALUES (:team_id, :name, :student_id, :gender, :phone, :email)";
        $stmt_member = $pdo->prepare($sql_member);

        foreach ($members as $member) {
            // 獲取隊員資料
            $name = $member['name'];
            $student_id = $member['student_id'];
            $gender = $member['gender'];
            $phone = $member['phone'];
            $email = $member['email'];

            // 綁定參數並執行插入
            $stmt_member->bindParam(':team_id', $team_id);
            $stmt_member->bindParam(':name', $name);
            $stmt_member->bindParam(':student_id', $student_id);
            $stmt_member->bindParam(':gender', $gender);
            $stmt_member->bindParam(':phone', $phone);
            $stmt_member->bindParam(':email', $email);
            $stmt_member->execute();
        }

        echo "隊伍和隊員資料成功插入！";
    } catch (Exception $e) {
        echo "錯誤: " . $e->getMessage();
    }
} else {
    echo "無效的請求方法。";
}
