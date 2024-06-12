<?php
// Ajax からのリクエストをチェック
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // 未入力チェック
    if (empty($_POST["query"])) {
        exit("未入力");
    }

    // 文字数チェック
    if (mb_strlen($_POST["query"], 'UTF-8') > 200) {
        exit("200文字オーバー");
    }

    // プロンプト取得
    $prompt = $_POST["query"];
    $TEXT = "";

    try {
        // APIキーの設定
        $apikey = "sk-proj-I26wqT7e1fO4eDiVECKLT3BlbkFJA10ZTCo1K364RuFQIk09";
        $url = "https://api.openai.com/v1/chat/completions";

        // リクエストヘッダー
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apikey
        );

        // プロンプトに基づくリクエストボディの設定
        switch ($_POST["swflg"]) {
            case "1":
                $TEXT = <<<EOM
あなたは小説家です。{$prompt}のタイトルに合う小説のタイトル、ジャンル、対象年齢層、ストーリー、登場人物、設定、結末を創造して箇条書きにしてください。

＜小説＞:
"""
タイトル:

ジャンル:

対象年齢層:

ストーリー：

登場人物:

設定:

結末：

"""

:::
EOM;
                break;
            default:
                exit(false);
        }

        // リクエストボディ
        $data = array(
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ["role" => "system", "content" => "$prompt"],
                ['role' => 'user', 'content' => $TEXT]
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
        curl_close($ch);

        // 結果をデコード
        $result = json_decode($response, true);
        $result_message = $result["choices"][0]["message"]["content"];

        // 結果を出力
        echo json_encode(['response' => $result_message], JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error:" . $e->getMessage()], JSON_PRETTY_PRINT);
    }
}
