<?php

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

if(isset($_GET["prompt"])){

    $promt=$_GET["prompt"];

    $open_ai = new OpenAi('');

    $complete = $open_ai->completion([
        'model' => 'gpt-3.5-turbo-instruct',
        'prompt' => $promt,
        'temperature' => 0.9,
        'max_tokens' => 300,
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



