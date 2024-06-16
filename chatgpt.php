<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Orhanerday\OpenAi\OpenAi;

$open_ai_key = '';

// ライブラリのインスタンスを生成
$open_ai = new OpenAi($open_ai_key);

$seach_text = filter_input(INPUT_POST, 'seach_text', FILTER_DEFAULT);
$content = "のびえもーんは22世紀の未来から来たネコ型ロボットです。生年月日は2112年9月3日です。<br>
            ドラ太君は小学4年生の少年です。勉強も運動も苦手でド◯えもんの秘密道具に頼りっぱなしです。<br>
            ジャイカちゃんはのび太が思いを寄せるクラスメイトの少女です。成績は良く、真面目で優しい性格。よくお風呂に入っている。焼き芋が一番の好物であるがイメージダウンを気にして、あまり口にしない。<br>
            しず夫はのび○のクラスメイトの友達。身長が低いのをコンプレックスにしている。家が非常に裕福でよく自慢話をする。<br>
            スネアンはのび○のクラスメイトの友達。近所の「ガキ大将」。自己中心的で乱暴だが、非常に妹想いである。また、友情や愛情といった他人を思いやる行為に弱い一方、涙もろい一面も持つ";

if ($seach_text) {
    // ChatGPTを呼び出し
    $response = $open_ai->chat([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                "role" => "assistant",
                "content" => $content
            ],
            [
                "role" => "user",
                "content" => $seach_text
            ],
        ],
    ]);
    $response_list = json_decode($response);
    $answer = $response_list->choices[0]->message->content;
}

?>
<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>GPTアプリ</title>
</head>

<body>
    <form action="" method="post">
        <div>
            <input name="seach_text" type="text" placeholder="何が知りたいですか？" size="150">
            <button>検索</button>
        </div>
    </form>
    <div>
        <p>【検索結果】</p>
        <p>↓ここに検索結果が表示されます。</p>
        <p><?php echo ($answer); ?></p>
    </div>

    <div>
        <p>【登場人物】</p>
        <p><?php echo ($content); ?></p>
    </div>
</body>

</html>