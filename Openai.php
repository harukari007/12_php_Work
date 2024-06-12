<?
$apikey = "sk-proj-I26wqT7e1fO4eDiVECKLT3BlbkFJA10ZTCo1K364RuFQIk09";
$url = "https://api.openai.com/v1/chat/completions";

// リクエストヘッダー
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apikey
);

// リクエストボディ
$data = array(
    'model' => 'gpt-3.5-turbo',
    'messages' => array(
        array("role" => "system", "content" => "関西弁に翻訳してください"),
        array('role' => 'user', 'content' => "")
    ),
    'max_tokens' => 500,
);

//空白文字削除＆文字が無ければ処理終了
if (str_replace(" ", "", str_replace("　", "", $prompt)) == "") {
    return "";
}

// cURLを使用してAPIにリクエストを送信 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

// 結果をデコード
$result = json_decode($response, true);
$result_message = $result["choices"][0]["message"]["content"];

// 結果を出力 
echo $result_message;
