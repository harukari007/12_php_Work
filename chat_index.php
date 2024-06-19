<?php
session_start();
include('functions.php');
check_session_id();

$conn = connect_to_db(); // データベース接続

// ユーザー名をセッションから取得
$username = $_SESSION['username'];

// ユーザーIDをデータベースから取得
$stmt = $conn->prepare("SELECT id FROM users_table WHERE username = ?");
$stmt->execute([$username]);
$user_id = $stmt->fetchColumn();

// 最新のBMRを取得
$stmt = $conn->prepare("SELECT bmr, created_at FROM BMR_DB WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$user_id]);
$bmr_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bmr_data) {
    $bmr = "データがありません";
    $created_at = "";
} else {
    $bmr = $bmr_data['bmr'];
    $created_at = $bmr_data['created_at'];
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CalorieCura</title>
    <link rel="stylesheet" href="css/chat.css">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/js/iziModal.min.js"></script>
    <script src="https://unpkg.com/ityped@1.0.2"></script>

    <fieldset>

        <legend> CalorieCura<br>【ユーザー名： <?= $_SESSION['username'] ?>】 </legend>

        </div>
        <a href="eatchat_read.php">一覧画面</a>
        <a href="eatchat_add_info.php">基本情報</a>
        <a href="eatchat_logout.php">ログアウト</a>
        <div class="container">
            <div class="kiso">現在の基礎代謝(BMR)は<div class="bmr-result"><?= htmlspecialchars($bmr) ?> </div>カロリーです。
            </div>

            <div class="box">
                <input type="text" placeholder="苦手な食べ物を入力してください。" id="text">
            </div>
            <div class="button-container">
                <button type="button" class="btn1" onclick="generateResponse();">レシピを生成</button>
                <button type="button" class="btn2" onclick="stopGenerate();">停止</button>
            </div>
            <div class="textBox">
                <textarea id="output" disabled></textarea>
            </div>
        </div>
        </div>
        <!-- 画像アップロードフォーム
        <form action="gazou.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*">
            <button type="submit">画像をアップロード</button>
        </form> -->

    </fieldset>
    <!-- <script>
        function generateResponse() {
            const text = $('#text').val();
            $.ajax({
                type: 'POST',
                url: 'easychat.php',
                data: {
                    prompt: text
                },
                success: function(response) {
                    $('#output').val(response);
                }
            });
        } -->
    <!-- </script> -->
    <script src="js/script.js"></script>
</body>

</html>