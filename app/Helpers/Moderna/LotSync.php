<?php

/*
*       Class to sync the Moderna Expiry with the lot numbers table
*/

namespace App\Helpers\Moderna;

use Illuminate\Support\Facades\Http;
use App\Models\Lot;
use Carbon\Carbon;

class LotSync
{
    public static function run()
    {
        $batches = self::getExpiry();
        
        if (empty($batches)) {
            self::sendFailureNotifs();
            return false;
        }

        if(self::runUpdates($batches)) {
            return true;
        } else {
            self::sendFailureNotifs();
            return false;
        }
    }

    private static function getExpiry()
    {
        $json_url = config('app.moderna_expiry');
        $response = Http::get($json_url);
        if ($response->ok() || $response->successful()) {
            return $response->json();
        } else {
            return [];
        }
    }

    private static function runUpdates($lots)
    {
        $safe = true;

        foreach ($lots as $lot) {
            if (isset($lot['Batch']) && isset($lot['ExpiryDate'])) {
                try {
                    Lot::updateOrCreate(
                        ['number' => $lot['Batch']],
                        ['expiration_date' => Carbon::parse($lot['ExpiryDate'])]
                    );
                } catch (\Exception $e) {
                    $safe = false;
                }
            }
        }

        return true;
    }

    private static function sendFailureNotifs()
    {
        Mail::to('BenjaminHarvey@polk-county.net')
            ->cc(['DouglasCockerham@polk-county.net'])
            ->send(new \App\Mail\LotSyncFail());
    }
}