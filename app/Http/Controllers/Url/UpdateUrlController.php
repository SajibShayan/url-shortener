<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\StoreUrlRequest;
use App\Models\Url;

class UpdateUrlController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUrlRequest $request, Url $url)
    {
        $payload = $request->validated();

        $url->update([
            'long_url' => $payload['long_url'],
        ]);

        return redirect()->back();
    }
}
