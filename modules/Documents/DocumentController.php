<?php

namespace Modules\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->route()->getPrefix() === 'api') {
            $request->validate([
                'slug' => 'required|string',
            ]);

            return Document::where('slug', $request->slug)->first();
        } else {
            return view('document', [
                'document' => Document::where('slug', $request->slug)->first(),
            ]);
        }
    }
}
