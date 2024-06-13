<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // 初期化
    $TEXT = "";

    // 未入力チェック
    if (empty($_POST["query"])) {
        exit(json_encode(["error" => "未入力"]));
    }

    // 文字数チェック
    if (mb_strlen($_POST["query"], 'UTF-8') > 200) {
        exit(json_encode(["error" => "200文字オーバー"]));
    }

    // プロンプト取得
    $prompt = $_POST["query"];

    // 空白文字削除＆文字が無ければ処理終了
    if (str_replace(" ", "", str_replace("　", "", $prompt)) == "") {
        exit(json_encode(["error" => "無効な入力"]));
    }

    try {
        // 環境変数
        $API_KEY = getenv("MAINSITE_KEY");

        // ヘッダー設定
        $header = array(
            'api-key: ' . $API_KEY,
            'Content-Type: application/json',
        );

        switch ($_POST["swflg"]) {
            case "1":
                $TEXT = <<<EOM
あなたは小説の専門家。{$prompt}のタイトルに合う小説のタイトル、ジャンル、対象年齢層、ストーリー、登場人物、設定、結末を創造して箇条書きにしてください。

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
                exit(json_encode(["error" => "無効なフラグ"]));
        }

        $params = json_encode([
            'prompt' => $TEXT,
            'temperature' => 0.5,
            'max_tokens' => 1000,
            'top_p' => 0.5,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0,
            'stop' => [":::"]
        ]);

        $curl = curl_init('https://demokeyapi.openai.azure.com/openai/deployments/agile/completions?api-version=2022-12-01');
        $options = array(
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curl, $options);
        $json_array = curl_exec($curl);
        if (curl_errno($curl)) {
            exit(json_encode(["error" => "リクエストエラー: " . curl_error($curl)]));
        }
        curl_close($curl);

        echo json_encode(json_decode($json_array), JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        echo json_encode(["error" => "エラー: " . $e->getMessage()]);
    }
}

