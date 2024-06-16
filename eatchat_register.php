<?php
session_start();
include('functions.php');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/register.css">
  <title>カロリートラッカー ユーザ登録画面</title>
</head>

<body>
  <form action="eatchat_register_act.php" method="POST">
    <fieldset>
      <legend>カロリートラッカー ユーザ登録画面</legend>
      <div>
        ユーザネーム: <input type="text" name="username">
      </div>
      <div>
        パスワード: <input type="text" name="password">
      </div>
      <div>
        <button>登録</button>
      </div>
      <a href="eatchat_login.php">ログイン</a>
    </fieldset>
  </form>

</body>

</html>