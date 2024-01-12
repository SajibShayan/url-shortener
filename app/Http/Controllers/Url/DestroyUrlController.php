<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class DestroyUrlController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Url $url)
    {
        $url->delete();

        return redirect()->back();
    }
}
