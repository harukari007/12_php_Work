<?php

// データ受け取り
session_start();
include('functions.php');

// DB接続
$username = $_POST['username'];
$password = $_POST['password'];


// SQL実行
$pdo = connect_to_db();


// ユーザ有無で条件分岐
// username，password，deleted_atの3項目全ての条件満たすデータを抽出する．
$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ユーザーの有無で条件分岐
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=eatchat_login.php>ログイン</a>";
    exit();
} else {
    $_SESSION = array();
    // 一度空にする。
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $user['is_admin'];
    // 管理者かどうかを確認する
    $_SESSION['username'] = $user['username'];
    // ユーザー名
    header("Location:chat_index.php");
    exit();
}

