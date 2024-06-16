<?php
session_start();
include("functions.php");
check_session_id();

if (
  !isset($_POST['email']) || $_POST['email'] === '' ||
  !isset($_POST['height']) || $_POST['height'] === '' ||
  !isset($_POST['weight']) || $_POST['weight'] === '' ||
  !isset($_POST['gender']) || $_POST['gender'] === '' ||
  !isset($_POST['age']) || $_POST['age'] === ''
) {
  exit('paramError');
}

$email = $_POST['email'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$gender = $_POST['gender'];
$age = $_POST['age'];

$pdo = connect_to_db();

$sql = 'INSERT INTO user_info(id, email, height, weight, gender, age, created_at, updated_at) VALUES(NULL, :email, :height, :weight, :gender, :age, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':height', $height, PDO::PARAM_INT);
$stmt->bindValue(':weight', $weight, PDO::PARAM_INT);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:eatchat_add_info.php");
exit();
