<?php
session_start();
include('functions.php');
check_session_id();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easychat AI</title>
    <link rel="stylesheet" href="css/chat.css">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/js/iziModal.min.js"></script>
    <script src="https://unpkg.com/ityped@1.0.2"></script>
    <fieldset>
        <legend>Calorie Tracker <br>【ユーザー名： <?= $_SESSION['username'] ?>】 </legend>
        <a href="eatchat_read.php">一覧画面</a>
        <a href="eatchat_add_info.php">基本情報</a>
        <a href="eatchat_logout.php">ログアウト</a>
        <div class="container">
            <div>
                <div class="box">
                    <input type="text" placeholder="質問入力or食事画像を添付してください" id="text">
                    <button type="button" class="btn1" onclick="generateResponse();">計算</button>
                    <button type="button" class="btn2" onclick="stopGenerate();">停止</button>
                </div>
                <div class="textBox">
                    <textarea id="output" disabled></textarea>
                </div>
            </div>
        </div>
    </fieldset>
    <script src="js/script.js"></script>
</body>

</html>