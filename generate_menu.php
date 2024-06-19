<?php
session_start();
include('functions.php');
check_session_id();

// BMRの取得
$conn = connect_to_db();
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM users_table WHERE username = ?");
$stmt->execute([$username]);
$user_id = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT bmr FROM BMR_DB WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$user_id]);
$bmr = $stmt->fetchColumn();

// 好きな食べ物の取得
$prompt = $_POST['prompt'];

// 好きな食べ物を考慮して献立を生成（サンプルの献立を作成）
$menu = <<<EOM
あなたは管理栄養士でベテランの専門家です。{$prompt}で入力された、好きな食べ物を考慮して、calculate_bmr.phpで計算した基礎代謝のカロリーに合う食事の献立を、朝、昼、夜、それぞれ、食事名、ジャンル、食材、調理時間、調理コスト、を創造して箇条書きにしてください。

＜献立＞:
朝食:
食事名: 和風オムレツ
ジャンル: 和食
食材: 卵, ほうれん草, 醤油, みりん, だし
調理時間：10分
調理コスト：300円

昼食:
食事名: 鶏肉の照り焼き
ジャンル: 和食
食材: 鶏もも肉, 醤油, みりん, 砂糖, しょうが
調理時間：20分
調理コスト：500円

夕食:
食事名: 鮭のホイル焼き
ジャンル: 和食
食材: 鮭, 野菜（キャベツ, にんじん, 玉ねぎ）, 醤油, バター
調理時間：25分
調理コスト：600円

:::
EOM;

echo $menu;
