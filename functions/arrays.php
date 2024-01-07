<?php

$hotelRooms = [
    'budget' => [
        'roomID' => 1,
        'cost' => 5
    ],
    'standard' => [
        'roomID' => 2,
        'cost' => 10
    ],
    'luxury' => [
        'roomID' => 3,
        'cost' => 15
    ],
];


//placeholder response-array to be converted to json on booking completion
$response = [
    "island" => "Nonsensical Island",
    "hotel" => "The Two Sticks in a Pond",
    "arrival_date" => "2024-01-00",
    "departure_date" => "2024-01-00",
    "total_cost" => 0,
    "stars" => 2,
    "features" => [
        [
            "name" => "sauna",
            "cost" => 2
        ]
    ],
    "additional_info" => [
        "greeting" => "Enjoy your stay at The Two Sticks in a Pond",
    ]
];
