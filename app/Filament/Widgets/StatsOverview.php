<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Modules\Support\Support;
use Modules\Users\Models\User;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Новых пользователей за этот месяц',
                User::where('created_at', '>=', Carbon::now()->startOfMonth())->count())
                ->chart(self::getCountUsersRegisteredForLastMonth())
                ->color('success'),
            // TODO: Входы в приложение за этот месяц
            // TODO: Куплено премиум-аккаунтов
            Stat::make('Анкет на модерации', User::where('status', User::MODERATION)->count()),
            Stat::make('Новых обращений в поддержку', Support::where('status', Support::NEW)->count()),
        ];
    }

    private function getCountUsersRegisteredForLastMonth(): array
    {
        $results = [];
        $startTime = Carbon::now()->startOfMonth();
        $daysLeft = $startTime->diffInDays(Carbon::now());

        for ($i = 0; $i < $daysLeft; $i++) {
            $endTime = $startTime->copy()->addDay();
            $count = DB::table('users')
                ->whereBetween('created_at', [
                    $startTime,
                    $endTime,
                ])
                ->count();
            $results[] = $count;
            $startTime = $endTime;
        }

        return $results;
    }
}
