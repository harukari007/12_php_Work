<?php
session_start();
include('functions.php');
check_session_id();

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
    </fieldset>
    <fieldset>
        <legend>基本情報登録画面<br>【ユーザー名： <?= $_SESSION['username'] ?>】 </legend>
        <a href="eatchat_read.php">過去のレシピ一覧画面</a>
        <a href="chat_index.php">レシピ生成画面</a>
        <a href="eatchat_logout.php">ログアウト</a>

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
            <input type="submit" value="登録する">
        </form>
    </fieldset>
</body>

</html>