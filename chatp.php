<?php

$client = OpenAI::client(sk - proj - I26wqT7e1fO4eDiVECKLT3BlbkFJA10ZTCo1K364RuFQIk09);
$result = $client->chat()->create([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello!'],
    ]
]);

var_dump($result);
