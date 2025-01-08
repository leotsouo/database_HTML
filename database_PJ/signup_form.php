<?php
require_once 'db_connection.php'; // 引入資料庫連接文件

try {
    // 從資料庫中抓取老師資料
    $sql = "SELECT TeacherID, Name FROM teacher";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC); // 獲取所有老師資料
} catch (PDOException $e) {
    die("無法獲取老師資料: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>創意競賽報名表</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef3fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 800px;
        }
        .form-container h1 {
            text-align: center;
            color: #0057b8;
            margin-bottom: 20px;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #0073e6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>創意競賽報名表</h1>
        <form id="multiStepForm" action="submit_form.php" method="POST">
            <!-- Step 1: 選擇老師 -->
            <div class="step active">
                <label for="teacher_id">選擇老師*</label>
                <select id="teacher_id" name="teacher_id" required>
                    <option value="">請選擇老師</option>
                    <?php
                    // 動態生成老師選項
                    foreach ($teachers as $teacher) {
                        echo "<option value=\"{$teacher['TeacherID']}\">{$teacher['Name']}</option>";
                    }
                    ?>
                </select>
                <button type="button" onclick="nextStep()">下一步</button>
            </div>

            <!-- Step 2: 團隊名稱與競賽組別 -->
            <div class="step">
                <label for="team-name">團隊名稱*</label>
                <input type="text" id="team-name" name="team_name" required>

                <label for="competition-category">競賽組別*</label>
                <select id="competition-category" name="competition_category" required>
                    <option value="">請選擇組別</option>
                    <option value="創意發想組">創意發想組</option>
                    <option value="創業實作組">創業實作組</option>
                </select>
                <button type="button" onclick="prevStep()">上一步</button>
                <button type="button" onclick="nextStep()">下一步</button>
            </div>

            <!-- Step 3: 作品資訊 -->
            <div class="step">
                <label for="project-name">作品名稱*</label>
                <input type="text" id="project-name" name="project_name" required>

                <label for="project-summary">作品摘要(300字以內)*</label>
                <textarea id="project-summary" name="project_summary" maxlength="300" required></textarea>
                <button type="button" onclick="prevStep()">上一步</button>
                <button type="button" onclick="nextStep()">下一步</button>
            </div>

            <!-- Step 4: 隊員資訊 -->
            <div class="step">
                <label>隊員資料*</label>
                <textarea name="members" placeholder="請輸入隊員資料，例如：姓名/學號/性別/電話/Email" required></textarea>
                <button type="button" onclick="prevStep()">上一步</button>
                <button type="submit">提交</button>
            </div>
        </form>
    </div>

    <script>
        const steps = document.querySelectorAll('.step');
        let currentStep = 0;

        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle('active', index === step);
            });
        }

        function nextStep() {
            const currentInputs = steps[currentStep].querySelectorAll('input, select, textarea');
            let valid = true;

            currentInputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    valid = false;
                }
            });

            if (valid && currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // 初始化顯示第一步
        showStep(currentStep);
    </script>
</body>
</html>
