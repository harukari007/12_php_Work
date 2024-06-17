<?php
session_start();
include('functions.php');
check_session_id();


// include 'db.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST['email'];
//     $height = $_POST['height'];
//     $weight = $_POST['weight'];
//     $gender = $_POST['gender'];
//     $age = $_POST['age'];

//     $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $stmt->bind_result($user_id);
//     $stmt->fetch();
//     $stmt->close();

//     $stmt = $conn->prepare("INSERT INTO user_info (user_id, height, weight, gender, age) VALUES (?, ?, ?, ?, ?)");
//     $stmt->bind_param("iidss", $user_id, $height, $weight, $gender, $age);

//     if ($stmt->execute()) {
//         echo "Information added successfully!";
//     } else {
//         echo "Error: " . $stmt->error;
//     }

//     $stmt->close();
//     $conn->close();
// }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>基本情報登録画面</title>
    <link rel="stylesheet" href="css/info_register.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <fieldset>
        <a href="eatchat_read.php">一覧画面</a>
        <a href="chat_index.php">食事情報入力画面</a>
        <a href="eatchat_logout.php">ログアウト</a>

        <legend>基本情報登録画面【ユーザー名： <?= $_SESSION['username'] ?>】 </legend>
        <form id="infoForm" action="eatchat_create_addinfo.php" method="POST">
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="height">身長 (cm):</label>
            <input type="number" id="height" name="height" required><br>
            <label for="weight">体重 (kg):</label>
            <input type="number" id="weight" name="weight" required><br>
            <label for="gender">性別:</label>
            <select id="gender" name="gender" required>
                <option value="male">男性</option>
                <option value="female">女性</option>
            </select><br>
            <label for="age">年齢:</label>
            <input type="number" id="age" name="age" required><br>
            <input type="submit" value="Add Info">
        </form>
    </fieldset>
    <!-- <script>
        $("#infoForm").on("submit", function(event) {
            event.preventDefault();
            $.post("eatchat_add_info.php", $(this).serialize(), function(data) {
                alert(data);
            });
        });
    </script> -->
</body>

</html>