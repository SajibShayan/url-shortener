<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class redirectToOriginalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Url $url)
    {
        //we can use here events instead of this process
        //any of the user when hit this url the count will be incremented
        $url->clicks_count++;
        $url->save();

        return redirect($url->long_url);
    }
}
