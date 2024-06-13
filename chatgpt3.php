<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function send_prompt($prompt = '')
{
    $API_KEY = 'sk-proj-tl2p07nvRfkmwTNV7ij9T3BlbkFJ13l70uSkUeacNWgdAs4k'; //ここにキーを入れてね。

    if (!$prompt) {
        return;
    }

    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $API_KEY
    );

    $data = array(
        'model' => 'text-davinci-003',
        'prompt' => $prompt,
        "max_tokens" => 500,
        "temperature" => 1,
        "top_p" => 1,
        "frequency_penalty" => 0.0,
        "presence_penalty" => 0.6,
        "stop" => array(".", "!", "?") // 終了文字を調整します
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if (isset($response_data['choices'][0]['text'])) {
        return trim($response_data['choices'][0]['text']);
    } else {
        return 'No response from API';
    }
}

$prompt = 'ドラエモンの身長は何センチですか？'; //ここに質問を書いてね
$chat_text = send_prompt($prompt);
echo '
         <script>
        document.addEventListener("DOMContentLoaded", function () {
            const text = \'こんにちは、私はChatGPTです。' . $chat_text . '\';//ここは回答です、アレンジしてね
            const outputElement = document.getElementById(\'output\');
            const typingDelay = 100; // ミリ秒単位でのタイピングの遅延

            function typeText(index) {
                if (index < text.length) {
                    outputElement.innerHTML += text.charAt(index);
                    setTimeout(() => typeText(index + 1), typingDelay);
                }
            }

            typeText(0);
        });
    </script>

    <div id="output"></div>
    ';
