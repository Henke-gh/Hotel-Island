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
    "island" => "Main island",
    "hotel" => "Your Hotel Name",
    "arrival_date" => $arrivalDate,
    "departure_date" => $departureDate,
    "total_cost" => $totalCost,
    "stars" => 3,
    "features" => [
        [
            "name" => "sauna",
            "cost" => 2
        ]
    ],
    "additional_info" => [
        "greeting" => "Thank you for choosing Your Hotel Name",
        "imageUrl" => "https://example.com/hotel-image.jpg"
    ]
];
