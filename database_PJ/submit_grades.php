<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamName = $_POST['teamName'];
    $teamMembers = explode(',', $_POST['teamMembers']);
    $projectDescription = $_POST['projectDescription'];
    $codeLink = $_POST['codeLink'];

    // 處理檔案上傳
    $documentationPath = 'uploads/' . basename($_FILES['documentation']['name']);
    $posterPath = 'uploads/' . basename($_FILES['poster']['name']);
    $demoVideoPath = 'uploads/' . basename($_FILES['demoVideo']['name']);

    if (
        move_uploaded_file($_FILES['documentation']['tmp_name'], $documentationPath) &&
        move_uploaded_file($_FILES['poster']['tmp_name'], $posterPath) &&
        move_uploaded_file($_FILES['demoVideo']['tmp_name'], $demoVideoPath)
    ) {
        try {
            // 插入隊伍資料
            $stmt = $pdo->prepare("INSERT INTO Team (TeamName, RegistrationDate) VALUES (?, NOW())");
            $stmt->execute([$teamName]);
            $teamID = $pdo->lastInsertId();

            // 插入隊伍成員資料
            foreach ($teamMembers as $member) {
                $stmt = $pdo->prepare("INSERT INTO TeamMember (TeamID, Name) VALUES (?, ?)");
                $stmt->execute([$teamID, trim($member)]);
            }

            // 插入作品資料
            $stmt = $pdo->prepare("INSERT INTO Submission (TeamID, DescriptionLink, PosterLink, VideoLink, CodeLink, UploadDate) 
                                    VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$teamID, $documentationPath, $posterPath, $demoVideoPath, $codeLink]);

            echo "作品提交成功！";
        } catch (PDOException $e) {
            echo "提交失敗：" . $e->getMessage();
        }
    } else {
        echo "檔案上傳失敗，請檢查目錄權限或檔案格式。";
    }
}
?>
