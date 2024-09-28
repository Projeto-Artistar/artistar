<?php

$result = [
    'code' => 200,
    'data' => [
        'eventos' => $eventos
    ]
];

echo json_encode($result);

