<?php

declare(strict_types=1);

namespace Modules\Cities\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cities\Models\City;

class CitiesController extends Controller
{
    public function getCity(Request $request)
    {
        $request->validate([
            'text' => 'nullable|string',
        ]);

        $text = $request->input('text');

        if ($text) {
            return City::whereRaw(
                'LOWER(`name`) LIKE ? ',
                ['%'.trim(strtolower($request->text)).'%']
            )
                ->limit(10)
                ->get();
        }

        return [];
    }
}
