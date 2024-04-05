<?php

namespace Database\Seeders;

use App\Models\Properties;
use App\Models\PropertyValues;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createBaseProperties();
    }

    public function createBaseProperties(): void
    {

        $properties = [

            // Пол
            [
                'code' 	=> 'female',
                'value'	=> 'Женский'
            ],
            [
                'code' 	=> 'male',
                'value'	=> 'Мужской'
            ],

            // Семейное положение
            [
                'code' 	=> 'fs-1',
                'value'	=> 'Женат/замужем'
            ],
            [
                'code' 	=> 'fs-2',
                'value'	=> 'Свободен/свободна'
            ],
            [
                'code' 	=> 'fs-2',
                'value'	=> 'В свободных отношениях'
            ],

            // Есть ли дети
            [
                'code' 	=> 'children-1',
                'value'	=> 'Да'
            ],
            [
                'code' 	=> 'children-2',
                'value'	=> 'Нет и не планирую'
            ],
            [
                'code' 	=> 'children-3',
                'value'	=> 'Нет, но хотелось бы'
            ],

            // Отношение к алкоголю/курению
            [
                'code' 	=> 'relation-1',
                'value'	=> 'Резко негативно'
            ],
            [
                'code' 	=> 'Нейтрально',
                'value'	=> 'Нет, но хотелось бы'
            ],
            [
                'code' 	=> 'relation-3',
                'value'	=> 'Положительно'
            ],

            // Цель знакомства
            [
                'code' 	=> 'purpose-1',
                'value'	=> 'Свидания'
            ],
            [
                'code' 	=> 'purpose-2',
                'value'	=> 'Флирт'
            ],
            [
                'code' 	=> 'purpose-3',
                'value'	=> 'Отношения'
            ],
            [
                'code' 	=> 'purpose-4',
                'value'	=> 'Дружба'
            ],
            [
                'code' 	=> 'purpose-5',
                'value'	=> 'Виртуальное общение'
            ],

            // Образование
            [
                'code' 	=> 'education-0',
                'value'	=> 'Нет'
            ],
            [
                'code' 	=> 'education-m',
                'value'	=> 'Среднее'
            ],
            [
                'code' 	=> 'education-h',
                'value'	=> 'Высшее'
            ],
            [
                'code' 	=> 'education-1',
                'value'	=> 'Кандидат наук'
            ],

            // Знаки зодиака
            [
                'code' 	=> 'aries',
                'value'	=> 'Овен'
            ],
            [
                'code' 	=> 'taurus',
                'value'	=> 'Телец'
            ],
            [
                'code' 	=> 'gemini',
                'value'	=> 'Близнецы'
            ],
            [
                'code' 	=> 'cancer',
                'value'	=> 'Рак'
            ],
            [
                'code' 	=> 'leo',
                'value'	=> 'Лев'
            ],
            [
                'code' 	=> 'virgo',
                'value'	=> 'Дева'
            ],
            [
                'code' 	=> 'libra',
                'value'	=> 'Весы'
            ],
            [
                'code' 	=> 'scorpio',
                'value'	=> 'Скорпион'
            ],
            [
                'code' 	=> 'sagittarius',
                'value'	=> 'Стрелец'
            ],
            [
                'code' 	=> 'capricorn',
                'value'	=> 'Козерог'
            ],
            [
                'code' 	=> 'aquarius',
                'value'	=> 'Водолей'
            ],
            [
                'code' 	=> 'pisces',
                'value'	=> 'Рыбы'
            ],

            // Статусы пользователя
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
            ],

            // Типы предсказаний
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
            ],
        ];

        DB::transaction(function () use ($properties) {
            foreach ($properties as $property) {
                $list = Properties::updateOrCreate(
                    [
                        'code' => $property['code'],
                    ],
                    [
                        'value' => $property['value'],
                    ]
                );
            }
        });
    }
}
