<?php

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

if (isset($_GET["prompt"])) {

    $promt = $_GET["prompt"];
    $open_ai = new OpenAi('');  //YOUR_OPEN_AI_KEY_HERE

    $complete = $open_ai->completion([
        'model' => 'gpt-3.5-turbo-instruct',
        'prompt' =>"あなたは管理栄養士でプロアスリート専門の管理栄養士です。{$prompt}で入力された嫌いな食べ物を排除して、
        で計算結果に表示された基礎代謝のカロリーに合致する食事の献立を、朝、昼、夜、それぞれ、メニュー名、各メニューのカロリー、食材、調理時間、調理コスト、を創造して箇条書きにしてください。
        \n＜献立＞:
        \n朝食: 
        \n昼食: 
        \n夕食: 
        \n総調理コスト:
        \n総カロリー合計 ",
        'temperature' => 0.9,
        'max_tokens' => 400,
        'frequency_penalty' => 0,
        'presence_penalty' => 0.6,
    ]);

    // 変数に格納されたJSON形式のレスポンスをPHPのオブジェクトにデコード
    // choices、APIからのレスポンス内にある複数の選択肢（回答）を格納する配列
    if ($complete != null) {
        $php_obj = json_decode($complete);
        $response = $php_obj->choices[0]->text;
        echo $response;
    }
}
