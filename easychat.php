<?php

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

$open_ai = new OpenAi('sk-proj-xlFeblZIHZqpp24OtWsbT3BlbkFJ7o7HVMN3W26yskDP0wxk');

$complete = $open_ai->completion([
    'model' => 'gpt-3.5-turbo-instruct',
    'prompt' => 'Hello',
    'temperature' => 0.9,
    'max_tokens' => 150,
    'frequency_penalty' => 0,
    'presence_penalty' => 0.6,
]);

if ($complete != null) {
    $php_obj = json_decode($complete);
    $response = $php_obj->choices[0]->text;
    echo $response;
}
