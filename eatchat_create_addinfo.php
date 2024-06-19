<?php
session_start();
include('functions.php');
check_session_id();

$conn = connect_to_db(); // データベース接続

// 初期値の設定
$email = "";
$height = "";
$weight = "";
$gender = "";
$age = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // フォームから送信されたデータを取得
  $username = $_SESSION['username'];
  $email = $_POST['email'];
  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $gender = $_POST['gender'];
  $age = $_POST['age'];

  // ユーザー名に基づいてユーザーIDを取得
  $stmt = $conn->prepare("SELECT id FROM users_table WHERE username = ?");
  $stmt->execute([$username]);
  $user_id = $stmt->fetchColumn();

  // ユーザーの基本情報を user_info テーブルに挿入
  $stmt = $conn->prepare("INSERT INTO user_info (user_id, email, height, weight, gender, age) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$user_id, $email, $height, $weight, $gender, $age]);

  // 挿入処理の実行と結果の表示
  if ($stmt) {
    $message = "基本情報が登録されました";
  } else {
    $message = "Error: " . $stmt->errorInfo()[2];
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>基本情報登録画面</title>
  <link rel="stylesheet" href="css/info_register.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    // ページ読み込み後にアラートを表示する
    $(document).ready(function() {
      <?php if ($message) : ?>
        showModal("<?= $message ?>");
      <?php endif; ?>

      // モーダルを表示する関数
      function showModal(message) {
        const modal = document.createElement("div");
        modal.classList.add("modal");
        const modalContent = document.createElement("div");
        modalContent.classList.add("modal-content");
        const closeButton = document.createElement("span");
        closeButton.classList.add("close");
        closeButton.innerHTML = "&times;";
        closeButton.onclick = function() {
          modal.style.display = "none";
        };
        const messageText = document.createElement("p");
        messageText.innerText = message;
        modalContent.appendChild(closeButton);
        modalContent.appendChild(messageText);
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        modal.style.display = "block";
      }
    });
  </script>
</head>

<fieldset>
  <a href="eatchat_read.php">一覧画面</a>
  <a href="chat_index.php">食事情報入力画面</a>
  <a href="eatchat_logout.php">ログアウト</a>

  <legend>基本情報登録画面<br>【ユーザー名： <?= $_SESSION['username'] ?>】 </legend>
  <form id="infoForm" action="eatchat_create_addinfo.php" method="POST">
    <label for="email">メールアドレス:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>
    <label for="height">身長 (cm):</label>
    <input type="number" id="height" name="height" value="<?= htmlspecialchars($height) ?>" required><br>
    <label for="weight">体重 (kg):</label>
    <input type="number" id="weight" name="weight" value="<?= htmlspecialchars($weight) ?>" required><br>
    <label for="gender">性別:</label>
    <select id="gender" name="gender" required>
      <option value="male" <?= $gender == 'male' ? 'selected' : '' ?>>男性</option>
      <option value="female" <?= $gender == 'female' ? 'selected' : '' ?>>女性</option>
    </select><br>
    <label for="age">年齢:</label>
    <input type="number" id="age" name="age" value="<?= htmlspecialchars($age) ?>" required><br>
    <input type="submit" value="登録する">
  </form>
  <!-- BMR計算ページへのリンクボタン -->
  <form action="calculate_bmr.php" method="POST">
    <input type="submit" value="基礎代謝を確認する">
  </form>
</fieldset>
</body>

</html>