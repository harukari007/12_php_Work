<?php
session_start();
include('functions.php');
check_session_id();

$conn = connect_to_db(); // データベース接続

// ユーザー名に基づいてユーザー情報を取得
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id, username, password FROM users_table WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $user['id'];

// 基本情報を取得
$stmt = $conn->prepare("SELECT email, height, weight, gender, age FROM user_info WHERE user_id = ?");
$stmt->execute([$user_id]);
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);

// BMRを取得
$stmt = $conn->prepare("SELECT bmr FROM bmr_db WHERE user_id = ?");
$stmt->execute([$user_id]);
$bmr = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>基本情報確認画面</title>
    <link rel="stylesheet" href="css/info_register.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .password-field {
            display: flex;
            align-items: center;
        }

        .password-field input[type="password"] {
            margin-right: 10px;
        }

        .password-field .toggle-password {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <fieldset>
        <a href="eatchat_read.php">一覧画面</a>
        <a href="chat_index.php">食事情報入力画面</a>
        <a href="eatchat_logout.php">ログアウト</a>

        <legend>基本情報確認画面【ユーザー名： <?= htmlspecialchars($user['username']) ?>】 </legend>
        <p>ID: <?= htmlspecialchars($user['id']) ?></p>
        <p>ユーザー名: <?= htmlspecialchars($user['username']) ?></p>
        <div class="password-field">
            <input type="password" id="password" value="<?= htmlspecialchars($user['password']) ?>" readonly>
            <span class="toggle-password">👁️</span>
        </div>
        <p>メールアドレス: <?= htmlspecialchars($user_info['email']) ?></p>
        <p>身長: <?= htmlspecialchars($user_info['height']) ?> cm</p>
        <p>体重: <?= htmlspecialchars($user_info['weight']) ?> kg</p>
        <p>性別: <?= htmlspecialchars($user_info['gender']) ?></p>
        <p>基礎代謝 (BMR): <?= htmlspecialchars($bmr) ?> カロリー</p>
    </fieldset>

    <script>
        $(document).ready(function() {
            $('.toggle-password').on('mousedown', function() {
                $('#password').attr('type', 'text');
            });
            $('.toggle-password').on('mouseup mouseleave', function() {
                $('#password').attr('type', 'password');
            });
        });
    </script>
</body>

</html>