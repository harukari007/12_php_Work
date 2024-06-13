<?php

$client = OpenAI::client(sk);
$result = $client->chat()->create([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello!'],
    ]
]);

var_dump($result);
