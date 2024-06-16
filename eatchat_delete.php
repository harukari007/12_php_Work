<?php
// データ受け取り
$id = $_GET['id'];

include('functions.php');
$pdo = connect_to_db();

// 削除
$sql = 'DELETE FROM eat_table WHERE id=:id';

// 論理削除 
// $sql = 'UPDATE recipes SET deleted_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:eatchat_read.php");
exit();



// DB接続


// SQL実行
