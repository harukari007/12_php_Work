<?php
header('Content-Type: application/json');

// APIキーとエンドポイントの設定
$apikey = "";  // ここにあなたのAPIキーを入力してください
$url = "https://api.openai.com/v1/chat/completions";

// リクエストヘッダー
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apikey
);

// POSTリクエストからデータを取得
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['query']) || empty($input['query'])) {
    echo json_encode(['error' => '質問文が入力されていません'], JSON_UNESCAPED_UNICODE);
    exit;
}

$query = $input['query'];

// リクエストボディ
$data = array(
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ["role" => "system", "content" => "関西弁で話して"],
        ["role" => "user", "content" => "本日はとても暑い日でした。あなたの国ではいかがでしたか？"],
    ],
    'max_tokens' => 500,
);

// cURLを使用してAPIにリクエストを送信
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'リクエストエラー: ' . curl_error($ch)], JSON_UNESCAPED_UNICODE);
    curl_close($ch);
    exit;
}

curl_close($ch);

// 結果をデコード
$result = json_decode($response, true);

if (isset($result["choices"]) && isset($result["choices"][0]["message"]["content"])) {
    $result_message = $result["choices"][0]["message"]["content"];
    echo json_encode(['result_message' => $result_message], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'APIからのレスポンスが無効です', 'response' => $result], JSON_UNESCAPED_UNICODE);
}
