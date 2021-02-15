<?php

namespace App\Console\Commands;

use App\Models\Registration;
use Geocoder\Geocoder;
use Illuminate\Console\Command;

class PolkAddress extends Command
{

    protected $signature = 'polk:address';

    protected $description = 'Add geocoding (latitude and longitude) to each address model';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

		$list = Registration::take(10)->get();

		foreach ($list as $item) {

			$searchString = $item->address1 . ', ' . $item->city . ', ' . $item->state . ', ' . $item->zip;
			$returnData = app('geocoder')->geocode($searchString)->get();

			echo $returnData->first()->getStreetNumber() . "\r\n";
			echo $returnData->first()->getStreetName() . "\r\n";
			echo $returnData->first()->getLocality() . "\r\n";
			echo $returnData->first()->getAdminLevels()->get(1)->getCode() . "\r\n";
			echo $returnData->first()->getPostalCode() . "\r\n";
			echo $returnData->first()->getAdminLevels()->get(2)->getCode() . "\r\n";
			echo $returnData->first()->getCoordinates()->getLatitude() . "\r\n";
			echo $returnData->first()->getCoordinates()->getLongitude() . "\r\n\n";

		}

        return 0;
    }
}
