<?php

declare(strict_types=1);

namespace Modules\Users;

use Carbon\Carbon;
use Modules\Properties\Models\Property;

class Zodiac
{
    public function getSignByDate(Carbon $date): ?Property
    {
        foreach (config('properties.zodiac') as $zodiac) {
            $dateFrom = Carbon::createFromFormat('d.m', $zodiac['dates'][0]);
            $dateTo = Carbon::createFromFormat('d.m', $zodiac['dates'][1]);

            if (
                $date->month == $dateFrom->month && $date->day >= $dateFrom->day ||
                $date->month == $dateTo->month && $date->day <= $dateTo->day
            ) {
                return Property::where('type', 'zodiac')->where('code', $zodiac['code'])->first();
            }
        }

        return null;
    }
}
