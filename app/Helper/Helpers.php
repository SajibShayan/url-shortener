<?php

use App\Models\Url;
use Carbon\Carbon;

if (! function_exists('generate_unique_url')) {
    function generate_unique_url($length = 20)
    {
        $serialNo = Url::query()
            ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
            ->count() + 1;

        $short_url = 'url'.Carbon::now()->format('ymd').($serialNo < 10 ? '0'.$serialNo : $serialNo);

        $isExist = Url::where('short_code', $short_url)->exists();

        if ($isExist) {
            return generate_unique_url($serialNo + 1);
        }

        return substr($short_url, 0, $length);
    }
}
