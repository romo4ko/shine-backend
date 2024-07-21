<?php

namespace Modules\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
        ]);

        return Document::where('slug', $request->slug)->get();
    }
}
