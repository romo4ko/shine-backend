<?php

return [

    // Pagination
    'pagination' => [
        'count' => 5,
    ],

    // Users
    'users' => [
        'pagination' => [
            'page' => 1,
            'active' => null,
        ],
        'filter' => [
            'gender' => null,
            'age' => [
                'from' => 18,
                'to' => 40,
            ],
            'destiny' => [
                'from' => 1,
                'to' => 100,
            ],
        ],
    ],

];
