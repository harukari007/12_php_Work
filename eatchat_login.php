<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css ">
  <title>カロリートラッカー ログイン画面</title>
</head>

<body>

  <form action="eatchat_login_act.php" method="POST">
    <fieldset>
      <legend>カロリートラッカー <br>ログイン画面</legend>
      <div>
        ユーザー名: <input type="text" name="username">
      </div>
      <div>
        パスワード: <input type="text" name="password">
      </div>
      </div>
      <div>
        <button>ログイン</button>
      </div>
      <a href="eatchat_register.php">新規ユーザ登録する</a>
    </fieldset>
  </form>

</body>

</html>