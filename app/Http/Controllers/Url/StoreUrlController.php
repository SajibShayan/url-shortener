<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\StoreUrlRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreUrlController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUrlRequest $request)
    {
        $payload = $request->validated();
        $uniqueIdentifier = generate_unique_url().substr(md5(uniqid()), 0, 6); //there is no chance to conflict
        $payload['short_code'] = $uniqueIdentifier;

        Auth::user()->urls()->create($payload);

        return redirect()->back();
    }
}
