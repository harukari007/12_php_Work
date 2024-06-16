<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();

// 今月の最初の日と最後の日を取得
$first_day_of_month = date('Y-m-01');
$last_day_of_month = date('Y-m-t');

// フォームからのリクエストを取得
$filter = $_GET['filter'] ?? 'all';
$sort = $_GET['sort'] ?? 'deadline'; // デフォルトのソート順はdeadline

// SQLクエリを条件に応じて変更
if ($filter === 'month') {
  $sql = "SELECT * FROM eat_table WHERE deadline BETWEEN :first_day AND :last_day ORDER BY {$sort} ASC";
} else {
  $sql = "SELECT * FROM eat_table ORDER BY {$sort} ASC";
}

$stmt = $pdo->prepare($sql);

try {
  if ($filter === 'month') {
    $stmt->bindValue(':first_day', $first_day_of_month, PDO::PARAM_STR);
    $stmt->bindValue(':last_day', $last_day_of_month, PDO::PARAM_STR);
  }
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  // 登録日時から年月日部分のみを取得
  $created_at_date = date('Y-m-d', strtotime($record["created_at"]));
  $output .= "
        <tr>
            <td>{$created_at_date}</td>
            <td>{$record["deadline"]}</td>
            <td>{$record["todo"]}</td>
            <td><a href='eatchat_edit.php?id={$record["id"]}'>編集</a></td>
            <td><a href='eatchat_delete.php?id={$record["id"]}'>削除</a></td>
        </tr>
    ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>食事リスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>食事リスト（一覧画面）<?= $_SESSION['username'] ?></legend>
    <a href="chat_index.php">入力画面</a>
    <a href="eatchat_logout.php">logout</a>
    <!-- フィルタボタンを追加 -->
    <form action="" method="GET">
      <button type="submit" name="filter" value="month">今月</button>
      <button type="submit" name="filter" value="all">全日程</button>
      <!-- ソートボタンを追加 -->
      <button type="submit" name="sort" value="created_at">登録日時でソート</button>
      <!-- <button type="submit" name="sort" value="deadline">締切日時でソート</button> -->
    </form>
    <table>
      <thead>
        <tr>
          <th>登録日時</th>
          <th>食事写真</th>
          <th>カロリー</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>