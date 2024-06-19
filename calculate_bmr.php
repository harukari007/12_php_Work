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

// ユーザーの基本情報を取得
$stmt = $conn->prepare("SELECT height, weight, gender, age FROM user_info WHERE user_id = ?");
$stmt->execute([$user_id]);
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);

// 基礎代謝率（BMR）の計算
if ($user_info) {
    $height = $user_info['height'];
    $weight = $user_info['weight'];
    $gender = $user_info['gender'];
    $age = $user_info['age'];

    if ($gender == 'male') {
        $bmr = 88.36 + (13.4 * $weight) + (4.8 * $height) - (5.7 * $age);
    } else {
        $bmr = 447.6 + (9.2 * $weight) + (3.1 * $height) - (4.3 * $age);
    }

    // BMRをBMR_DBに保存
    $stmt = $conn->prepare("INSERT INTO BMR_DB (user_id, bmr, created_at) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $bmr, date('Y-m-d H:i:s')]);
} else {
    echo "ユーザーの基本情報が見つかりませんでした。";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/info_register.css ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>基礎代謝計算結果</title>
</head>

<body>
    <fieldset>
        <a href="eatchat_read.php">一覧画面</a>
        <a href="chat_index.php">食事情報入力画面</a>
        <a href="eatchat_logout.php">ログアウト</a>
        <legend>基礎代謝確認画面<br>【ユーザー名： <?= $_SESSION['username'] ?>】 </legend>
        <p><?= htmlspecialchars($username) ?>さんの基礎代謝は<br>
        <div class="bmr-result"><?= htmlspecialchars($bmr) ?> </div>カロリーです。
        <div class="ex">（BMR）とは呼吸、発毛、消化、心臓の鼓動のような基本的な生命維持活動で体が消費するカロリー量のことです。</div>
    </fieldset>
</body>

</html>