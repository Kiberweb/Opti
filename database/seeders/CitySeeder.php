<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    private array $_cities = [
        'Київ',
        'Львів',
        'Дніпро',
        'Одесса',
        'Миколаїв',
        'Запоріжжя',
        'Кривий ріг',
        'Рівне',
        'Івано-Франківськ',
        'Чернівці',
        'Житомир',
        'Кам\'янське',
        'Хмельницький',
        'Полтава',
        'Луцьк',
        'Біла церква',
        'Суми',
        'Віниця',
        'Дубно',
        'Тернопіль',
        'Яремич',
        'Кроповницький',
        'Маріуполь',
        'Ужгород',
        'Херсон',
        'Черкаси',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->_cities as $city) {
            City::create(['city' => $city]);
        }
    }
}
