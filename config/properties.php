<?php

return  [

    // Пол
    'gender' => [
        [
            'code' 	=> 'female',
            'value'	=> 'Женский'
        ],
        [
            'code' 	=> 'male',
            'value'	=> 'Мужской'
        ]
    ],

    // Семейное положение
    'fs' => [
        [
            'code' 	=> 'married',
            'value'	=> 'Женат/замужем'
        ],
        [
            'code' 	=> 'single',
            'value'	=> 'Свободен/свободна'
        ],
        [
            'code' 	=> 'open-rel',
            'value'	=> 'В свободных отношениях'
        ]
    ],

    // Есть ли дети
    'children' => [
        [
            'code' 	=> 'yes',
            'value'	=> 'Да'
        ],
        [
            'code' 	=> 'no',
            'value'	=> 'Нет и не планирую'
        ],
        [
            'code' 	=> 'would',
            'value'	=> 'Нет, но хотелось бы'
        ]
    ],

    // Отношение к алкоголю
    'alcohol' => [
        [
            'code' 	=> 'alcohol_negative',
            'value'	=> 'Резко негативно'
        ],
        [
            'code' 	=> 'alcohol_neutral',
            'value'	=> 'Нет, но хотелось бы'
        ],
        [
            'code' 	=> 'alcohol_positive',
            'value'	=> 'Положительно'
        ]
    ],
    
    // Отношение к курению
    'smoking' => [
        [
            'code' 	=> 'smoking_negative',
            'value'	=> 'Резко негативно'
        ],
        [
            'code' 	=> 'smoking_neutral',
            'value'	=> 'Нет, но хотелось бы'
        ],
        [
            'code' 	=> 'smoking_positive',
            'value'	=> 'Положительно'
        ]
    ],

    // Цель знакомства
    'purpose' => [
        [
            'code' 	=> 'dates',
            'value'	=> 'Свидания'
        ],
        [
            'code' 	=> 'flirting',
            'value'	=> 'Флирт'
        ],
        [
            'code' 	=> 'relationship',
            'value'	=> 'Отношения'
        ],
        [
            'code' 	=> 'friendship',
            'value'	=> 'Дружба'
        ],
        [
            'code' 	=> 'virtual',
            'value'	=> 'Виртуальное общение'
        ]
    ],
    
    // Образование
    'education' => [
        [
            'code' 	=> 'without',
            'value'	=> 'Нет'
        ],
        [
            'code' 	=> 'secondary',
            'value'	=> 'Среднее'
        ],
        [
            'code' 	=> 'higher',
            'value'	=> 'Высшее'
        ],
        [
            'code' 	=> 'phd',
            'value'	=> 'Кандидат наук'
        ]
    ],
    
    // Знаки зодиака
    'zodiac' => [
        [
            'code' 	=> 'aries',
            'value'	=> 'Овен',
            'dates' => ['21.03', '20.04']
        ],
        [
            'code' 	=> 'taurus',
            'value'	=> 'Телец',
            'dates' => ['21.04', '21.05']
        ],
        [
            'code' 	=> 'gemini',
            'value'	=> 'Близнецы',
            'dates' => ['22.05', '21.06']
        ],
        [
            'code' 	=> 'cancer',
            'value'	=> 'Рак',
            'dates' => ['22.06', '22.07']
        ],
        [
            'code' 	=> 'leo',
            'value'	=> 'Лев',
            'dates' => ['23.07', '21.08']
        ],
        [
            'code' 	=> 'virgo',
            'value'	=> 'Дева',
            'dates' => ['22.08', '23.09']
        ],
        [
            'code' 	=> 'libra',
            'value'	=> 'Весы',
            'dates' => ['24.09', '23.10']
        ],
        [
            'code' 	=> 'scorpio',
            'value'	=> 'Скорпион',
            'dates' => ['24.10', '22.11']
        ],
        [
            'code' 	=> 'sagittarius',
            'value'	=> 'Стрелец',
            'dates' => ['23.11', '22.12']
        ],
        [
            'code' 	=> 'capricorn',
            'value'	=> 'Козерог',
            'dates' => ['23.12', '20.01']
        ],
        [
            'code' 	=> 'aquarius',
            'value'	=> 'Водолей',
            'dates' => ['21.01', '19.02']
        ],
        [
            'code' 	=> 'pisces',
            'value'	=> 'Рыбы',
            'dates' => ['20.02', '20.03']
        ]
    ],

    // Статусы пользователя
    'user_statuses' => [
        [
            'code' 	=> 'admin',
            'value'	=> 'Администратор'
        ],
        [
            'code' 	=> 'confirmation',
            'value'	=> 'Подтверждение почты'
        ],
        [
            'code' 	=> 'moderation',
            'value'	=> 'На модерации'
        ],
        [
            'code' 	=> 'rejected',
            'value'	=> 'Отклонён модерацией'
        ],
        [
            'code' 	=> 'blocked',
            'value'	=> 'Заблокирован'
        ],
        [
            'code' 	=> 'published',
            'value'	=> 'Опубликован'
        ]  
    ],
    
    // Типы предсказаний
    'prediction_types' => [
        [
            'code' 	=> 'funny',
            'value'	=> 'Грубые и смешные'
        ],
        [
            'code' 	=> 'needful',
            'value'	=> 'Нежные и нужные'
        ],
        [
            'code' 	=> 'mixed',
            'value'	=> 'Смешанные'
        ]
    ]
];
