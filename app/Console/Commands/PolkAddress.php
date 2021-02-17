<?php

namespace App\Console\Commands;

use App\Models\Registration;
use App\Models\State;
use App\Models\County;
use Geocoder\Geocoder;
use Illuminate\Console\Command;

class PolkAddress extends Command
{

    protected $signature = 'polk:address {limit=1000} {start=135068}';

    protected $description = 'Add geocoding (latitude and longitude) to each address model';

	public function __construct()
	{
		parent::__construct();
	}

	public function handle()
	{
		$this->info("Starting address geocode...");
		$unsyncable = 0;
		//$list = Registration::take(10)->get();
		$list = Registration::whereNull('address_id')->where('id','>',$this->argument('start'))->limit($this->argument('limit'))->get();
		$geocoder = app('geocoder')->doNotCache();
		$errors = [];

		$bar = $this->output->createProgressBar($list->count());
		$bar->start();

		foreach ($list as $item) {

			try {
				$searchString = $item->address1 . ', ' . $item->city . ', ' . $item->state . ', ' . $item->zip;

				$returnObj = $geocoder->geocode($searchString)->get();

				if ($returnObj) {
					$returnData = $returnObj->first();
				} else {
					throw new \Exception;
				}

				if (!$returnData) {
					throw new \Exception;
				}

				$validData = [
					'street_number' => $returnData->getStreetNumber() ?? null,
					'street_name' => $returnData->getStreetName() ?? null,
					'line_2' => $item->address2 ?? null,
					'locality' => $returnData->getLocality() ?? null,
					'county' => $returnData->getAdminLevels()->get(2)->getCode() ? $this->getIdByName(County::class, 'name', str_replace(' County', '', $returnData->getAdminLevels()->get(2)->getCode()), 64) : null,
					'state' => $returnData->getAdminLevels()->get(1)->getCode() ? $this->getIdByName(State::class, 'abbr', $returnData->getAdminLevels()->get(1)->getCode(), 53) : null,
					'postal_code' => $returnData->getPostalCode() ?? null,
					'latitude' => $returnData->getCoordinates()->getLatitude() ?? null,
					'longitude' => $returnData->getCoordinates()->getLongitude() ?? null,
				];

				$item->syncAddress($validData);
			} catch(\Exception $e) {
				//$this->error('Something went wrong with registration '. $item->id . '!');
				$errors[] = $item->id;
				$unsyncable++;
			}

			$bar->advance();
			usleep(30000);
		}

		$bar->finish();
		$this->line("");

		$this->info("Address geocoding of " . $list->count() .  " registrations ended with " . ($list->count() - $unsyncable) . " registrations synced, leaving " . $unsyncable . " registrations without address geocoding.");
		if (!empty($errors)) {
			$this->error("Following registration IDs had issues:");
			$this->error(implode(",", $errors));
		}
		return 0;
	}

	public function getIdByName($model, $field, $name, $default)
	{
		$return = $model::where($field, '=', $name)->first();

		if ($return) {
			return $return->id;
		} else {
			return $default;
		}
	}
}
