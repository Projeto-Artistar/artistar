<?php

$result = [
    'code' => 200,
    'data' => [
        'basicInfo' => $basicInfo,
        'days'      => $days,
        'prices'    => $prices,
        'photos'    => $photos
    ]
];

echo json_encode($result);

